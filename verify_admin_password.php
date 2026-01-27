<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== VERIFYING ADMIN PASSWORDS ===\n\n";

    $admins = DB::table('admins')->get();

    $testPasswords = ['admin', 'admin123', 'password', '123456', 'spmo123'];

    foreach ($admins as $index => $admin) {
        echo "Admin #" . ($index + 1) . ":\n";
        echo "👤 Username: " . ($admin->username ?? 'N/A') . "\n";
        echo "📧 Email: " . $admin->email . "\n";

        foreach ($testPasswords as $testPass) {
            if (Hash::check($testPass, $admin->password)) {
                echo "✅ Password FOUND: '$testPass'\n";
                break;
            }
        }

        echo "🔒 Password Hash: " . substr($admin->password, 0, 25) . "...\n";
        echo str_repeat('-', 50) . "\n\n";
    }

    echo "💡 LOGIN URL: http://127.0.0.1:8000/admin/login\n";
    echo "💡 LIVE URL: https://sindhumatri.com/admin/dashboard\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>




