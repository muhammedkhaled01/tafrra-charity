<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            SubscriptionSeeder::class,
            SuperAdminSeeder::class,
        ]);

        if (app()->environment('local')) {
            $this->call(DemoDataSeeder::class);
        }
    }
}
