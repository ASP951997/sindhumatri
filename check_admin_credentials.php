<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== ADMIN LOGIN CREDENTIALS ===\n\n";

    $admins = DB::table('admins')->get();

    foreach ($admins as $admin) {
        echo "👤 Username: " . ($admin->username ?? 'N/A') . "\n";
        echo "📧 Email: " . $admin->email . "\n";
        echo "📞 Phone: " . ($admin->phone ?? 'N/A') . "\n";
        echo "🔒 Password Hash: " . substr($admin->password, 0, 20) . "...\n";
        echo "📍 Address: " . ($admin->address ? substr($admin->address, 0, 50) . '...' : 'N/A') . "\n";
        echo "📊 Status: " . ($admin->status == 1 ? 'Active' : 'Inactive') . "\n";
        echo "🕐 Last Login: " . ($admin->last_login ?? 'Never') . "\n";
        echo str_repeat('-', 50) . "\n\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>




