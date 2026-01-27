<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Finding user 'KAVITA BHAMBHANI'...\n\n";

// Try different variations of the name
$nameVariations = [
    ['firstname' => 'KAVITA', 'lastname' => 'BHAMBHANI'],
    ['firstname' => 'kavita', 'lastname' => 'bhamphani'],
    ['firstname' => 'Kavita', 'lastname' => 'Bhamphani'],
    ['firstname' => 'KAVITA', 'lastname' => 'BHAMBHANI'],
    ['firstname' => 'kavita', 'lastname' => 'bhamphani'],
];

$foundUsers = [];

foreach ($nameVariations as $variation) {
    $firstname = $variation['firstname'];
    $lastname = $variation['lastname'];

    echo "Searching for: {$firstname} {$lastname}\n";

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
        echo "  ✅ Found!\n";
        break; // Stop at first match
    } else {
        echo "  ❌ Not found\n";
    }
}

// Also try searching by username or email patterns
if (count($foundUsers) == 0) {
    echo "\nTrying broader search patterns...\n";

    $users = User::where(function($query) {
        $query->whereRaw('LOWER(firstname) LIKE ?', ['%kavita%'])
              ->whereRaw('LOWER(lastname) LIKE ?', ['%bham%']);
    })->get();

    if ($users->count() > 0) {
        echo "Found potential matches:\n";
        foreach ($users as $user) {
            echo "  - ID: {$user->id}, Name: {$user->firstname} {$user->lastname}, Username: {$user->username}, Email: {$user->email}\n";
            $foundUsers[] = [
                'search_name' => 'Potential match',
                'user' => $user
            ];
        }
    }
}

echo "\nResults:\n";
echo "========\n\n";

if (count($foundUsers) > 0) {
    echo "Found " . count($foundUsers) . " user(s):\n\n";
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
} else {
    echo "❌ No users found with the name 'KAVITA BHAMBHANI' or similar variations.\n";
}

echo "\nSearch completed.\n";










