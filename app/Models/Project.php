<?php

namespace App\Models;

use App\Enums\ProjectCategory;
use App\Enums\ProjectStatus;
use App\Models\Traits\HasTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    use HasFactory, HasTenant;

    protected $fillable = [
        'tenant_id',
        'title',
        'description',
        'category',
        'budget',
        'start_date',
        'end_date',
        'status', // planned, active, completed
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => ProjectStatus::class,
        'category' => ProjectCategory::class,
        'budget' => 'decimal:2',
    ];

    public function beneficiaries(): BelongsToMany
    {
        return $this->belongsToMany(Beneficiary::class, 'project_beneficiary')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Percentage of the project timeline that has elapsed (0-100).
     */
    public function progress(): int
    {
        if ($this->status === ProjectStatus::Completed) {
            return 100;
        }

        if (! $this->start_date || ! $this->end_date || $this->start_date->isFuture()) {
            return 0;
        }

        $totalDays = max(1, $this->start_date->diffInDays($this->end_date));
        $elapsedDays = $this->start_date->diffInDays(now());

        return (int) min(100, round($elapsedDays / $totalDays * 100));
    }
}
