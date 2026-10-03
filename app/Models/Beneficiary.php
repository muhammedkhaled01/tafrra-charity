<?php

namespace App\Models;

use App\Enums\BeneficiaryCategory;
use App\Enums\BeneficiaryStatus;
use App\Enums\Gender;
use App\Models\Traits\HasTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

class Beneficiary extends Model
{
    use HasFactory, HasTenant, Notifiable;

    protected $fillable = [
        'tenant_id',
        'national_id',
        'name',
        'gender',
        'phone',
        'dob',
        'city',
        'family_members',
        'monthly_income',
        'category',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'gender' => Gender::class,
        'category' => BeneficiaryCategory::class,
        'status' => BeneficiaryStatus::class,
        'monthly_income' => 'decimal:2',
        'family_members' => 'integer',
    ];

    public function getAgeAttribute(): int
    {
        return $this->dob ? $this->dob->age : 0;
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_beneficiary')
            ->withPivot('status')
            ->withTimestamps();
    }

    /**
     * Search by name, national ID or phone.
     *
     * @param  Builder<Beneficiary>  $query
     */
    public function scopeSearch(Builder $query, ?string $term): void
    {
        if (blank($term)) {
            return;
        }

        $query->where(function (Builder $query) use ($term): void {
            $query->where('name', 'like', "%{$term}%")
                ->orWhere('national_id', 'like', "{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
        });
    }
}
