<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'قيد المراجعة',
            self::Approved => 'مقبول',
            self::Rejected => 'مرفوض',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Pending => 'amber',
            self::Approved => 'emerald',
            self::Rejected => 'rose',
        };
    }
}
