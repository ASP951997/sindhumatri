<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Checking Gender Data in Users Table...\n\n";

try {
    // Check distinct gender values
    $genders = User::distinct()->pluck('gender')->filter()->values();
    echo "Distinct gender values in users table: " . json_encode($genders) . "\n\n";

    // Count profiles by gender (with active profile status)
    $genderCounts = User::selectRaw('gender, COUNT(*) as count')
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->groupBy('gender')
        ->get();

    echo "Active profiles by gender:\n";
    foreach ($genderCounts as $count) {
        echo "- {$count->gender}: {$count->count} profiles\n";
    }

    echo "\n";

    // Check a few sample profiles
    $sampleProfiles = User::with('profileInfo')
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->take(5)
        ->get(['id', 'firstname', 'lastname', 'gender']);

    echo "Sample active profiles:\n";
    foreach ($sampleProfiles as $profile) {
        echo "- ID {$profile->id}: {$profile->firstname} {$profile->lastname} (Gender: {$profile->gender})\n";
    }

    // Check if there are any profiles without gender set
    $nullGenderCount = User::whereNull('gender')
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->count();

    echo "\nProfiles with NULL gender: {$nullGenderCount}\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}









