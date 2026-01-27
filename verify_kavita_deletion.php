<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Verifying deletion of user 'KAVITA BHAMBHANI'...\n\n";

// Check if user still exists (case insensitive)
$user = User::where(function($query) {
    $query->whereRaw('LOWER(firstname) = ?', ['kavita'])
          ->whereRaw('LOWER(lastname) = ?', ['bhamphani']);
})->orWhere(function($query) {
    $query->whereRaw('LOWER(firstname) = ?', ['kavita'])
          ->whereRaw('LOWER(lastname) = ?', ['bhamphani']);
})->first();

if ($user) {
    echo "❌ User still exists:\n";
    echo "  ID: {$user->id}\n";
    echo "  Name: {$user->firstname} {$user->lastname}\n";
    echo "  Username: {$user->username}\n";
    echo "  Email: {$user->email}\n";
} else {
    echo "✅ User 'KAVITA BHAMBHANI' has been successfully deleted!\n";
    echo "   No user found with this name in the database.\n";
}

echo "\nVerification completed.\n";










