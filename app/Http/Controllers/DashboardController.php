<?php

namespace App\Http\Controllers;

use App\Enums\PermissionName;
use App\Services\CharityStatsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request, CharityStatsService $stats): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isSuperAdmin()) {
            return redirect()->route('super-admin.dashboard');
        }

        abort_unless($user->can(PermissionName::ViewCharityDashboard->value) && $user->tenant, 403);

        $tenant = $user->tenant->load('subscription');

        return view('dashboard', [
            'tenant' => $tenant,
            'kpis' => $stats->kpis($tenant),
            'registrations' => $stats->registrationsByMonth(),
            'approvals' => $stats->approvalsByMonth($tenant),
            'genders' => $stats->genderDistribution(),
            'categories' => $stats->categoryDistribution(),
            'cities' => $stats->cityDistribution(),
            'ageGroups' => $stats->ageGroups(),
            'applications' => $stats->applicationStatusDistribution($tenant),
            'activeProjects' => $stats->activeProjects(),
            'recentBeneficiaries' => $stats->recentBeneficiaries(),
        ]);
    }
}
