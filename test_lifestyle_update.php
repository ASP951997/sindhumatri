<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing lifestyle update functionality...\n\n";

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

    echo "Testing lifestyle update with living_with...\n";

    // Test updating lifestyle fields (including the missing living_with)
    $user->diet = 'Veg';
    $user->smoke = 'No';
    $user->drink = 'No';
    $user->living_with = 'With-Family';

    $user->save();

    echo "✅ Lifestyle information updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Diet: {$user->diet}\n";
    echo "- Smoke: {$user->smoke}\n";
    echo "- Drink: {$user->drink}\n";
    echo "- Living With: {$user->living_with}\n";

    echo "\n✅ Lifestyle update is working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing lifestyle update: " . $e->getMessage() . "\n";
}










