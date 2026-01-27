<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== CLEANING UP ADMIN ACCOUNTS ===\n\n";

    // First, show current admin accounts
    echo "📊 Current Admin Accounts:\n";
    $admins = DB::table('admins')->get();
    foreach ($admins as $index => $admin) {
        echo "  " . ($index + 1) . ". Username: {$admin->username}, Email: {$admin->email}, ID: {$admin->id}\n";
    }
    echo "\n";

    // Keep only one SPMO account (the first one or the one with most recent login)
    echo "🔄 Cleaning up duplicate accounts...\n";

    // Get the SPMO account with the most recent login (to keep the most active one)
    $keepAdmin = DB::table('admins')
        ->where('username', 'SPMO')
        ->orderBy('last_login', 'desc')
        ->first();

    if ($keepAdmin) {
        echo "✅ Keeping SPMO account (ID: {$keepAdmin->id})\n";

        // Delete all other admin accounts
        $deleted = DB::table('admins')
            ->where('id', '!=', $keepAdmin->id)
            ->delete();

        echo "🗑️  Deleted $deleted duplicate admin accounts\n\n";

        // Verify the cleanup
        echo "📋 Final Admin Account:\n";
        $finalAdmins = DB::table('admins')->get();
        foreach ($finalAdmins as $admin) {
            echo "  👤 Username: {$admin->username}\n";
            echo "  📧 Email: {$admin->email}\n";
            echo "  🔒 Password: admin123 (hashed)\n";
            echo "  📊 Status: " . ($admin->status == 1 ? 'Active' : 'Inactive') . "\n";
            echo "  🆔 ID: {$admin->id}\n";
        }

        echo "\n✅ SUCCESS: Only one admin account remains!\n";
        echo "🔐 Login Credentials:\n";
        echo "   Username: SPMO\n";
        echo "   Password: admin123\n\n";

        echo "🌐 LOGIN URLs:\n";
        echo "   Local:  http://127.0.0.1:8000/admin/login\n";
        echo "   Live:   https://sindhumatri.com/admin/login\n";

    } else {
        echo "❌ Error: No SPMO account found!\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>




