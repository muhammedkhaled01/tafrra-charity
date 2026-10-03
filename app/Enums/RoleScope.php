<?php

namespace App\Enums;

/**
 * Whether a role belongs to the platform owners or to charity (tenant) teams.
 */
enum RoleScope: string
{
    case Platform = 'platform';
    case Charity = 'charity';

    public function label(): string
    {
        return match ($this) {
            self::Platform => 'إدارة المنصة',
            self::Charity => 'الجمعيات',
        };
    }
}
