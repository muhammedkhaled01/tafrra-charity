<?php

use App\Enums\RoleName;
use App\Models\User;
use Illuminate\Contracts\Console\Kernel;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$user = User::where('email', 'm@m.com')->first();
if ($user) {
    $user->assignRole(RoleName::CharityAdmin->value);
    echo "Fixed user {$user->email}\n";
} else {
    echo "User not found\n";
}
