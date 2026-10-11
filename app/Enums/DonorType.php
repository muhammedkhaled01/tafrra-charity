<?php

namespace App\Enums;

enum DonorType: string
{
    case INDIVIDUAL = 'individual';
    case ORGANIZATION = 'organization';
    case COMPANY = 'company';
    case GOVERNMENT = 'government';
    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::INDIVIDUAL => 'فرد',
            self::ORGANIZATION => 'مؤسسة / جهة خيرية',
            self::COMPANY => 'شركة تجارية',
            self::GOVERNMENT => 'جهة حكومية',
            self::OTHER => 'أخرى',
        };
    }
}
