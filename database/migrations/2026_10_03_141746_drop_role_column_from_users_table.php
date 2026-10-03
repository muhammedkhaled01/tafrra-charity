<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Move the legacy `users.role` enum into Spatie roles, then drop the column.
     */
    public function up(): void
    {
        $legacyRoleMap = [
            'super_admin' => 'super_admin',
            'admin' => 'charity_admin',
            'staff' => 'charity_staff',
        ];

        $rolesTable = config('permission.table_names.roles', 'roles');
        $pivotTable = config('permission.table_names.model_has_roles', 'model_has_roles');

        foreach ($legacyRoleMap as $legacyRole => $spatieRole) {
            $userIds = DB::table('users')->where('role', $legacyRole)->pluck('id');

            if ($userIds->isEmpty()) {
                continue;
            }

            $roleId = DB::table($rolesTable)->where(['name' => $spatieRole, 'guard_name' => 'web'])->value('id')
                ?? DB::table($rolesTable)->insertGetId([
                    'name' => $spatieRole,
                    'guard_name' => 'web',
                    'scope' => $spatieRole === 'super_admin' ? 'platform' : 'charity',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            DB::table($pivotTable)->insertOrIgnore($userIds->map(fn (int $userId): array => [
                'role_id' => $roleId,
                'model_type' => 'App\\Models\\User',
                'model_id' => $userId,
            ])->all());
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin', 'staff'])->default('staff')->after('password');
        });
    }
};
