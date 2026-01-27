<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Count total users first
    $totalUsers = DB::table('users')->count();

    // Count total male users
    $totalMales = DB::table('users')
        ->where('gender', 'male')
        ->count();

    // Get all distinct ages for males
    $ageResults = DB::table('users')
        ->where('gender', 'male')
        ->whereNotNull('age')
        ->select('age', DB::raw('COUNT(*) as count'))
        ->groupBy('age')
        ->orderBy('age')
        ->get();

    echo "=== COMPLETE MALE PROFILES ANALYSIS ===\n\n";
    echo "Total Users in Database: $totalUsers\n";
    echo "Total Male Profiles: $totalMales\n\n";

    echo "=== MALE PROFILES BY AGE ===\n";
    $totalByAge = 0;
    foreach ($ageResults as $result) {
        echo "Age {$result->age}: {$result->count} profiles\n";
        $totalByAge += $result->count;
    }

    echo "\n=== SUMMARY ===\n";
    echo "Total male profiles counted by age: $totalByAge\n";
    echo "This matches the total male count: " . ($totalByAge == $totalMales ? "YES" : "NO") . "\n";

    // Also check for males with null age
    $nullAgeCount = DB::table('users')
        ->where('gender', 'male')
        ->whereNull('age')
        ->count();

    if ($nullAgeCount > 0) {
        echo "Male profiles with no age specified: $nullAgeCount\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
