<?php

namespace App\Models;

use App\Enums\DonorType;
use App\Models\Traits\HasTenant;
use Database\Factories\DonorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    /** @use HasFactory<DonorFactory> */
    use HasFactory, HasTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'phone',
        'email',
        'identity_number',
        'donor_type',
        'status',
        'address',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'donor_type' => DonorType::class,
        ];
    }

    public function sponsorships()
    {
        return $this->hasMany(Sponsorship::class);
    }
}
