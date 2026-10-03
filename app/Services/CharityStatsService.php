<?php

namespace App\Services;

use App\Enums\ApplicationStatus;
use App\Enums\BeneficiaryCategory;
use App\Enums\BeneficiaryStatus;
use App\Enums\Gender;
use App\Enums\ProjectStatus;
use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Tenant;
use App\Services\Concerns\BuildsMonthlySeries;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Analytics for a single charity. Queries for Beneficiary/Project rely on TenantScope;
 * pivot queries filter by tenant explicitly.
 */
class CharityStatsService
{
    use BuildsMonthlySeries;

    /**
     * @return array<string, int|float|null>
     */
    public function kpis(Tenant $tenant): array
    {
        $thisMonth = CarbonImmutable::now()->startOfMonth();
        $lastMonth = $thisMonth->subMonth();

        $newThisMonth = Beneficiary::where('created_at', '>=', $thisMonth)->count();
        $newLastMonth = Beneficiary::whereBetween('created_at', [$lastMonth, $thisMonth])->count();
        $applications = $this->applicationsQuery($tenant)->selectRaw('project_beneficiary.status, count(*) as total')->groupBy('project_beneficiary.status')->pluck('total', 'status');
        $totalBeneficiaries = Beneficiary::count();
        $maxBeneficiaries = $tenant->subscription?->max_beneficiaries;

        return [
            'total_beneficiaries' => $totalBeneficiaries,
            'active_beneficiaries' => Beneficiary::where('status', BeneficiaryStatus::Active)->count(),
            'new_this_month' => $newThisMonth,
            'beneficiaries_change' => $this->percentageChange($newThisMonth, $newLastMonth),
            'total_projects' => Project::count(),
            'active_projects' => Project::where('status', ProjectStatus::Active)->count(),
            'total_budget' => (float) Project::sum('budget'),
            'approved_applications' => (int) ($applications[ApplicationStatus::Approved->value] ?? 0),
            'pending_applications' => (int) ($applications[ApplicationStatus::Pending->value] ?? 0),
            'team_members' => $tenant->users()->count(),
            'max_beneficiaries' => $maxBeneficiaries,
            'usage_percent' => ($maxBeneficiaries && $maxBeneficiaries > 0) ? (int) min(100, round($totalBeneficiaries / $maxBeneficiaries * 100)) : null,
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<float>}
     */
    public function registrationsByMonth(): array
    {
        return $this->monthlySeries(Beneficiary::query()->toBase(), 'created_at');
    }

    /**
     * @return array{labels: list<string>, values: list<float>}
     */
    public function approvalsByMonth(Tenant $tenant): array
    {
        return $this->monthlySeries(
            $this->applicationsQuery($tenant)->where('project_beneficiary.status', ApplicationStatus::Approved->value),
            'project_beneficiary.created_at',
        );
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function genderDistribution(): array
    {
        $totals = Beneficiary::selectRaw('gender, count(*) as total')->groupBy('gender')->pluck('total', 'gender');

        return [
            'labels' => array_map(fn (Gender $gender): string => $gender->label(), Gender::cases()),
            'values' => array_map(fn (Gender $gender): int => (int) ($totals[$gender->value] ?? 0), Gender::cases()),
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function categoryDistribution(): array
    {
        $totals = Beneficiary::selectRaw('category, count(*) as total')->groupBy('category')->pluck('total', 'category');

        return [
            'labels' => array_map(fn (BeneficiaryCategory $category): string => $category->label(), BeneficiaryCategory::cases()),
            'values' => array_map(fn (BeneficiaryCategory $category): int => (int) ($totals[$category->value] ?? 0), BeneficiaryCategory::cases()),
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function cityDistribution(int $limit = 8): array
    {
        $cities = Beneficiary::whereNotNull('city')
            ->selectRaw('city, count(*) as total')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit($limit)
            ->pluck('total', 'city');

        return ['labels' => $cities->keys()->all(), 'values' => $cities->values()->map(fn ($total): int => (int) $total)->all()];
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function ageGroups(): array
    {
        $today = CarbonImmutable::today();
        $groups = [
            'أقل من 18' => [0, 17],
            '18 - 30' => [18, 30],
            '31 - 45' => [31, 45],
            '46 - 60' => [46, 60],
            'أكثر من 60' => [61, 150],
        ];

        $values = [];

        foreach ($groups as [$minAge, $maxAge]) {
            $values[] = Beneficiary::whereBetween('dob', [
                $today->subYears($maxAge + 1)->addDay()->toDateString(),
                $today->subYears($minAge)->toDateString(),
            ])->count();
        }

        return ['labels' => array_keys($groups), 'values' => $values];
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function applicationStatusDistribution(Tenant $tenant): array
    {
        $totals = $this->applicationsQuery($tenant)
            ->selectRaw('project_beneficiary.status, count(*) as total')
            ->groupBy('project_beneficiary.status')
            ->pluck('total', 'status');

        return [
            'labels' => array_map(fn (ApplicationStatus $status): string => $status->label(), ApplicationStatus::cases()),
            'values' => array_map(fn (ApplicationStatus $status): int => (int) ($totals[$status->value] ?? 0), ApplicationStatus::cases()),
        ];
    }

    /**
     * @return Collection<int, Project>
     */
    public function activeProjects(int $limit = 5): Collection
    {
        return Project::where('status', ProjectStatus::Active)
            ->withCount([
                'beneficiaries',
                'beneficiaries as approved_count' => fn ($query) => $query->where('project_beneficiary.status', ApplicationStatus::Approved->value),
            ])
            ->orderBy('end_date')
            ->limit($limit)
            ->get();
    }

    /**
     * @return Collection<int, Beneficiary>
     */
    public function recentBeneficiaries(int $limit = 6): Collection
    {
        return Beneficiary::latest()->limit($limit)->get();
    }

    private function applicationsQuery(Tenant $tenant): Builder
    {
        return DB::table('project_beneficiary')
            ->join('projects', 'projects.id', '=', 'project_beneficiary.project_id')
            ->where('projects.tenant_id', $tenant->id);
    }
}
