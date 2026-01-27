<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== FEMALE USERS BY AGE GROUPS ===\n\n";

    // Get total female users
    $totalFemales = DB::table('users')->where('gender', 'Female')->count();
    echo "Total female users in database: $totalFemales\n\n";

    // Define age groups
    $ageGroups = [
        ['min' => 21, 'max' => 25, 'label' => '21-25 years'],
        ['min' => 26, 'max' => 30, 'label' => '26-30 years'], // Fixed to avoid overlap
        ['min' => 31, 'max' => 35, 'label' => '31-35 years']
    ];

    $totalInGroups = 0;

    foreach ($ageGroups as $group) {
        echo "=== AGE GROUP: {$group['label']} ===\n\n";

        // Get users in this age group
        $users = DB::table('users')
            ->where('gender', 'Female')
            ->whereNotNull('age')
            ->where('age', '>=', $group['min'])
            ->where('age', '<=', $group['max'])
            ->select('id', 'firstname', 'lastname', 'username', 'email', 'age', 'date_of_birth', 'member_id')
            ->orderBy('age')
            ->orderBy('firstname')
            ->get();

        $count = $users->count();
        $totalInGroups += $count;

        echo "Found $count female users\n\n";

        if ($count > 0) {
            $index = 1;
            foreach ($users as $user) {
                $fullName = trim($user->firstname . ' ' . $user->lastname);
                $dob = $user->date_of_birth ?: 'Not set';

                echo sprintf("%2d. %-25s (ID: %3d) - Age: %2d - DOB: %s - Member: %s\n",
                    $index,
                    $fullName,
                    $user->id,
                    $user->age,
                    $dob,
                    $user->member_id ?: 'N/A'
                );
                $index++;
            }
        } else {
            echo "No female users found in this age group.\n";
        }

        echo "\n" . str_repeat("-", 80) . "\n\n";
    }

    // Summary
    echo "=== SUMMARY ===\n\n";
    echo "Total female users in specified age groups: $totalInGroups\n";

    foreach ($ageGroups as $group) {
        $count = DB::table('users')
            ->where('gender', 'Female')
            ->whereNotNull('age')
            ->where('age', '>=', $group['min'])
            ->where('age', '<=', $group['max'])
            ->count();

        $percentage = $totalFemales > 0 ? round(($count / $totalFemales) * 100, 1) : 0;
        echo "- {$group['label']}: $count users ({$percentage}%)\n";
    }

    // Additional statistics
    $femalesWithoutAge = DB::table('users')
        ->where('gender', 'Female')
        ->where(function($q) {
            $q->whereNull('age')->orWhere('age', '');
        })
        ->count();

    $femalesUnder21 = DB::table('users')
        ->where('gender', 'Female')
        ->whereNotNull('age')
        ->where('age', '<', 21)
        ->count();

    $femalesOver35 = DB::table('users')
        ->where('gender', 'Female')
        ->whereNotNull('age')
        ->where('age', '>', 35)
        ->count();

    echo "\nAdditional statistics:\n";
    echo "- Females without age data: $femalesWithoutAge\n";
    echo "- Females under 21: $femalesUnder21\n";
    echo "- Females over 35: $femalesOver35\n";

    echo "\n✅ Female users analysis completed successfully!\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
