<?php

namespace App\Enums;

enum BeneficiaryStatus: string
{
    case Active = 'active';
    case UnderReview = 'under_review';
    case Inactive = 'inactive';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'نشط',
            self::UnderReview => 'قيد الدراسة',
            self::Inactive => 'موقوف',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Active => 'emerald',
            self::UnderReview => 'amber',
            self::Inactive => 'slate',
        };
    }
}
