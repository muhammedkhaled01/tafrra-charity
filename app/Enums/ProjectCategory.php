<?php

namespace App\Enums;

enum ProjectCategory: string
{
    case FoodBaskets = 'food';
    case Education = 'education';
    case Healthcare = 'healthcare';
    case Housing = 'housing';
    case Seasonal = 'seasonal';
    case CashAid = 'cash';

    public function label(): string
    {
        return match ($this) {
            self::FoodBaskets => 'سلال غذائية',
            self::Education => 'تعليم',
            self::Healthcare => 'رعاية صحية',
            self::Housing => 'إسكان وترميم',
            self::Seasonal => 'مشاريع موسمية',
            self::CashAid => 'مساعدات نقدية',
        };
    }
}
