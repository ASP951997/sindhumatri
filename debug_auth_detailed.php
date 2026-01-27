<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

echo "=== DETAILED AUTH DEBUG ===\n\n";

try {
    // Get admin user
    $admin = Admin::where('username', 'SPMO')->first();

    if (!$admin) {
        echo "SPMO admin not found!\n";
        exit(1);
    }

    echo "Admin found:\n";
    echo "  ID: {$admin->id}\n";
    echo "  Username: {$admin->username}\n";
    echo "  Email: {$admin->email}\n";
    echo "  Status: {$admin->status}\n";
    echo "  Password hash: {$admin->password}\n\n";

    // Test password directly
    $password = 'admin@123';
    $hashCheck = Hash::check($password, $admin->password);
    echo "Hash::check('$password', hash): " . ($hashCheck ? '✓ VALID' : '✗ INVALID') . "\n";

    $passwordVerify = password_verify($password, $admin->password);
    echo "password_verify('$password', hash): " . ($passwordVerify ? '✓ VALID' : '✗ INVALID') . "\n\n";

    // Test Auth::attempt
    echo "Testing Auth::guard('admin')->attempt():\n";
    $credentials = ['username' => 'SPMO', 'password' => 'admin@123'];
    $attempt = Auth::guard('admin')->attempt($credentials, true);
    echo "  Attempt result: " . ($attempt ? '✓ SUCCESS' : '✗ FAILED') . "\n";

    // Check if user is authenticated after attempt
    $user = Auth::guard('admin')->user();
    echo "  Authenticated user: " . ($user ? $user->username : 'null') . "\n";

    // Check for validation errors
    $errors = Auth::guard('admin')->getLastAttempted();
    echo "  Last attempted user: " . ($errors ? 'exists' : 'null') . "\n";

    // Test manual authentication
    echo "\nTesting manual authentication:\n";
    $admin = Auth::guard('admin')->getProvider()->retrieveByCredentials(['username' => 'SPMO']);
    echo "  Retrieved by credentials: " . ($admin ? $admin->username : 'null') . "\n";

    if ($admin) {
        $valid = Auth::guard('admin')->getProvider()->validateCredentials($admin, ['password' => 'admin@123']);
        echo "  Validate credentials: " . ($valid ? '✓ VALID' : '✗ INVALID') . "\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
    echo 'Trace: ' . $e->getTraceAsString() . "\n";
}
?>











