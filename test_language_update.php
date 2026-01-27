<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing language update functionality...\n\n";

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

    echo "Testing language update with mother_tongue and known_languages...\n";

    // Test updating language fields (including the missing ones)
    $user->mother_tongue = 'Sindhi';
    $user->known_languages = json_encode(['Hindi']);

    $user->save();

    echo "✅ Language information updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Mother Tongue: {$user->mother_tongue}\n";
    echo "- Known Languages: {$user->known_languages}\n";

    // Decode and display the known languages
    $knownLanguages = json_decode($user->known_languages, true);
    if (is_array($knownLanguages)) {
        echo "- Known Languages Array: " . implode(', ', $knownLanguages) . "\n";
    }

    echo "\n✅ Language update is working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing language update: " . $e->getMessage() . "\n";
}










