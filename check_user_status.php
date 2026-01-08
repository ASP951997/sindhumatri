<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::find(461);
if (!$user) {
    echo "User not found\n";
    exit(1);
}

echo "ID: {$user->id}\n";
echo "Name: {$user->firstname} {$user->lastname}\n";
echo "Phone: {$user->phone}\n";
echo "Status: {$user->status}\n";

exit(0);






