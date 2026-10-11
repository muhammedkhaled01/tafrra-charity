<?php

namespace App\Models;

use App\Models\Traits\HasTenant;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory, HasTenant;

    protected $fillable = [
        'tenant_id',
        'type', // income, expense
        'donor_id',
        'beneficiary_id',
        'amount',
        'transaction_date',
        'receipt_number',
        'payment_method',
        'description',
    ];

    protected $casts = [
        'transaction_date' => 'date',
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
