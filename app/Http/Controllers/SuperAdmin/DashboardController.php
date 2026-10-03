<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Services\PlatformStatsService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(PlatformStatsService $stats): View
    {
        return view('super-admin.dashboard', [
            'kpis' => $stats->kpis(),
            'revenue' => $stats->revenueByMonth(),
            'beneficiaryGrowth' => $stats->beneficiariesByMonth(),
            'charityGrowth' => $stats->charitiesByMonth(),
            'plans' => $stats->planDistribution(),
            'cities' => $stats->charitiesByCity(),
            'paymentMethods' => $stats->paymentMethods(),
            'topCharities' => $stats->topCharities(),
            'expiringSoon' => $stats->expiringSoon(),
            'recentPayments' => $stats->recentPayments(),
        ]);
    }
}
