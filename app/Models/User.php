<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\RoleName;
use App\Enums\RoleScope;
use App\Enums\SubscriptionFeature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function isSuperAdmin(): bool
    {
        if ($this->hasRole(RoleName::SuperAdmin->value)) {
            return true;
        }

        return $this->tenant_id === null && $this->roles->contains(fn ($role) => $role->scope === RoleScope::Platform->value);
    }

    /**
     * Arabic label of the user's primary role, for display.
     */
    public function roleLabel(): string
    {
        $role = $this->roles->first();

        return $role?->label ?? $role?->name ?? '—';
    }

    /**
     * Check if the user's tenant has a specific subscription feature.
     * Super admins have access to all features.
     */
    public function hasFeature(string|SubscriptionFeature $feature): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return (bool) $this->tenant?->hasFeature($feature);
    }

    /**
     * Two-letter initials used for avatars.
     */
    public function initials(): string
    {
        $words = preg_split('/\s+/u', trim($this->name)) ?: [];

        return collect($words)->take(2)->map(fn (string $word): string => mb_substr($word, 0, 1))->implode('');
    }
}
