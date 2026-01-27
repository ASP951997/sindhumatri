<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;

echo "=== CHECKING SP ADMIN ===\n\n";

try {
    // Check SP admin
    $spAdmin = Admin::where('username', 'SP')->first();

    if ($spAdmin) {
        echo "SP Admin found:\n";
        echo "  ID: {$spAdmin->id}\n";
        echo "  Username: {$spAdmin->username}\n";
        echo "  Email: {$spAdmin->email}\n";
        echo "  Status: {$spAdmin->status}\n";
        echo "  Password hash: {$spAdmin->password}\n\n";

        // Test password
        $check = \Illuminate\Support\Facades\Hash::check('admin@123', $spAdmin->password);
        echo "Password verification: " . ($check ? '✅ VALID' : '❌ INVALID') . "\n\n";
    } else {
        echo "❌ SP admin not found!\n\n";
    }

    // Check all admins
    echo "All admins:\n";
    $admins = Admin::all();
    foreach ($admins as $admin) {
        echo "  - {$admin->username} ({$admin->email})\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>











