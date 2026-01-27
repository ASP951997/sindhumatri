<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Verifying deletion of all Rahul Waghole users...\n\n";

// Check if any users with name rahul waghole still exist
$remainingUsers = User::where(function($query) {
    $query->whereRaw('LOWER(firstname) = ?', ['rahul'])
          ->whereRaw('LOWER(lastname) = ?', ['waghole']);
})->get();

if ($remainingUsers->count() > 0) {
    echo "❌ Found {$remainingUsers->count()} user(s) still remaining:\n";
    foreach ($remainingUsers as $user) {
        echo "  - ID: {$user->id}, Username: {$user->username}, Email: {$user->email}\n";
    }
} else {
    echo "✅ All Rahul Waghole users have been successfully deleted!\n";
    echo "   No users found with name 'rahul waghole'\n";
}

echo "\nVerification completed.\n";










