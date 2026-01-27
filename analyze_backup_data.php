<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== ANALYZING BACKUP DATABASE DATA ===\n\n";

    // Read the SQL backup file
    $backupFile = 'u105084344_matrimony_111.sql';
    if (!file_exists($backupFile)) {
        die("Backup file not found: $backupFile\n");
    }

    echo "Backup file found: $backupFile\n";

    // Parse the SQL file to extract users data
    $sqlContent = file_get_contents($backupFile);
    echo "Backup file size: " . strlen($sqlContent) . " characters\n\n";

    // Check for INSERT statements for users table
    if (strpos($sqlContent, 'INSERT INTO `users`') !== false) {
        echo "✅ Users table data found in backup\n";

        // Extract a sample of the users INSERT statements
        $pattern = '/INSERT INTO `users` VALUES([^;]+);/';
        preg_match_all($pattern, $sqlContent, $matches);

        if (!empty($matches[1])) {
            echo "Found " . count($matches[1]) . " INSERT statements for users table\n\n";

            // Parse the first INSERT statement to see the data structure
            $firstInsert = $matches[1][0];
            echo "Sample data structure from backup:\n";
            echo substr($firstInsert, 0, 200) . "...\n\n";
        }
    } else {
        echo "❌ No users table INSERT statements found in backup\n";
    }

    // Check current database state
    echo "=== CURRENT DATABASE ANALYSIS ===\n\n";

    $totalUsers = DB::table('users')->count();
    echo "Current total users: $totalUsers\n";

    // Check users without age
    $usersWithoutAge = DB::table('users')
        ->where(function($query) {
            $query->whereNull('age')
                  ->orWhere('age', 0);
        })
        ->count();
    echo "Users without age: $usersWithoutAge\n";

    // Check users without images
    $usersWithoutImages = DB::table('users')
        ->where(function($query) {
            $query->whereNull('image')
                  ->orWhere('image', '');
        })
        ->count();
    echo "Users without images: $usersWithoutImages\n";

    // Check users missing both
    $usersMissingBoth = DB::table('users')
        ->where(function($query) {
            $query->whereNull('age')
                  ->orWhere('age', 0);
        })
        ->where(function($query) {
            $query->whereNull('image')
                  ->orWhere('image', '');
        })
        ->count();
    echo "Users missing both age and images: $usersMissingBoth\n\n";

    echo "=== RECOMMENDED ACTION PLAN ===\n\n";
    echo "1. Create a backup of current database (recommended)\n";
    echo "2. Extract user data from backup file\n";
    echo "3. Update missing age and image data from backup\n";
    echo "4. Verify data integrity after update\n\n";

    echo "Do you want to proceed with the data update? (Run the update script next)\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
