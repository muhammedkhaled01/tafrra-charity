<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionRequest extends Model
{
    protected $fillable = [
        'subscription_id',
        'charity_name',
        'manager_name',
        'email',
        'phone',
        'password',
        'transfer_receipt',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
