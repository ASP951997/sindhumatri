<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== ANALYZING MISSING DOB AND AGE DATA ===\n\n";

    // Get total user count
    $totalUsers = DB::table('users')->count();
    echo "Total users in database: $totalUsers\n\n";

    // Check DOB statistics
    $dobStats = [
        'with_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->count(),
        'without_dob' => DB::table('users')->where(function($q) {
            $q->whereNull('date_of_birth')->orWhere('date_of_birth', '');
        })->count(),
        'invalid_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->whereRaw("date_of_birth NOT REGEXP '^[0-9]{4}-[0-9]{2}-[0-9]{2}$'")->count(),
    ];

    // Check age statistics
    $ageStats = [
        'with_age' => DB::table('users')->whereNotNull('age')->where('age', '!=', '')->count(),
        'without_age' => DB::table('users')->where(function($q) {
            $q->whereNull('age')->orWhere('age', '');
        })->count(),
        'invalid_age' => DB::table('users')->whereNotNull('age')->where('age', '!=', '')->whereRaw("age NOT REGEXP '^[0-9]+$' OR CAST(age AS UNSIGNED) < 18 OR CAST(age AS UNSIGNED) > 100")->count(),
    ];

    echo "=== DATE OF BIRTH STATISTICS ===\n";
    echo "Users with valid DOB: {$dobStats['with_dob']}\n";
    echo "Users missing DOB: {$dobStats['without_dob']}\n";
    echo "Users with invalid DOB format: {$dobStats['invalid_dob']}\n";
    $dobCompletion = $totalUsers > 0 ? round(($dobStats['with_dob'] / $totalUsers) * 100, 2) : 0;
    echo "DOB completion rate: {$dobCompletion}%\n\n";

    echo "=== AGE STATISTICS ===\n";
    echo "Users with valid age: {$ageStats['with_age']}\n";
    echo "Users missing age: {$ageStats['without_age']}\n";
    echo "Users with invalid age: {$ageStats['invalid_age']}\n";
    $ageCompletion = $totalUsers > 0 ? round(($ageStats['with_age'] / $totalUsers) * 100, 2) : 0;
    echo "Age completion rate: {$ageCompletion}%\n\n";

    // Show sample of users missing DOB
    if ($dobStats['without_dob'] > 0) {
        echo "=== SAMPLE USERS MISSING DOB ===\n";
        $missingDobUsers = DB::table('users')
            ->where(function($q) {
                $q->whereNull('date_of_birth')->orWhere('date_of_birth', '');
            })
            ->select('id', 'firstname', 'lastname', 'username', 'email', 'age')
            ->limit(10)
            ->get();

        foreach ($missingDobUsers as $user) {
            echo "ID {$user->id}: {$user->firstname} {$user->lastname} ({$user->username}) - Age: {$user->age}\n";
        }
        echo "\n";
    }

    // Show sample of users missing age
    if ($ageStats['without_age'] > 0) {
        echo "=== SAMPLE USERS MISSING AGE ===\n";
        $missingAgeUsers = DB::table('users')
            ->where(function($q) {
                $q->whereNull('age')->orWhere('age', '');
            })
            ->select('id', 'firstname', 'lastname', 'username', 'email', 'date_of_birth')
            ->limit(10)
            ->get();

        foreach ($missingAgeUsers as $user) {
            echo "ID {$user->id}: {$user->firstname} {$user->lastname} ({$user->username}) - DOB: {$user->date_of_birth}\n";
        }
        echo "\n";
    }

    // Check if backup file exists
    $backupFile = 'u105084344_matrimony_1.sql';
    if (file_exists($backupFile)) {
        echo "✅ Backup file found: $backupFile\n";
        echo "Ready to proceed with DOB/age data restoration from backup.\n";
    } else {
        echo "❌ Backup file not found: $backupFile\n";
        echo "Cannot proceed with data restoration.\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
