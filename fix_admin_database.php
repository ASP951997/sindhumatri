<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "=== FIXING ADMIN DATABASE ===\n\n";

try {
    // Check current state
    echo "Current admins in database:\n";
    $admins = DB::table('admins')->get();
    foreach ($admins as $admin) {
        echo "  - ID: {$admin->id}, Username: {$admin->username}, Email: {$admin->email}\n";
    }
    echo "\n";

    // Remove duplicate SPMO admins (keep the first one)
    $spmoAdmins = DB::table('admins')->where('username', 'SPMO')->get();
    if ($spmoAdmins->count() > 1) {
        echo "Removing duplicate SPMO admins...\n";
        $firstId = $spmoAdmins->first()->id;
        DB::table('admins')->where('username', 'SPMO')->where('id', '!=', $firstId)->delete();
        echo "✓ Duplicates removed\n\n";
    }

    // Check if SP admin exists
    $spAdmin = DB::table('admins')->where('username', 'SP')->first();
    if (!$spAdmin) {
        echo "Creating SP admin...\n";
        DB::table('admins')->insert([
            'name' => 'SP Admin',
            'username' => 'SP',
            'email' => 'sp@matrimony.com',
            'password' => Hash::make('admin@123'),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "✓ SP admin created\n\n";
    } else {
        echo "SP admin already exists\n\n";
    }

    // Update all admin passwords to ensure they're correct
    echo "Updating all admin passwords...\n";
    DB::table('admins')->update([
        'password' => Hash::make('admin@123'),
        'updated_at' => now()
    ]);
    echo "✓ All passwords updated\n\n";

    // Final check
    echo "Final admin list:\n";
    $finalAdmins = DB::table('admins')->get();
    foreach ($finalAdmins as $admin) {
        echo "  - {$admin->username} ({$admin->email})\n";
    }

    echo "\n🎉 Admin database fixed!\n\n";
    echo "Login credentials:\n";
    echo "  SPMO: admin@123\n";
    echo "  SP: admin@123\n";
    echo "  URL: http://localhost:8000/admin/login\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}
?>











