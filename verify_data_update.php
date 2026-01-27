<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== VERIFYING DATA UPDATE RESULTS ===\n\n";

    // Check current database state
    $totalUsers = DB::table('users')->count();
    echo "Total users in database: $totalUsers\n\n";

    // Check users without age
    $usersWithoutAge = DB::table('users')
        ->where(function($query) {
            $query->whereNull('age')
                  ->orWhere('age', 0);
        })
        ->count();

    // Check users without images
    $usersWithoutImages = DB::table('users')
        ->where(function($query) {
            $query->whereNull('image')
                  ->orWhere('image', '');
        })
        ->count();

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

    echo "=== CURRENT DATABASE STATUS ===\n";
    echo "Users without age: $usersWithoutAge\n";
    echo "Users without images: $usersWithoutImages\n";
    echo "Users missing both age and images: $usersMissingBoth\n\n";

    // Show some examples of users who now have complete data
    echo "=== EXAMPLES OF UPDATED PROFILES ===\n\n";

    $updatedProfiles = DB::table('users')
        ->whereNotNull('age')
        ->where('age', '>', 0)
        ->whereNotNull('image')
        ->where('image', '!=', '')
        ->select('id', 'firstname', 'lastname', 'username', 'age', 'image', 'gender')
        ->limit(10)
        ->get();

    foreach ($updatedProfiles as $profile) {
        echo "✅ {$profile->firstname} {$profile->lastname} (ID: {$profile->id})\n";
        echo "   Age: {$profile->age}, Gender: {$profile->gender}\n";
        echo "   Image: " . (strlen($profile->image) > 50 ? substr($profile->image, 0, 50) . '...' : $profile->image) . "\n\n";
    }

    // Age distribution
    echo "=== AGE DISTRIBUTION ===\n";
    $ageStats = DB::table('users')
        ->whereNotNull('age')
        ->where('age', '>', 0)
        ->selectRaw('age, COUNT(*) as count')
        ->groupBy('age')
        ->orderBy('age')
        ->get();

    foreach ($ageStats as $stat) {
        echo "Age {$stat->age}: {$stat->count} profiles\n";
    }

    echo "\n=== SUMMARY ===\n";
    $usersWithCompleteData = DB::table('users')
        ->whereNotNull('age')
        ->where('age', '>', 0)
        ->whereNotNull('image')
        ->where('image', '!=', '')
        ->count();

    echo "Profiles with complete age and image data: $usersWithCompleteData out of $totalUsers\n";

    $completionRate = $totalUsers > 0 ? round(($usersWithCompleteData / $totalUsers) * 100, 2) : 0;
    echo "Profile completion rate: {$completionRate}%\n\n";

    if ($usersWithoutAge == 0 && $usersWithoutImages == 0) {
        echo "🎉 SUCCESS: All profiles now have age and image data!\n";
    } else {
        echo "📝 Still need to update:\n";
        echo "   - $usersWithoutAge profiles missing age\n";
        echo "   - $usersWithoutImages profiles missing images\n";
        echo "   - $usersMissingBoth profiles missing both\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
