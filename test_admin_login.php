<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== ADMIN LOGIN CREDENTIALS ===\n\n";

    // Get first admin record
    $admin = DB::table('admins')->first();

    echo "📋 Testing passwords for admin: " . ($admin->username ?? 'N/A') . "\n";
    echo "📧 Email: " . $admin->email . "\n\n";

    // Test common passwords
    $passwordsToTest = [
        'admin',
        'admin123',
        'password',
        '123456',
        'spmo',
        'spmo123',
        'matrimony',
        'SindhuMatri'
    ];

    foreach ($passwordsToTest as $password) {
        if (Hash::check($password, $admin->password)) {
            echo "✅ PASSWORD FOUND: '$password'\n";
            echo "🔓 This is the correct password!\n\n";
            break;
        } else {
            echo "❌ '$password' - Not correct\n";
        }
    }

    echo "\n🔐 Password Hash: " . $admin->password . "\n\n";

    echo "🌐 LOGIN URLs:\n";
    echo "   Local:  http://127.0.0.1:8000/admin/login\n";
    echo "   Live:   https://sindhumatri.com/admin/login\n\n";

    echo "📝 LOGIN INSTRUCTIONS:\n";
    echo "1. Go to the admin login URL\n";
    echo "2. Enter username/email and password\n";
    echo "3. Click 'Sign In'\n\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>




