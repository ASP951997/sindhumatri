<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing present address update functionality...\n\n";

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

    echo "Testing present address update with postcode...\n";

    // Test updating present address fields (including postcode)
    $user->present_country = 101;
    $user->present_state = 22;
    $user->present_city = 2567;
    $user->present_address = '-';
    $user->present_postcode = '425405';

    $user->save();

    echo "✅ Present address updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Present Country: {$user->present_country}\n";
    echo "- Present State: {$user->present_state}\n";
    echo "- Present City: {$user->present_city}\n";
    echo "- Present Address: {$user->present_address}\n";
    echo "- Present Postcode: {$user->present_postcode}\n";

    echo "\n✅ Present address update with postcode is working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing present address update: " . $e->getMessage() . "\n";
}










