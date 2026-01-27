<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== FINAL ADMIN ACCOUNT CLEANUP ===\n\n";

    // Show current state
    echo "📊 Current Admin Accounts:\n";
    $admins = DB::table('admins')->get();
    echo "Total: " . $admins->count() . " accounts\n";
    foreach ($admins as $index => $admin) {
        echo "  " . ($index + 1) . ". ID: {$admin->id}, Username: {$admin->username}, Email: {$admin->email}\n";
    }
    echo "\n";

    // Keep only the first SPMO account and delete the rest
    echo "🔄 Removing duplicate SPMO accounts...\n";

    $spmoAccounts = DB::table('admins')->where('username', 'SPMO')->get();

    if ($spmoAccounts->count() > 1) {
        // Keep the first one, delete the rest
        $keepId = $spmoAccounts->first()->id;
        echo "✅ Keeping SPMO account with ID: $keepId\n";

        $deleted = DB::table('admins')
            ->where('username', 'SPMO')
            ->where('id', '!=', $keepId)
            ->delete();

        echo "🗑️  Deleted $deleted duplicate SPMO accounts\n";
    }

    // Final verification
    echo "\n📋 FINAL RESULT:\n";
    $finalAdmins = DB::table('admins')->get();
    echo "Total remaining accounts: " . $finalAdmins->count() . "\n";

    if ($finalAdmins->count() == 1) {
        $admin = $finalAdmins->first();
        echo "\n✅ SUCCESS! Only one admin account remains:\n";
        echo "  👤 Username: {$admin->username}\n";
        echo "  📧 Email: {$admin->email}\n";
        echo "  🔒 Password: admin123\n";
        echo "  📊 Status: " . ($admin->status == 1 ? 'Active' : 'Inactive') . "\n";
        echo "  🆔 ID: {$admin->id}\n\n";

        echo "🔐 LOGIN CREDENTIALS:\n";
        echo "   Username: SPMO\n";
        echo "   Password: admin123\n\n";

        echo "🌐 LOGIN URLs:\n";
        echo "   Local:  http://127.0.0.1:8000/admin/login\n";
        echo "   Live:   https://sindhumatri.com/admin/login\n\n";

        echo "📝 NEXT STEPS:\n";
        echo "1. Test login on localhost\n";
        echo "2. Export database (already done)\n";
        echo "3. Upload to live server\n";
        echo "4. Import to live database\n";
        echo "5. Use same credentials on live site\n";

    } else {
        echo "❌ ERROR: Still have " . $finalAdmins->count() . " accounts. Manual cleanup needed.\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>




