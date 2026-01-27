<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Count total users first
    $totalUsers = DB::table('users')->count();

    // Count total female users
    $totalFemales = DB::table('users')
        ->where('gender', 'female')
        ->count();

    // Get all distinct ages for females
    $ageResults = DB::table('users')
        ->where('gender', 'female')
        ->whereNotNull('age')
        ->select('age', DB::raw('COUNT(*) as count'))
        ->groupBy('age')
        ->orderBy('age')
        ->get();

    echo "=== COMPLETE FEMALE PROFILES ANALYSIS ===\n\n";
    echo "Total Users in Database: $totalUsers\n";
    echo "Total Female Profiles: $totalFemales\n\n";

    echo "=== FEMALE PROFILES BY AGE ===\n";
    $totalByAge = 0;
    foreach ($ageResults as $result) {
        echo "Age {$result->age}: {$result->count} profiles\n";
        $totalByAge += $result->count;
    }

    echo "\n=== SUMMARY ===\n";
    echo "Total female profiles counted by age: $totalByAge\n";
    echo "This matches the total female count: " . ($totalByAge == $totalFemales ? "YES" : "NO") . "\n";

    // Also check for females with null age
    $nullAgeCount = DB::table('users')
        ->where('gender', 'female')
        ->whereNull('age')
        ->count();

    if ($nullAgeCount > 0) {
        echo "Female profiles with no age specified: $nullAgeCount\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
