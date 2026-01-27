<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== RESET ADMIN PASSWORD ===\n\n";

    $newPassword = 'admin123';
    $hashedPassword = Hash::make($newPassword);

    echo "🔄 Resetting password for all admin accounts...\n";
    echo "📝 New Password: '$newPassword'\n\n";

    // Update all admin passwords
    $updated = DB::table('admins')->update([
        'password' => $hashedPassword,
        'updated_at' => now()
    ]);

    echo "✅ Successfully updated $updated admin account(s)!\n\n";

    // Show updated admin details
    $admins = DB::table('admins')->get();
    foreach ($admins as $index => $admin) {
        echo "Admin #" . ($index + 1) . ":\n";
        echo "👤 Username: " . ($admin->username ?? 'N/A') . "\n";
        echo "📧 Email: " . $admin->email . "\n";
        echo "🔒 New Password: $newPassword\n";
        echo str_repeat('-', 30) . "\n";
    }

    echo "\n🌐 LOGIN URLs:\n";
    echo "   Local:  http://127.0.0.1:8000/admin/login\n";
    echo "   Live:   https://sindhumatri.com/admin/login\n\n";

    echo "📋 LOGIN INSTRUCTIONS:\n";
    echo "1. Username: SPMO or SP\n";
    echo "2. Password: admin123\n";
    echo "3. Click 'Sign In'\n\n";

    echo "⚠️  REMEMBER: After syncing to live database, use these same credentials on live site!\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>