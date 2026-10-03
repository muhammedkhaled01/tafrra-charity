<?php

namespace App\Enums;

/**
 * Every Spatie permission used by the application.
 */
enum PermissionName: string
{
    case ViewPlatformDashboard = 'platform.dashboard';
    case ManageTenants = 'tenants.manage';
    case ViewPayments = 'payments.view';
    case ManageRoles = 'roles.manage';

    case ViewCharityDashboard = 'dashboard.view';
    case ViewBeneficiaries = 'beneficiaries.view';
    case CreateBeneficiaries = 'beneficiaries.create';
    case UpdateBeneficiaries = 'beneficiaries.update';
    case DeleteBeneficiaries = 'beneficiaries.delete';
    case ViewProjects = 'projects.view';
    case CreateProjects = 'projects.create';
    case UpdateProjects = 'projects.update';
    case DeleteProjects = 'projects.delete';
    case ManageProjectBeneficiaries = 'projects.beneficiaries';
    case ExportReports = 'reports.export';
    case ManageTeam = 'team.manage';

    public function label(): string
    {
        return match ($this) {
            self::ViewPlatformDashboard => 'عرض لوحة المنصة',
            self::ManageTenants => 'إدارة الجمعيات',
            self::ViewPayments => 'عرض المدفوعات',
            self::ManageRoles => 'إدارة الأدوار والصلاحيات',
            self::ViewCharityDashboard => 'عرض لوحة الجمعية',
            self::ViewBeneficiaries => 'عرض المستفيدين',
            self::CreateBeneficiaries => 'إضافة مستفيدين',
            self::UpdateBeneficiaries => 'تعديل المستفيدين',
            self::DeleteBeneficiaries => 'حذف المستفيدين',
            self::ViewProjects => 'عرض المشاريع',
            self::CreateProjects => 'إضافة مشاريع',
            self::UpdateProjects => 'تعديل المشاريع',
            self::DeleteProjects => 'حذف المشاريع',
            self::ManageProjectBeneficiaries => 'إدارة مستفيدي المشاريع',
            self::ExportReports => 'تصدير التقارير',
            self::ManageTeam => 'إدارة فريق العمل',
        };
    }

    public function group(): string
    {
        return match ($this) {
            self::ViewPlatformDashboard, self::ManageTenants, self::ViewPayments, self::ManageRoles => 'المنصة',
            self::ViewCharityDashboard, self::ExportReports, self::ManageTeam => 'عام',
            self::ViewBeneficiaries, self::CreateBeneficiaries, self::UpdateBeneficiaries, self::DeleteBeneficiaries => 'المستفيدون',
            self::ViewProjects, self::CreateProjects, self::UpdateProjects, self::DeleteProjects, self::ManageProjectBeneficiaries => 'المشاريع',
        };
    }

    public function scope(): RoleScope
    {
        return match ($this) {
            self::ViewPlatformDashboard, self::ManageTenants, self::ViewPayments, self::ManageRoles => RoleScope::Platform,
            default => RoleScope::Charity,
        };
    }

    /**
     * @return list<self>
     */
    public static function forScope(RoleScope $scope): array
    {
        return array_values(array_filter(self::cases(), fn (self $permission): bool => $permission->scope() === $scope));
    }
}
