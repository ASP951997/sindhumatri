<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Checking all users with name Rahul Waghole...\n\n";

// Find all users with this name
$users = User::where('firstname', 'Rahul')
             ->where('lastname', 'Waghole')
             ->get();

if ($users->count() > 0) {
    foreach ($users as $user) {
        echo "Found user: ID {$user->id}, Username: {$user->username}, Email: {$user->email}, Created: {$user->created_at}\n";
    }
} else {
    echo "No users found with name Rahul Waghole\n";
}

echo "\nCheck completed.\n";










