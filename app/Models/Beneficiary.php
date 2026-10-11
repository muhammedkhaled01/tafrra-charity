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
        'first_name',
        'father_name',
        'grandfather_name',
        'family_name',
        'gender',
        'marital_status',
        'phone',
        'dob',
        'city',
        'neighborhood',
        'family_members',
        'monthly_income',
        'category',
        'status',
        'notes',
        'goals',
    ];

    protected $casts = [
        'gender' => Gender::class,
        'category' => BeneficiaryCategory::class,
        'status' => BeneficiaryStatus::class,
        'monthly_income' => 'decimal:2',
        'family_members' => 'integer',
    ];

    public function getAgeAttribute(): int
    {
        if (! $this->dob) {
            return 0;
        }

        $parts = explode('-', $this->dob);
        if (count($parts) !== 3) {
            return 0;
        }

        $hijriYear = (int) $parts[0];

        // Approximate current Hijri year (Current Gregorian - 622 + (Current Gregorian - 622) / 32)
        $currentYear = (int) date('Y');
        $currentHijriYear = (int) (($currentYear - 622) + (($currentYear - 622) / 32));

        return max(0, $currentHijriYear - $hijriYear);
    }

    public function getNameAttribute(): string
    {
        return implode(' ', array_filter([
            $this->first_name,
            $this->father_name,
            $this->grandfather_name,
            $this->family_name,
        ]));
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_beneficiary')
            ->withPivot('status')
            ->withTimestamps();
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }

    /**
     * Search by name, national ID or phone.
     *
     * @param  Builder<Beneficiary>  $query
     */
    public function scopeSearch(Builder $query, ?string $term): void
    {
        $term = trim((string) $term);

        if ($term === '') {
            return;
        }

        $escapedTerm = addcslashes($term, '\\%_');

        // Phone / ID input: national ID (index-friendly prefix match) or phone; skip the expensive name scan.
        if (preg_match('/^[\d\s+\-]+$/', $term) === 1) {
            $query->where(function (Builder $query) use ($escapedTerm): void {
                $query->where('national_id', 'like', "{$escapedTerm}%")
                    ->orWhere('phone', 'like', "%{$escapedTerm}%");
            });

            return;
        }

        $query->whereRaw(
            "CONCAT_WS(' ', first_name, father_name, grandfather_name, family_name) LIKE ?",
            ["%{$escapedTerm}%"]
        );
    }
}
