<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

echo "=== FIXING ADMIN PASSWORD WITH LARAVEL HASH ===\n\n";

try {
    // Update SPMO password
    $admin = Admin::where('username', 'SPMO')->first();

    if ($admin) {
        $newPassword = Hash::make('admin@123');
        $admin->password = $newPassword;
        $admin->save();

        echo "✓ Updated SPMO password using Hash::make()\n";
        echo "New hash: {$newPassword}\n\n";

        // Verify the new password
        $check = Hash::check('admin@123', $admin->password);
        echo "Hash::check verification: " . ($check ? '✓ VALID' : '✗ INVALID') . "\n\n";

        // Test authentication
        $credentials = ['username' => 'SPMO', 'password' => 'admin@123'];
        $attempt = Auth::guard('admin')->attempt($credentials);

        echo "Auth::attempt test: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n";
    } else {
        echo "✗ SPMO admin not found\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>











