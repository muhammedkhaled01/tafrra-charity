<?php

namespace App\Observers;

use App\Models\Beneficiary;
use Illuminate\Support\Facades\Cache;

class BeneficiaryObserver
{
    /**
     * Handle the Beneficiary "created" event.
     */
    private function clearCache(): void
    {
        Cache::forget('superadmin.dashboard.kpis');
    }

    public function created(Beneficiary $beneficiary): void
    {
        $this->clearCache();
    }

    public function updated(Beneficiary $beneficiary): void
    {
        $this->clearCache();
    }

    public function deleted(Beneficiary $beneficiary): void
    {
        $this->clearCache();
    }

    public function restored(Beneficiary $beneficiary): void
    {
        $this->clearCache();
    }

    public function forceDeleted(Beneficiary $beneficiary): void
    {
        $this->clearCache();
    }
}
