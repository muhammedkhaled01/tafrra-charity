<?php

namespace App\Services;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Beneficiary;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Scopes\TenantScope;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use App\Services\Concerns\BuildsMonthlySeries;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;

class PlatformStatsService
{
    use BuildsMonthlySeries;

    /**
     * @return array<string, int|float>
     */
    public function kpis(): array
    {
        $thisMonth = CarbonImmutable::now()->startOfMonth();
        $lastMonth = $thisMonth->subMonth();

        $revenueThisMonth = (float) Payment::where('status', PaymentStatus::Paid)->where('paid_at', '>=', $thisMonth)->sum('amount');
        $revenueLastMonth = (float) Payment::where('status', PaymentStatus::Paid)->whereBetween('paid_at', [$lastMonth, $thisMonth])->sum('amount');

        $beneficiaries = Beneficiary::withoutGlobalScope(TenantScope::class);
        $newBeneficiaries = (clone $beneficiaries)->where('created_at', '>=', $thisMonth)->count();
        $previousBeneficiaries = (clone $beneficiaries)->whereBetween('created_at', [$lastMonth, $thisMonth])->count();

        $activeTenants = Tenant::where('is_active', true)->where('subscription_expires_at', '>', now());

        return [
            'total_charities' => Tenant::count(),
            'active_charities' => (clone $activeTenants)->count(),
            'total_beneficiaries' => $beneficiaries->count(),
            'new_beneficiaries' => $newBeneficiaries,
            'beneficiaries_change' => $this->percentageChange($newBeneficiaries, $previousBeneficiaries),
            'total_projects' => Project::withoutGlobalScope(TenantScope::class)->count(),
            'total_users' => User::count(),
            'mrr' => (float) (clone $activeTenants)->join('subscriptions', 'tenants.subscription_id', '=', 'subscriptions.id')->sum('subscriptions.price'),
            'revenue_this_month' => $revenueThisMonth,
            'revenue_change' => $this->percentageChange($revenueThisMonth, $revenueLastMonth),
            'expiring_soon' => (clone $activeTenants)->where('subscription_expires_at', '<=', now()->addDays(30))->count(),
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<float>}
     */
    public function revenueByMonth(): array
    {
        return $this->monthlySeries(Payment::where('status', PaymentStatus::Paid)->toBase(), 'paid_at', 'sum(amount)');
    }

    /**
     * @return array{labels: list<string>, values: list<float>}
     */
    public function beneficiariesByMonth(): array
    {
        return $this->monthlySeries(Beneficiary::withoutGlobalScope(TenantScope::class)->toBase(), 'created_at');
    }

    /**
     * @return array{labels: list<string>, values: list<float>}
     */
    public function charitiesByMonth(): array
    {
        return $this->monthlySeries(Tenant::query()->toBase(), 'created_at');
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function planDistribution(): array
    {
        $plans = Subscription::withCount('tenants')->orderBy('price')->get();

        return [
            'labels' => $plans->pluck('name')->all(),
            'values' => $plans->pluck('tenants_count')->all(),
        ];
    }

    /**
     * @return array{labels: list<string>, values: list<int>}
     */
    public function charitiesByCity(int $limit = 7): array
    {
        $cities = Tenant::whereNotNull('city')
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
    public function paymentMethods(): array
    {
        $totals = Payment::where('status', PaymentStatus::Paid)
            ->selectRaw('method, count(*) as total')
            ->groupBy('method')
            ->pluck('total', 'method');

        return [
            'labels' => array_map(fn (PaymentMethod $method): string => $method->label(), PaymentMethod::cases()),
            'values' => array_map(fn (PaymentMethod $method): int => (int) ($totals[$method->value] ?? 0), PaymentMethod::cases()),
        ];
    }

    /**
     * @return Collection<int, Tenant>
     */
    public function topCharities(int $limit = 6): Collection
    {
        return Tenant::with('subscription')
            ->withCount(['beneficiaries', 'projects'])
            ->orderByDesc('beneficiaries_count')
            ->limit($limit)
            ->get();
    }

    /**
     * @return Collection<int, Tenant>
     */
    public function expiringSoon(int $days = 30, int $limit = 6): Collection
    {
        return Tenant::with('subscription')
            ->where('is_active', true)
            ->whereBetween('subscription_expires_at', [now(), now()->addDays($days)])
            ->orderBy('subscription_expires_at')
            ->limit($limit)
            ->get();
    }

    /**
     * @return Collection<int, Payment>
     */
    public function recentPayments(int $limit = 7): Collection
    {
        return Payment::with(['tenant', 'subscription'])->latest()->limit($limit)->get();
    }
}
