<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Count total users first
    $totalUsers = DB::table('users')->count();

    // Count female users aged 20-28
    $femaleCount = DB::table('users')
        ->where('gender', 'female')
        ->whereBetween('age', [20, 28])
        ->count();

    // Also check using date_of_birth if age is not reliable (calculate age from DOB)
    $currentYear = date('Y');
    $minBirthYear = $currentYear - 28; // For age 28, born in or after this year
    $maxBirthYear = $currentYear - 20; // For age 20, born in or before this year

    $femaleCountByDOB = DB::table('users')
        ->where('gender', 'female')
        ->whereRaw("YEAR(date_of_birth) BETWEEN ? AND ?", [$minBirthYear, $maxBirthYear])
        ->count();

    echo "=== FEMALE PROFILES AGED 20-28 ANALYSIS ===\n\n";
    echo "Total Users in Database: $totalUsers\n\n";

    echo "Female profiles aged 20-28 (using age column): $femaleCount\n";
    echo "Female profiles aged 20-28 (using date_of_birth): $femaleCountByDOB\n\n";

    // Show breakdown by age
    echo "=== AGE BREAKDOWN FOR FEMALES ===\n";
    for ($age = 20; $age <= 28; $age++) {
        $count = DB::table('users')
            ->where('gender', 'female')
            ->where('age', $age)
            ->count();
        echo "Age $age: $count profiles\n";
    }

    echo "\n=== SUMMARY ===\n";
    echo "Out of $totalUsers total profiles, there are $femaleCount female profiles aged between 20-28 years.\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
