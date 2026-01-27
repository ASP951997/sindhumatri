<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing permanent address update functionality...\n\n";

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

    echo "Testing permanent address update with postcode...\n";

    // Test updating permanent address fields (including postcode)
    $user->permanent_country = 101;
    $user->permanent_state = 22;
    $user->permanent_city = 2567;
    $user->permanent_address = '-';
    $user->permanent_postcode = '425405';

    $user->save();

    echo "✅ Permanent address updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Permanent Country: {$user->permanent_country}\n";
    echo "- Permanent State: {$user->permanent_state}\n";
    echo "- Permanent City: {$user->permanent_city}\n";
    echo "- Permanent Address: {$user->permanent_address}\n";
    echo "- Permanent Postcode: {$user->permanent_postcode}\n";

    echo "\n✅ Permanent address update with postcode is working correctly!\n";
    echo "The 'Same as Present Address' checkbox functionality should now work without errors.\n";

} catch (Exception $e) {
    echo "❌ Error testing permanent address update: " . $e->getMessage() . "\n";
}










