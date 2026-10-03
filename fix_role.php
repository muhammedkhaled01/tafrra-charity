<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = App\Models\User::where('email', 'm@m.com')->first();
if ($user) {
    $user->assignRole(App\Enums\RoleName::CharityAdmin->value);
    echo "Fixed user {$user->email}\n";
} else {
    echo "User not found\n";
}
