<?php

namespace App\Services;

use App\Exceptions\SubscriptionLimitExceededException;
use App\Models\Beneficiary;

class BeneficiaryService
{
    /**
     * Create a new Beneficiary
     * 
     * @throws SubscriptionLimitExceededException
     */
    public function create(array $data): Beneficiary
    {
        // Enforce subscription limits
        $tenant = auth()->user()->tenant;
        
        if ($tenant && $tenant->subscription) {
            $max = $tenant->subscription->max_beneficiaries;
            
            // Check if there is a limit (max != -1)
            if ($max !== -1) {
                // TenantScope automatically filters by the current tenant
                $currentCount = Beneficiary::count();
                
                if ($currentCount >= $max) {
                    throw new SubscriptionLimitExceededException();
                }
            }
        }

        // The HasTenant trait automatically sets the tenant_id on creation
        return Beneficiary::create($data);
    }

    /**
     * Update an existing Beneficiary
     */
    public function update(Beneficiary $beneficiary, array $data): bool
    {
        return $beneficiary->update($data);
    }

    /**
     * Delete a Beneficiary
     */
    public function delete(Beneficiary $beneficiary): bool|null
    {
        return $beneficiary->delete();
    }
}
