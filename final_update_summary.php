<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== FINAL DATA UPDATE SUMMARY ===\n\n";

    // Get comprehensive statistics
    $totalUsers = DB::table('users')->count();

    $stats = [
        'with_age' => DB::table('users')->whereNotNull('age')->where('age', '>', 0)->count(),
        'without_age' => DB::table('users')->where(function($q) { $q->whereNull('age')->orWhere('age', 0); })->count(),
        'with_images' => DB::table('users')->whereNotNull('image')->where('image', '!=', '')->count(),
        'without_images' => DB::table('users')->where(function($q) { $q->whereNull('image')->orWhere('image', ''); })->count(),
        'complete_profiles' => DB::table('users')
            ->whereNotNull('age')->where('age', '>', 0)
            ->whereNotNull('image')->where('image', '!=', '')
            ->count(),
    ];

    echo "📊 DATABASE STATISTICS:\n";
    echo "Total Users: $totalUsers\n";
    echo "Users with age data: {$stats['with_age']} (" . round(($stats['with_age']/$totalUsers)*100, 1) . "%)\n";
    echo "Users with image data: {$stats['with_images']} (" . round(($stats['with_images']/$totalUsers)*100, 1) . "%)\n";
    echo "Complete profiles (age + image): {$stats['complete_profiles']} (" . round(($stats['complete_profiles']/$totalUsers)*100, 1) . "%)\n\n";

    echo "🎯 UPDATE RESULTS:\n";
    echo "✅ Successfully restored image data for " . (441 - $stats['without_images']) . " profiles\n";
    echo "⚠️  Age data restoration was limited - only {$stats['with_age']} profiles now have age data\n\n";

    // Show gender breakdown
    echo "👥 GENDER BREAKDOWN:\n";

    $genderStats = DB::table('users')
        ->selectRaw("gender, COUNT(*) as total,
                    SUM(CASE WHEN age > 0 AND age IS NOT NULL THEN 1 ELSE 0 END) as with_age,
                    SUM(CASE WHEN image IS NOT NULL AND image != '' THEN 1 ELSE 0 END) as with_image")
        ->whereNotNull('gender')
        ->groupBy('gender')
        ->get();

    foreach ($genderStats as $stat) {
        echo "{$stat->gender}: {$stat->total} total, {$stat->with_age} with age, {$stat->with_image} with images\n";
    }

    echo "\n🔍 DETAILED ANALYSIS:\n";

    // Check what fields are still missing
    $missingFields = DB::table('users')
        ->selectRaw("
            SUM(CASE WHEN age IS NULL OR age = 0 THEN 1 ELSE 0 END) as missing_age,
            SUM(CASE WHEN image IS NULL OR image = '' THEN 1 ELSE 0 END) as missing_image,
            SUM(CASE WHEN gender IS NULL OR gender = '' THEN 1 ELSE 0 END) as missing_gender,
            SUM(CASE WHEN date_of_birth IS NULL OR date_of_birth = '' THEN 1 ELSE 0 END) as missing_dob
        ")
        ->first();

    echo "Fields still missing:\n";
    echo "- Age: {$missingFields->missing_age} profiles\n";
    echo "- Images: {$missingFields->missing_image} profiles\n";
    echo "- Gender: {$missingFields->missing_gender} profiles\n";
    echo "- Date of Birth: {$missingFields->missing_dob} profiles\n\n";

    echo "💡 RECOMMENDATIONS:\n";
    if ($stats['without_images'] == 0) {
        echo "✅ Image restoration: COMPLETE\n";
    }
    if ($stats['without_age'] > 0) {
        echo "⚠️  Age data: Still {$stats['without_age']} profiles missing age\n";
        echo "   - Consider calculating age from date_of_birth for remaining profiles\n";
        echo "   - Or check if backup file had complete age data\n";
    }

    echo "\n🔧 NEXT STEPS:\n";
    echo "1. Verify that all profile images are accessible in the uploads directory\n";
    echo "2. Consider implementing age calculation from date_of_birth for remaining profiles\n";
    echo "3. Check if additional backup files contain missing data\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>
