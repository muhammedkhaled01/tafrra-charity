<?php

namespace Database\Seeders;

use App\Enums\PermissionName;
use App\Enums\RoleName;
use App\Enums\RoleScope;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (PermissionName::cases() as $permission) {
            Permission::findOrCreate($permission->value, 'web');
        }

        $rolePermissions = [
            RoleName::SuperAdmin->value => PermissionName::forScope(RoleScope::Platform),
            RoleName::CharityAdmin->value => PermissionName::forScope(RoleScope::Charity),
            RoleName::CharityStaff->value => [
                PermissionName::ViewCharityDashboard,
                PermissionName::ViewBeneficiaries,
                PermissionName::CreateBeneficiaries,
                PermissionName::UpdateBeneficiaries,
                PermissionName::ViewProjects,
                PermissionName::ManageProjectBeneficiaries,
                PermissionName::ExportReports,
            ],
            RoleName::CharityViewer->value => [
                PermissionName::ViewCharityDashboard,
                PermissionName::ViewBeneficiaries,
                PermissionName::ViewProjects,
            ],
        ];

        foreach (RoleName::cases() as $roleName) {
            $role = Role::findOrCreate($roleName->value, 'web');
            $role->forceFill([
                'label' => $roleName->label(),
                'scope' => $roleName->scope()->value,
            ])->save();

            $role->syncPermissions(array_map(
                fn (PermissionName $permission): string => $permission->value,
                $rolePermissions[$roleName->value],
            ));
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
