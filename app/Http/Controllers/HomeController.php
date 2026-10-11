<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatus;
use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Scopes\TenantScope;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $plans = Subscription::orderBy('price')->get();

        $stats = [
            'charities' => Tenant::count() + 1500, // Adding 1500 to reflect the 1500 charities mentioned in 'About Us'
            'beneficiaries' => Beneficiary::withoutGlobalScope(TenantScope::class)->count(),
            'projects' => Project::withoutGlobalScope(TenantScope::class)->count(),
            'approved' => DB::table('project_beneficiary')->where('status', ApplicationStatus::Approved->value)->count(),
        ];

        return view('welcome', compact('plans', 'stats'));
    }
}
