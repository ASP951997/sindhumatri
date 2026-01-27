<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== ANALYZING DATE OF BIRTH DATA ===\n\n";

    $backupFile = 'u105084344_matrimony_111.sql';

    if (!file_exists($backupFile)) {
        die("❌ Backup file not found: $backupFile\n");
    }

    // Check current database DOB status
    $totalUsers = DB::table('users')->count();

    $dobStats = [
        'with_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->count(),
        'without_dob' => DB::table('users')->where(function($q) { $q->whereNull('date_of_birth')->orWhere('date_of_birth', ''); })->count(),
    ];

    echo "Current Database DOB Status:\n";
    echo "Total users: $totalUsers\n";
    echo "Users with DOB: {$dobStats['with_dob']} (" . round(($dobStats['with_dob']/$totalUsers)*100, 1) . "%)\n";
    echo "Users missing DOB: {$dobStats['without_dob']} (" . round(($dobStats['without_dob']/$totalUsers)*100, 1) . "%)\n\n";

    // Show some sample users missing DOB
    echo "Sample users missing DOB:\n";
    $missingDobUsers = DB::table('users')
        ->where(function($q) { $q->whereNull('date_of_birth')->orWhere('date_of_birth', ''); })
        ->select('id', 'firstname', 'lastname', 'username', 'gender')
        ->limit(10)
        ->get();

    foreach ($missingDobUsers as $user) {
        echo "- {$user->firstname} {$user->lastname} (ID: {$user->id}, Gender: {$user->gender})\n";
    }

    echo "\n=== BACKUP FILE ANALYSIS ===\n";

    // Read and analyze backup file for DOB data
    $sqlContent = file_get_contents($backupFile);
    echo "✅ Reading backup file...\n";

    // Count INSERT statements for users
    $pattern = '/INSERT INTO `users` \([^)]+\) VALUES([^;]+);/';
    preg_match_all($pattern, $sqlContent, $matches);

    if (empty($matches[1])) {
        die("❌ No user data found in backup file\n");
    }

    echo "✅ Found " . count($matches[1]) . " user data chunks in backup\n";
    echo "Will proceed to extract and update DOB data...\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>
