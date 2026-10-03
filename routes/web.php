<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SuperAdmin;
// use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
});
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Charity (tenant) area
Route::middleware(['auth', 'subscription.active'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::resource('beneficiaries', BeneficiaryController::class);

    Route::resource('projects', ProjectController::class);
    Route::post('projects/{project}/beneficiaries', [ProjectController::class, 'storeBeneficiary'])->name('projects.beneficiaries.store');
    Route::post('projects/{project}/attach-beneficiaries', [ProjectController::class, 'attachBeneficiaries'])->name('projects.beneficiaries.attach');
    Route::patch('projects/{project}/beneficiaries/{beneficiary}/status', [ProjectController::class, 'updateBeneficiaryStatus'])->name('projects.beneficiaries.update_status');

    Route::get('exports/beneficiaries', [ExportController::class, 'exportBeneficiaries'])->name('exports.beneficiaries');

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
    Route::resource('roles', SuperAdmin\RoleController::class)->except('show');
});
