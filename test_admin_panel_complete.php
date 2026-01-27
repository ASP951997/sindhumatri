<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

echo "=== TESTING ADMIN PANEL WITH ALL USERS ===\n\n";

try {
    // Test total users
    $totalUsers = User::count();
    echo "Total users in database: $totalUsers\n";

    // Test pagination (first page)
    $users = User::with('profileInfo')->orderBy('id', 'DESC')->paginate(10);
    echo "Users on page 1: " . $users->count() . "\n";
    echo "Total pages: " . $users->lastPage() . "\n\n";

    // Test users with emails
    $usersWithEmails = User::whereNotNull('email')->where('email', '!=', '')->count();
    echo "Users with emails: $usersWithEmails\n\n";

    // Show sample users with emails
    echo "Sample users with email display:\n";
    $sampleUsers = User::select('id', 'firstname', 'lastname', 'username', 'email', 'phone', 'status')
                      ->orderBy('id')
                      ->limit(10)
                      ->get();

    foreach ($sampleUsers as $user) {
        $email = $user->email ?: 'N/A';
        $phone = $user->phone ?: 'N/A';
        echo "- ID {$user->id}: {$user->firstname} {$user->lastname} ({$user->username}) - Email: $email - Phone: $phone - Status: {$user->status}\n";
    }

    echo "\n✅ Admin panel should now display all $totalUsers users with proper email addresses!\n";
    echo "Access the admin panel at: http://localhost:8000/admin/users\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
?>











