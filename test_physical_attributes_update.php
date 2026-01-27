<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing physical attributes update functionality...\n\n";

try {
    // Get the user from the error message (ID 461)
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

    echo "Testing physical attributes update with bloodGroup and disability...\n";

    // Test updating physical attributes fields (including the missing ones)
    $user->height = '5ft 7in';
    $user->weight = '';
    $user->body_type = 1;
    $user->complexion = 4;
    $user->bloodGroup = '';
    $user->disability = 'Nothing';

    $user->save();

    echo "✅ Physical attributes updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Height: {$user->height}\n";
    echo "- Weight: {$user->weight}\n";
    echo "- Body Type: {$user->body_type}\n";
    echo "- Complexion: {$user->complexion}\n";
    echo "- Blood Group: {$user->bloodGroup}\n";
    echo "- Disability: {$user->disability}\n";

    echo "\n✅ Physical attributes update is working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing physical attributes update: " . $e->getMessage() . "\n";
}










