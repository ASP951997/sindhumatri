<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Finding additional users to delete...\n\n";

// List of users to find and delete
$usersToFind = [
    ['firstname' => 'kavita', 'lastname' => 'bambani'],
    ['firstname' => 'Anil', 'lastname' => 'JAWRANI'],
    ['firstname' => 'Nikita', 'lastname' => 'Thite'],
    ['firstname' => 'Pooja', 'lastname' => 'Thite'],
    ['firstname' => 'sharvi', 'lastname' => '345'],
    ['firstname' => 'Sanika', 'lastname' => 'shinde'],
    ['firstname' => 'shri@123', 'lastname' => 'majare2']
];

$foundUsers = [];
$notFoundUsers = [];

foreach ($usersToFind as $userData) {
    $firstname = $userData['firstname'];
    $lastname = $userData['lastname'];

    // Find user (case insensitive search)
    $user = User::where(function($query) use ($firstname, $lastname) {
        $query->whereRaw('LOWER(firstname) = ?', [strtolower($firstname)])
              ->whereRaw('LOWER(lastname) = ?', [strtolower($lastname)]);
    })->first();

    if ($user) {
        $foundUsers[] = [
            'search_name' => $firstname . ' ' . $lastname,
            'user' => $user
        ];
    } else {
        $notFoundUsers[] = $firstname . ' ' . $lastname;
    }
}

echo "Results:\n";
echo "========\n\n";

if (count($foundUsers) > 0) {
    echo "Found " . count($foundUsers) . " user(s) to delete:\n\n";
    foreach ($foundUsers as $foundUser) {
        $user = $foundUser['user'];
        echo "Search: {$foundUser['search_name']}\n";
        echo "ID: {$user->id}\n";
        echo "Name: {$user->firstname} {$user->lastname}\n";
        echo "Username: {$user->username}\n";
        echo "Email: {$user->email}\n";
        echo "Phone: {$user->phone_code}{$user->phone}\n";
        echo "Created: {$user->created_at}\n";
        echo "Status: " . ($user->status ? 'Active' : 'Inactive') . "\n";
        echo "------------------------\n";
    }
}

if (count($notFoundUsers) > 0) {
    echo "\nUsers not found:\n";
    foreach ($notFoundUsers as $notFound) {
        echo "- {$notFound}\n";
    }
}

echo "\nSearch completed.\n";










