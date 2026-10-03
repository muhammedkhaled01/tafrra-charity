<?php

namespace App\Enums;

enum BeneficiaryCategory: string
{
    case Orphans = 'orphans';
    case Widows = 'widows';
    case LowIncomeFamilies = 'low_income';
    case PeopleWithDisabilities = 'disabled';
    case Elderly = 'elderly';
    case Students = 'students';

    public function label(): string
    {
        return match ($this) {
            self::Orphans => 'أيتام',
            self::Widows => 'أرامل ومطلقات',
            self::LowIncomeFamilies => 'أسر محدودة الدخل',
            self::PeopleWithDisabilities => 'ذوو الإعاقة',
            self::Elderly => 'كبار السن',
            self::Students => 'طلاب علم',
        };
    }
}
