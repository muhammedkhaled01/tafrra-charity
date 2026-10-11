<?php

namespace App\Models;

use App\Enums\SubscriptionFeature;
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
        'stamp',
        'signatures',
        'license_number',
        'subscription_id',
        'subscription_expires_at',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'subscription_expires_at' => 'datetime',
        'signatures' => 'array',
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

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function donors(): HasMany
    {
        return $this->hasMany(Donor::class);
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
    public function hasFeature(string|SubscriptionFeature $feature): bool
    {
        $subscription = $this->subscription;

        if (! $subscription) {
            return false;
        }

        $featureName = $feature instanceof SubscriptionFeature ? $feature->value : $feature;
        $features = $subscription->features ?? [];

        return isset($features[$featureName]) && (bool) $features[$featureName];
    }
}
