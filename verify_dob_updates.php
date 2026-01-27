<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== DOB UPDATE VERIFICATION ===\n\n";

    $totalUsers = DB::table('users')->count();

    $currentStats = [
        'with_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->count(),
        'without_dob' => DB::table('users')->where(function($q) { $q->whereNull('date_of_birth')->orWhere('date_of_birth', ''); })->count(),
    ];

    echo "Current DOB Status:\n";
    echo "Total users: $totalUsers\n";
    echo "Users with DOB: {$currentStats['with_dob']} (" . round(($currentStats['with_dob']/$totalUsers)*100, 1) . "%)\n";
    echo "Users missing DOB: {$currentStats['without_dob']} (" . round(($currentStats['without_dob']/$totalUsers)*100, 1) . "%)\n\n";

    // Show recent DOB updates (assuming they were updated recently)
    echo "=== RECENT DOB UPDATES ===\n\n";

    $recentDobUsers = DB::table('users')
        ->whereNotNull('date_of_birth')
        ->where('date_of_birth', '!=', '')
        ->where('date_of_birth', '!=', '0000-00-00')
        ->whereRaw("date_of_birth NOT LIKE '00%-%-%'")
        ->select('id', 'firstname', 'lastname', 'username', 'date_of_birth', 'age')
        ->orderBy('id')
        ->get();

    $validDobCount = 0;
    foreach ($recentDobUsers as $user) {
        // Validate DOB format
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $user->date_of_birth) &&
            $user->date_of_birth != '0000-00-00' &&
            !preg_match('/^00\d{2}-/', $user->date_of_birth)) {
            $validDobCount++;
            if ($validDobCount <= 10) { // Show first 10
                echo "✅ {$user->firstname} {$user->lastname} (ID: {$user->id})\n";
                echo "   DOB: {$user->date_of_birth}, Age: {$user->age}\n\n";
            }
        }
    }

    echo "=== SUMMARY ===\n";
    echo "Total users with valid DOB data: $validDobCount\n";

    if ($validDobCount > 2) { // More than the original 2
        $newDobUsers = $validDobCount - 2;
        echo "✅ Successfully added DOB data for $newDobUsers users from backup!\n";
    } else {
        echo "❌ No new DOB data was added from the backup.\n";
    }

    // Age calculation check
    $usersWithAge = DB::table('users')->whereNotNull('age')->where('age', '>', 0)->count();
    echo "Users with age data: $usersWithAge\n";

    echo "\n=== RECOMMENDATIONS ===\n";
    if ($currentStats['without_dob'] > 0) {
        echo "⚠️  Still {$currentStats['without_dob']} users missing DOB\n";
        echo "   Consider calculating DOB from age or checking for additional backup files\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>
