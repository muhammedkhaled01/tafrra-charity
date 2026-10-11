<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'tenant_id',
        'title',
        'reference_number',
        'document_date',
        'attachments_text',
        'subject',
        'content',
        'signatures',
    ];

    protected $casts = [
        'document_date' => 'date',
        'signatures' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
