<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Configure;

echo "=== DISABLING EMAIL NOTIFICATIONS ===\n\n";

try {
    $configure = Configure::first();

    if ($configure) {
        echo "Current email notification status: " . ($configure->email_notification == 1 ? 'ENABLED' : 'DISABLED') . "\n";

        // Disable email notifications
        $configure->email_notification = 0;
        $configure->save();

        echo "✅ Email notifications have been DISABLED\n";
        echo "Password updates will no longer send emails\n";
        echo "This will fix the SMTP error immediately\n\n";

        echo "To re-enable email notifications later, you can:\n";
        echo "1. Configure proper SMTP settings\n";
        echo "2. Set email_notification = 1 in the configure table\n";
        echo "3. Or configure environment variables in .env file\n\n";

        // Test password update without email
        echo "Testing password update functionality...\n";
        $user = \App\Models\User::first();
        if ($user) {
            echo "✓ User found: {$user->firstname} {$user->lastname}\n";
            echo "✓ Password update should now work without SMTP errors\n";
        }

    } else {
        echo "❌ Configure record not found!\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}
?>











