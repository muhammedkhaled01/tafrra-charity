<?php

namespace App\Observers;

use App\Models\Tenant;
use Illuminate\Support\Facades\Cache;

class TenantObserver
{
    /**
     * Handle the Tenant "created" event.
     */
    private function clearCache(): void
    {
        Cache::forget('superadmin.dashboard.kpis');
    }

    public function created(Tenant $tenant): void
    {
        $this->clearCache();
    }

    public function updated(Tenant $tenant): void
    {
        $this->clearCache();
    }

    public function deleted(Tenant $tenant): void
    {
        $this->clearCache();
    }

    public function restored(Tenant $tenant): void
    {
        $this->clearCache();
    }

    public function forceDeleted(Tenant $tenant): void
    {
        $this->clearCache();
    }
}
