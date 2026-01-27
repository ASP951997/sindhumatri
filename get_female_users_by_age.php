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

    $ageRanges = [
        ['min' => 21, 'max' => 25, 'label' => '21-25 years'],
        ['min' => 26, 'max' => 30, 'label' => '26-30 years'], // Adjusted to 26-30 to avoid overlap
        ['min' => 31, 'max' => 35, 'label' => '31-35 years']  // Adjusted to 31-35
    ];

    $totalInRanges = 0;

    foreach ($ageRanges as $range) {
        echo "=== FEMALES AGED {$range['label']} ===\n\n";

        $females = DB::table('users')
            ->where('gender', 'Female')
            ->whereNotNull('age')
            ->where('age', '!=', '')
            ->whereRaw('CAST(age AS UNSIGNED) >= ? AND CAST(age AS UNSIGNED) <= ?', [$range['min'], $range['max']])
            ->select('id', 'firstname', 'lastname', 'username', 'email', 'age', 'date_of_birth')
            ->orderBy('age')
            ->orderBy('firstname')
            ->get();

        echo "Count: " . $females->count() . " females\n\n";

        if ($females->count() > 0) {
            $totalInRanges += $females->count();

            foreach ($females as $female) {
                $fullName = trim($female->firstname . ' ' . $female->lastname);
                $age = $female->age;
                $dob = $female->date_of_birth ?: 'Not set';

                echo "👩 {$fullName} (ID: {$female->id})\n";
                echo "   Age: {$age} years | DOB: {$dob}\n";
                echo "   Username: {$female->username} | Email: {$female->email}\n\n";
            }
        } else {
            echo "No females found in this age range.\n\n";
        }
    }

    echo "=== SUMMARY ===\n";
    echo "Total females in specified age ranges: $totalInRanges\n";
    echo "Total females in database: $totalFemales\n";
    $coverage = $totalFemales > 0 ? round(($totalInRanges / $totalFemales) * 100, 2) : 0;
    echo "Coverage of specified age ranges: {$coverage}%\n\n";

    // Additional statistics
    echo "=== AGE DISTRIBUTION OVERVIEW ===\n\n";

    $ageStats = [];
    for ($i = 20; $i <= 40; $i += 5) {
        $count = DB::table('users')
            ->where('gender', 'Female')
            ->whereNotNull('age')
            ->where('age', '!=', '')
            ->whereRaw('CAST(age AS UNSIGNED) >= ? AND CAST(age AS UNSIGNED) < ?', [$i, $i + 5])
            ->count();
        $ageStats[] = [
            'range' => $i . '-' . ($i + 4) . ' years',
            'count' => $count
        ];
    }

    foreach ($ageStats as $stat) {
        echo "{$stat['range']}: {$stat['count']} females\n";
    }

    echo "\n✅ Female user analysis completed successfully!\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
