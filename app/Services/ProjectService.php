<?php

namespace App\Services;

use App\Models\Beneficiary;
use App\Models\Project;

class ProjectService
{
    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function update(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    public function delete(Project $project): bool|null
    {
        return $project->delete();
    }

    /**
     * Attach a beneficiary to a project with an initial status
     */
    public function attachBeneficiary(Project $project, Beneficiary $beneficiary, string $status = 'pending'): void
    {
        // Avoid duplicate attachments using syncWithoutDetaching
        $project->beneficiaries()->syncWithoutDetaching([
            $beneficiary->id => ['status' => $status]
        ]);
    }

    /**
     * Update the approval status of a beneficiary within a specific project
     */
    public function updateBeneficiaryStatus(Project $project, Beneficiary $beneficiary, string $status): void
    {
        $project->beneficiaries()->updateExistingPivot($beneficiary->id, [
            'status' => $status,
        ]);

        // If approved and the tenant has the WhatsApp feature, send the notification
        if ($status === 'approved') {
            $tenant = auth()->user()->tenant;
            if ($tenant && $tenant->hasFeature('whatsapp_api')) {
                $beneficiary->notify(new \App\Notifications\BeneficiaryApprovedNotification($project));
            }
        }
    }
}
