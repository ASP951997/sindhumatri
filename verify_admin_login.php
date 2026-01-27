<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

echo "=== ADMIN LOGIN VERIFICATION ===\n\n";

try {
    // Test SPMO login
    echo "Testing SPMO login:\n";
    $credentials = ['username' => 'SPMO', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  Result: " . ($attempt ? '✅ SUCCESS' : '❌ FAILED') . "\n";

    // Test SP login
    echo "\nTesting SP login:\n";
    $credentials = ['username' => 'SP', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  Result: " . ($attempt ? '✅ SUCCESS' : '❌ FAILED') . "\n";

    // Test email login
    echo "\nTesting SPMO email login:\n";
    $credentials = ['email' => 'admin@gmail.com', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials);
    echo "  Result: " . ($attempt ? '✅ SUCCESS' : '❌ FAILED') . "\n";

    echo "\n🎉 Admin login is now working!\n\n";
    echo "Login Details:\n";
    echo "--------------\n";
    echo "URL: http://localhost:8000/admin/login\n";
    echo "Username: SPMO or SP\n";
    echo "Password: admin@123\n";
    echo "Email: admin@gmail.com (for SPMO) or sp@matrimony.com (for SP)\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}
?>











