<?php

namespace App\Models;

use App\Models\Traits\HasTenant;
use Database\Factories\SponsorshipFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sponsorship extends Model
{
    /** @use HasFactory<SponsorshipFactory> */
    use HasFactory, HasTenant;

    protected $fillable = [
        'tenant_id',
        'donor_id',
        'beneficiary_id',
        'amount',
        'start_date',
        'end_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }
}
