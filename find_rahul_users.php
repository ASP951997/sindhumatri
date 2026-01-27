<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Finding all users with name 'rahul waghole'...\n\n";

// Find all users with this name (case insensitive)
$users = User::where(function($query) {
    $query->whereRaw('LOWER(firstname) = ?', ['rahul'])
          ->whereRaw('LOWER(lastname) = ?', ['waghole']);
})->get();

if ($users->count() > 0) {
    echo "Found {$users->count()} user(s) with name 'rahul waghole':\n\n";
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Name: {$user->firstname} {$user->lastname}\n";
        echo "Username: {$user->username}\n";
        echo "Email: {$user->email}\n";
        echo "Phone: {$user->phone_code}{$user->phone}\n";
        echo "Created: {$user->created_at}\n";
        echo "Status: " . ($user->status ? 'Active' : 'Inactive') . "\n";
        echo "------------------------\n";
    }
} else {
    echo "No users found with name 'rahul waghole'\n";
}

echo "\nSearch completed.\n";










