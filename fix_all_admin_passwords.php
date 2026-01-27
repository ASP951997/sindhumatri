<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

echo "=== FIXING ALL ADMIN PASSWORDS ===\n\n";

try {
    // Update all admin passwords
    $admins = Admin::all();

    foreach ($admins as $admin) {
        $newPassword = Hash::make('admin@123');
        $admin->password = $newPassword;
        $admin->save();

        echo "✓ Updated {$admin->username} password\n";

        // Verify
        $check = Hash::check('admin@123', $admin->password);
        echo "  Verification: " . ($check ? '✓ VALID' : '✗ INVALID') . "\n";

        // Test authentication
        $credentials = ['username' => $admin->username, 'password' => 'admin@123'];
        $attempt = Auth::guard('admin')->attempt($credentials);
        echo "  Auth test: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n\n";
    }

    echo "🎉 All admin passwords updated successfully!\n\n";
    echo "Admin Login Credentials:\n";
    echo "------------------------\n";
    echo "Username: SPMO, Password: admin@123\n";
    echo "Username: SP, Password: admin@123\n";
    echo "URL: http://localhost:8000/admin/login\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>











