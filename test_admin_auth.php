<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

echo "=== TESTING ADMIN AUTHENTICATION ===\n\n";

try {
    // Test SPMO login
    echo "Testing SPMO login:\n";
    $credentials = ['username' => 'SPMO', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  SPMO with username: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n";

    if (!$attempt) {
        $admin = Admin::where('username', 'SPMO')->first();
        if ($admin) {
            echo "  Admin found, status: {$admin->status}\n";
            $passwordCheck = password_verify('admin@123', $admin->password);
            echo "  Password verify: " . ($passwordCheck ? '✓ VALID' : '✗ INVALID') . "\n";
        } else {
            echo "  Admin not found\n";
        }
    }

    // Test SPMO login with email
    echo "\nTesting SPMO login with email:\n";
    $credentials = ['email' => 'admin@gmail.com', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  SPMO with email: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n";

    // Test SP login
    echo "\nTesting SP login:\n";
    $credentials = ['username' => 'SP', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  SP with username: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n";

    // Test SP login with email
    echo "\nTesting SP login with email:\n";
    $credentials = ['email' => 'sp@matrimony.com', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  SP with email: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n";

    // Check if admin guard is working
    echo "\nAdmin guard check:\n";
    $guard = Auth::guard('admin');
    echo "  Guard instance: " . (get_class($guard) ?: 'null') . "\n";

    // Check admin model
    echo "\nAdmin model check:\n";
    $admins = Admin::all();
    echo "  Total admins: " . $admins->count() . "\n";
    foreach ($admins as $admin) {
        echo "  - {$admin->username} ({$admin->email}) - Status: {$admin->status}\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo 'Trace: ' . $e->getTraceAsString() . "\n";
}
?>