<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Scopes\TenantScope;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $plans = Subscription::orderBy('price')->get();

        $stats = Cache::remember('home.stats', now()->addMinutes(10), fn (): array => [
            'charities' => Tenant::count(),
            'beneficiaries' => Beneficiary::withoutGlobalScope(TenantScope::class)->count(),
            'projects' => Project::withoutGlobalScope(TenantScope::class)->count(),
            'approved' => DB::table('project_beneficiary')->where('status', ApplicationStatus::Approved->value)->count(),
        ]);

        return view('welcome', compact('plans', 'stats'));
    }
}
