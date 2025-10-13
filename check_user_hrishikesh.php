<?php

/**
 * Quick script to check if Hrishikesh Jadhav exists in the database
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "==============================================\n";
echo "User Search: Hrishikesh Jadhav\n";
echo "==============================================\n\n";

try {
    // Search for exact match first
    echo "1. Searching for exact match...\n";
    $exactUser = \App\Models\User::where('firstname', 'Hrishikesh')
        ->where('lastname', 'Jadhav')
        ->first();
    
    if ($exactUser) {
        echo "✓ FOUND (Exact Match):\n";
        echo "  - ID: {$exactUser->id}\n";
        echo "  - Name: {$exactUser->fullname}\n";
        echo "  - Email: {$exactUser->email}\n";
        echo "  - Phone: {$exactUser->phone}\n";
        echo "  - Status: " . ($exactUser->status == 1 ? 'Active' : 'Inactive') . "\n";
        echo "  - Created: {$exactUser->created_at}\n\n";
    } else {
        echo "✗ No exact match found\n\n";
    }

    // Search for partial match
    echo "2. Searching for partial match (Hrishikesh OR Jadhav)...\n";
    $partialUsers = \App\Models\User::where(function($query) {
        $query->where('firstname', 'LIKE', '%Hrishikesh%')
              ->orWhere('lastname', 'LIKE', '%Jadhav%')
              ->orWhereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ['%Hrishikesh%']);
    })->get();
    
    if ($partialUsers->count() > 0) {
        echo "✓ FOUND {$partialUsers->count()} user(s):\n\n";
        foreach ($partialUsers as $user) {
            echo "  [{$user->id}] {$user->fullname}\n";
            echo "      Email: {$user->email}\n";
            echo "      Phone: {$user->phone}\n";
            echo "      Status: " . ($user->status == 1 ? 'Active' : 'Inactive') . "\n";
            echo "\n";
        }
    } else {
        echo "✗ No partial matches found\n\n";
    }

    // Search for similar first names
    echo "3. Searching for similar first names (Hrishi%)...\n";
    $similarFirstName = \App\Models\User::where('firstname', 'LIKE', 'Hrishi%')->get();
    
    if ($similarFirstName->count() > 0) {
        echo "✓ FOUND {$similarFirstName->count()} user(s) with similar first name:\n\n";
        foreach ($similarFirstName as $user) {
            echo "  [{$user->id}] {$user->fullname}\n";
            echo "      Email: {$user->email}\n";
            echo "      Phone: {$user->phone}\n";
            echo "\n";
        }
    } else {
        echo "✗ No similar first names found\n\n";
    }

    // Search for similar last names
    echo "4. Searching for similar last names (Jad%)...\n";
    $similarLastName = \App\Models\User::where('lastname', 'LIKE', 'Jad%')->get();
    
    if ($similarLastName->count() > 0) {
        echo "✓ FOUND {$similarLastName->count()} user(s) with similar last name:\n\n";
        foreach ($similarLastName as $user) {
            echo "  [{$user->id}] {$user->fullname}\n";
            echo "      Email: {$user->email}\n";
            echo "      Phone: {$user->phone}\n";
            echo "\n";
        }
    } else {
        echo "✗ No similar last names found\n\n";
    }

    // Show total users count
    $totalUsers = \App\Models\User::count();
    echo "==============================================\n";
    echo "Total users in database: {$totalUsers}\n";
    echo "==============================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n";
}



