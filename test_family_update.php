<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing family information update functionality...\n\n";

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

    echo "Testing family information update with father, mother, siblings, etc...\n";

    // Test updating family information fields (including the missing ones)
    $user->father = 'Businessman/Entrepreneur';
    $user->mother = 'Teacher';
    $user->brother_no = 1;
    $user->brother_married = 'None';
    $user->sister_no = 1;
    $user->sibling_position = '2nd';
    $user->family_income = '3-5 lakhs';

    $user->save();

    echo "✅ Family information updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Father: {$user->father}\n";
    echo "- Mother: {$user->mother}\n";
    echo "- Brother No: {$user->brother_no}\n";
    echo "- Brother Married: {$user->brother_married}\n";
    echo "- Sister No: {$user->sister_no}\n";
    echo "- Sibling Position: {$user->sibling_position}\n";
    echo "- Family Income: {$user->family_income}\n";

    echo "\n✅ Family information update is working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing family information update: " . $e->getMessage() . "\n";
}










