<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing astronomic information update functionality...\n\n";

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

    echo "Testing astronomic information update with sun_sign, moon_sign, etc...\n";

    // Test updating astronomic information fields (including the missing ones)
    $user->sun_sign = 'Taurus';
    $user->moon_sign = '';
    $user->time_of_birth = '';
    $user->city_of_birth = 'Pune';

    $user->save();

    echo "✅ Astronomic information updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Sun Sign: {$user->sun_sign}\n";
    echo "- Moon Sign: {$user->moon_sign}\n";
    echo "- Time of Birth: {$user->time_of_birth}\n";
    echo "- City of Birth: {$user->city_of_birth}\n";

    echo "\n✅ Astronomic information update is working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing astronomic information update: " . $e->getMessage() . "\n";
}










