<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

try {
    $user = User::find(461);
    if ($user) {
        echo "Testing partner education update with ID 5 (Bachelor's Degree)...\n";
        $user->partner_education = 5;
        $user->save();
        echo "✅ Update successful! partner_education = " . $user->partner_education . "\n";
    } else {
        echo "❌ User not found\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}









