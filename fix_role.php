<?php

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$user = User::where('email', 'mohamedkhaled667.mk@gmail.com')->first();
if ($user) {
    $user->assignRole(RoleName::SuperAdmin->value);
    echo "Fixed user {$user->email} with role: ".$user->getRoleNames()->implode(', ')."\n";
} else {
    echo "User not found\n";
}
