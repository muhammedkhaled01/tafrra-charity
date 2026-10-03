<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'domain',
        'email',
        'phone',
        'city',
        'logo',
        'subscription_id',
        'subscription_expires_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscription_expires_at' => 'datetime',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function beneficiaries(): HasMany
    {
        return $this->hasMany(Beneficiary::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->is_active
            && $this->subscription_expires_at !== null
            && $this->subscription_expires_at->isFuture();
    }

    /**
     * Whether the subscription expires within the given number of days.
     */
    public function isExpiringSoon(int $days = 30): bool
    {
        return $this->hasActiveSubscription()
            && $this->subscription_expires_at->lte(now()->addDays($days));
    }

    /**
     * Check if the tenant's subscription includes a specific feature.
     */
    public function hasFeature(string $featureName): bool
    {
        $subscription = $this->subscription;
        
        if (!$subscription) {
            return false;
        }

        $features = $subscription->features ?? [];
        
        return isset($features[$featureName]) && $features[$featureName] === true;
    }
}
