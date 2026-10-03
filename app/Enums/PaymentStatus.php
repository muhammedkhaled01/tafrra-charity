<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Paid = 'paid';
    case Pending = 'pending';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Paid => 'مدفوع',
            self::Pending => 'معلق',
            self::Failed => 'فشل',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Paid => 'emerald',
            self::Pending => 'amber',
            self::Failed => 'rose',
        };
    }
}
