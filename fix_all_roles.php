<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$users = App\Models\User::whereNotNull('tenant_id')->get();
foreach ($users as $user) {
    if (!$user->hasRole(App\Enums\RoleName::CharityAdmin->value)) {
        $user->assignRole(App\Enums\RoleName::CharityAdmin->value);
        echo "Fixed user {$user->email}\n";
    }
}
echo "Done\n";
