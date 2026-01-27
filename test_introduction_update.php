<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing introduction update functionality...\n\n";

try {
    // Get a test user (user ID 461 from the error message)
    $user = User::find(461);

    if (!$user) {
        echo "❌ Test user (ID: 461) not found. Let me find another user.\n";
        $user = User::where('status', 1)->first();
        if (!$user) {
            echo "❌ No active users found for testing.\n";
            exit(1);
        }
        echo "Using user ID: {$user->id} for testing.\n";
    }

    echo "Original introduction: " . ($user->introduction ?? 'NULL') . "\n";

    // Test updating introduction
    $testIntroduction = "Hello, my name is Test User. I am a sincere, family-oriented person who values honesty, respect, and understanding.";
    $user->introduction = $testIntroduction;
    $user->save();

    echo "✅ Introduction updated successfully!\n";
    echo "New introduction: {$user->introduction}\n";

    // Verify it was saved
    $user->refresh();
    if ($user->introduction === $testIntroduction) {
        echo "✅ Introduction saved and retrieved correctly!\n";
    } else {
        echo "❌ Introduction was not saved correctly.\n";
    }

} catch (Exception $e) {
    echo "❌ Error testing introduction update: " . $e->getMessage() . "\n";
}










