<?php

namespace App\Enums;

enum SubscriptionFeature: string
{
    case BENEFICIARIES = 'beneficiaries';
    case DONORS = 'donors';
    case PROJECTS = 'projects';
    case SPONSORSHIPS = 'sponsorships';
    case TRANSACTIONS = 'transactions';
    case DOCUMENTS = 'documents';
    case EXPORTS = 'exports';
    case TEAM_MANAGEMENT = 'team_management';

    public function label(): string
    {
        return match ($this) {
            self::BENEFICIARIES => 'إدارة المستفيدين',
            self::DONORS => 'إدارة الداعمين والجهات المانحة',
            self::PROJECTS => 'إدارة المشاريع التنموية',
            self::SPONSORSHIPS => 'نظام الكفالات (أيتام، أسر، إلخ)',
            self::TRANSACTIONS => 'السندات المالية (القبض والصرف)',
            self::DOCUMENTS => 'نظام الوكالات والخطابات',
            self::EXPORTS => 'تصدير التقارير (Excel / PDF)',
            self::TEAM_MANAGEMENT => 'إدارة فريق العمل والصلاحيات',
        };
    }
}
