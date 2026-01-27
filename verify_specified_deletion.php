<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Verifying deletion of specified users...\n\n";

// List of users to verify deletion
$usersToVerify = [
    ['firstname' => 'kumar', 'lastname' => 'Motwani'],
    ['firstname' => 'bhavaesh', 'lastname' => 'chapru'],
    ['firstname' => 'Rohan', 'lastname' => 'Chapru'],
    ['firstname' => 'Gaurav', 'lastname' => 'Chapru'],
    ['firstname' => 'Raju', 'lastname' => 'chapru'],
    ['firstname' => 'bharat', 'lastname' => 'chapru'],
    ['firstname' => 'akash', 'lastname' => 'chapru']
];

$remainingUsers = [];
$verifiedDeleted = 0;

foreach ($usersToVerify as $userData) {
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];

    // Check if user still exists (case insensitive)
    $user = User::where(function($query) use ($firstname, $lastname) {
        $query->whereRaw('LOWER(firstname) = ?', [strtolower($firstname)])
              ->whereRaw('LOWER(lastname) = ?', [strtolower($lastname)]);
    })->first();

    if ($user) {
        $remainingUsers[] = [
            'name' => $firstname . ' ' . $lastname,
            'id' => $user->id,
            'username' => $user->username
        ];
    } else {
        $verifiedDeleted++;
    }
}

echo "Verification Results:\n";
echo "===================\n\n";

if (count($remainingUsers) > 0) {
    echo "❌ Found " . count($remainingUsers) . " user(s) still remaining:\n";
    foreach ($remainingUsers as $remaining) {
        echo "  - {$remaining['name']} (ID: {$remaining['id']}, Username: {$remaining['username']})\n";
    }
    echo "\n";
} else {
    echo "✅ All specified users have been successfully deleted!\n";
}

echo "Summary:\n";
echo "- Total users checked: " . count($usersToVerify) . "\n";
echo "- Confirmed deleted: {$verifiedDeleted}\n";
echo "- Still remaining: " . count($remainingUsers) . "\n\n";

echo "Verification completed.\n";










