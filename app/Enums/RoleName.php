<?php

namespace App\Enums;

/**
 * System roles that are seeded by default and cannot be deleted.
 */
enum RoleName: string
{
    case SuperAdmin = 'super_admin';
    case CharityAdmin = 'charity_admin';
    case CharityStaff = 'charity_staff';
    case CharityViewer = 'charity_viewer';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'مدير المنصة',
            self::CharityAdmin => 'مدير الجمعية',
            self::CharityStaff => 'موظف الجمعية',
            self::CharityViewer => 'مراقب (عرض فقط)',
        };
    }

    public function scope(): RoleScope
    {
        return $this === self::SuperAdmin ? RoleScope::Platform : RoleScope::Charity;
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
