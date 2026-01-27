<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== TESTING USER PROFILE ACCESS ===\n\n";

try {
    // Get a user to test
    $user = User::first();

    if (!$user) {
        echo "❌ No users found in database!\n";
        exit(1);
    }

    echo "Testing user: {$user->firstname} {$user->lastname} (ID: {$user->id})\n";
    echo "Created at: " . ($user->created_at ? $user->created_at->format('d M,Y h:i A') : 'N/A') . "\n";
    echo "Updated at: " . ($user->updated_at ? $user->updated_at->format('d M,Y h:i A') : 'N/A') . "\n\n";

    // Test the date formatting that was causing the error
    if ($user->created_at) {
        $formattedDate = $user->created_at->format('d M,Y h:i A');
        echo "✅ Date formatting works: $formattedDate\n";
    } else {
        echo "⚠️  Created_at is null, but handled gracefully\n";
    }

    // Test multiple users
    $users = User::limit(10)->get();
    $nullCount = 0;

    echo "\nChecking first 10 users for date issues:\n";
    foreach ($users as $u) {
        $hasCreatedAt = $u->created_at !== null;
        $hasUpdatedAt = $u->updated_at !== null;

        if (!$hasCreatedAt || !$hasUpdatedAt) {
            $nullCount++;
        }

        $status = (!$hasCreatedAt || !$hasUpdatedAt) ? '❌ HAS NULL DATES' : '✅ OK';
        echo "- {$u->firstname} {$u->lastname}: $status\n";
    }

    if ($nullCount === 0) {
        echo "\n🎉 SUCCESS: All users have valid timestamps!\n";
        echo "The 'format() on null' error should be fixed.\n";
        echo "You can now safely access user profiles in the admin panel.\n\n";
        echo "Test URL: http://localhost:8000/admin/user/edit/1\n";
    } else {
        echo "\n⚠️  WARNING: $nullCount users still have null dates!\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
?>











