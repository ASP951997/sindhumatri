<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== TESTING ADMIN PANEL USER ACCESS ===\n\n";

try {
    // Test User model access (same as admin controller)
    $users = User::with('profileInfo')->orderBy('id', 'DESC')->paginate(10);

    echo "Users query successful!\n";
    echo "Total users found: " . $users->total() . "\n";
    echo "Current page: " . $users->currentPage() . "\n";
    echo "Per page: " . $users->perPage() . "\n";
    echo "Users on this page: " . $users->count() . "\n\n";

    if ($users->count() > 0) {
        echo "Sample users:\n";
        foreach ($users as $user) {
            echo "- ID {$user->id}: {$user->firstname} {$user->lastname} ({$user->username}) - Status: {$user->status}\n";
        }
    }

    echo "\n✅ Admin panel should now display user data!\n";
    echo "Visit: http://localhost:8000/admin/users\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
?>











