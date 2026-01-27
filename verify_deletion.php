<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Verifying user deletion...\n\n";

// List of users to verify deletion
$usersToVerify = [
    ['firstname' => 'Tahil', 'lastname' => 'Chugwani'],
    ['firstname' => 'Rahul', 'lastname' => 'Waghole'],
    ['firstname' => 'Bharat', 'lastname' => 'Jaisingjani'],
    ['firstname' => 'Shweta', 'lastname' => 'Dingreja']
];

foreach ($usersToVerify as $userData) {
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];

    // Check if the user exists
    $user = User::where('firstname', $firstname)
                ->where('lastname', $lastname)
                ->first();

    if ($user) {
        echo "❌ User {$firstname} {$lastname} still exists (ID: {$user->id})\n";
    } else {
        echo "✅ User {$firstname} {$lastname} has been successfully deleted\n";
    }
}

echo "\nVerification completed.\n";










