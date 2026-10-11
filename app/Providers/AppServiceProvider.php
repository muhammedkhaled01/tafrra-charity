<?php

namespace App\Providers;

use App\Models\Beneficiary;
use App\Models\Tenant;
use App\Observers\BeneficiaryObserver;
use App\Observers\TenantObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Tenant::observe(TenantObserver::class);
        Beneficiary::observe(BeneficiaryObserver::class);
    }
}
