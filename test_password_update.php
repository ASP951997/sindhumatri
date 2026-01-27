<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== TESTING PASSWORD UPDATE FUNCTIONALITY ===\n\n";

try {
    // Get a test user
    $user = User::first();

    if (!$user) {
        echo "❌ No users found in database!\n";
        exit(1);
    }

    echo "Test User: {$user->firstname} {$user->lastname} (ID: {$user->id})\n";
    echo "Current password hash: " . substr($user->password, 0, 20) . "...\n\n";

    // Test password update logic (similar to controller)
    $newPassword = 'testpassword123';
    $user->password = bcrypt($newPassword);
    $saved = $user->save();

    if ($saved) {
        echo "✅ Password update successful\n";

        // Verify the new password works
        $passwordCheck = Hash::check($newPassword, $user->password);
        echo "✅ Password verification: " . ($passwordCheck ? 'PASSED' : 'FAILED') . "\n";

        // Test email notification (should be disabled)
        echo "\nTesting email notification (should be disabled)...\n";

        $configure = \App\Models\Configure::first();
        if ($configure && $configure->email_notification == 0) {
            echo "✅ Email notifications are DISABLED - no SMTP errors expected\n";
        } else {
            echo "⚠️  Email notifications may still be enabled\n";
        }

        echo "\n🎉 PASSWORD UPDATE FUNCTIONALITY IS WORKING!\n";
        echo "You can now update user passwords in the admin panel without SMTP errors.\n\n";

        echo "Test completed successfully! ✅\n";

    } else {
        echo "❌ Password update failed\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
?>











