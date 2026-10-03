<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'مدير المنصة',
                'password' => Hash::make('123456789'),
                // tenant_id is nullable and remains null for the global Super Admin
            ]
        );

        $superAdmin->syncRoles([RoleName::SuperAdmin->value]);
    }
}
