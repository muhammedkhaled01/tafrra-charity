<?php

use App\Enums\ApplicationStatus;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\SubscriptionRequestController;
use App\Http\Controllers\SuperAdmin;
// use App\Http\Controllers\TeamController;
use App\Http\Controllers\TenantSettingsController;
use App\Http\Controllers\TransactionController;
use App\Models\Beneficiary;
use App\Models\Project;
use App\Models\Scopes\TenantScope;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', function () {
    $stats = [
        'charities' => Tenant::count() + 1500,
        'beneficiaries' => Beneficiary::withoutGlobalScope(TenantScope::class)->count(),
        'projects' => Project::withoutGlobalScope(TenantScope::class)->count(),
        'approved' => DB::table('project_beneficiary')->where('status', ApplicationStatus::Approved->value)->count(),
    ];

    return view('about', compact('stats'));
})->name('about');

Route::get('/subscribe/{subscription}', [SubscriptionRequestController::class, 'create'])->name('subscribe');
Route::post('/subscribe/{subscription}', [SubscriptionRequestController::class, 'store'])->name('subscribe.store');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Charity (tenant) area
Route::middleware(['auth', 'subscription.active'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::middleware('feature:beneficiaries')->group(function () {
        Route::resource('beneficiaries', BeneficiaryController::class);
    });

    Route::middleware('feature:donors')->group(function () {
        Route::resource('donors', DonorController::class);
    });

    Route::middleware('feature:sponsorships')->group(function () {
        Route::resource('sponsorships', SponsorshipController::class);
    });

    Route::middleware('feature:transactions')->group(function () {
        Route::resource('transactions', TransactionController::class);
    });

    Route::middleware('feature:projects')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::post('projects/{project}/beneficiaries', [ProjectController::class, 'storeBeneficiary'])->name('projects.beneficiaries.store');
        Route::post('projects/{project}/attach-beneficiaries', [ProjectController::class, 'attachBeneficiaries'])->name('projects.beneficiaries.attach');
        Route::patch('projects/{project}/beneficiaries/{beneficiary}/status', [ProjectController::class, 'updateBeneficiaryStatus'])->name('projects.beneficiaries.update_status');
    });

    Route::middleware('feature:exports')->group(function () {
        Route::get('exports/beneficiaries', [ExportController::class, 'exportBeneficiaries'])->name('exports.beneficiaries');
    });

    Route::middleware('feature:documents')->group(function () {
        Route::resource('documents', DocumentController::class);
        Route::get('documents/{document}/pdf', [DocumentController::class, 'pdf'])->name('documents.pdf');
    });

    Route::get('settings', [TenantSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [TenantSettingsController::class, 'update'])->name('settings.update');

    // Route::resource('team', TeamController::class)->except('show')->parameters(['team' => 'member']);
});

// Subscription Expired Route
Route::get('/subscription-expired', function () {
    return view('subscription-expired');
})->middleware('auth')->name('subscription.expired');

// Super Admin Routes
Route::prefix('super-admin')->name('super-admin.')->middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/dashboard', [SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('tenants', SuperAdmin\TenantController::class);
    Route::get('payments', [SuperAdmin\PaymentController::class, 'index'])->name('payments.index');
    Route::resource('roles', SuperAdmin\RoleController::class);
    Route::post('roles/{role}/users', [SuperAdmin\RoleController::class, 'assignUser'])->name('roles.users.store');
    Route::delete('roles/{role}/users/{user}', [SuperAdmin\RoleController::class, 'removeUser'])->name('roles.users.destroy');

    Route::resource('users', SuperAdmin\UserController::class)->except(['show']);
    Route::resource('subscriptions', SuperAdmin\SubscriptionController::class)->except(['show']);

    Route::get('subscription-requests', [SuperAdmin\SubscriptionRequestController::class, 'index'])->name('subscription-requests.index');
    Route::get('subscription-requests/{subscriptionRequest}', [SuperAdmin\SubscriptionRequestController::class, 'show'])->name('subscription-requests.show');
    Route::post('subscription-requests/{subscriptionRequest}/approve', [SuperAdmin\SubscriptionRequestController::class, 'approve'])->name('subscription-requests.approve');
    Route::post('subscription-requests/{subscriptionRequest}/reject', [SuperAdmin\SubscriptionRequestController::class, 'reject'])->name('subscription-requests.reject');

    Route::get('settings/seo', [SuperAdmin\SettingsController::class, 'seo'])->name('settings.seo');
    Route::post('settings/seo', [SuperAdmin\SettingsController::class, 'updateSeo'])->name('settings.seo.update');
});
