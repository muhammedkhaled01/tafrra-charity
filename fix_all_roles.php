<?php

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$users = User::whereNotNull('tenant_id')->get();
foreach ($users as $user) {
    if (! $user->hasRole(RoleName::CharityAdmin->value)) {
        $user->assignRole(RoleName::CharityAdmin->value);
        echo "Fixed user {$user->email}\n";
    }
}
echo "Done\n";
