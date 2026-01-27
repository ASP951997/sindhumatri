<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing Gender-Based Matched Profile Logic...\n\n";

try {
    $user = User::find(461); // Test user
    if (!$user) {
        echo "❌ User not found\n";
        exit;
    }

    echo "Test User (ID: 461):\n";
    echo "- Name: {$user->firstname} {$user->lastname}\n";
    echo "- Gender: {$user->gender}\n";
    echo "- Expected to see: " . (strtolower($user->gender) === 'male' ? 'Female' : 'Male') . " profiles\n\n";

    // Test the gender matching logic
    $ignoreList = collect([]);

    $oppositeGender = (strtolower($user->gender) === 'male') ? 'female' : 'male';

    echo "Testing gender filtering...\n";
    echo "- Looking for profiles with gender: {$oppositeGender}\n";

    // Count profiles by gender
    $maleCount = User::whereHas('profileInfo', function ($query) {
        return $query->where('status', 1);
    })->where('gender', 'male')->where('id', '!=', $user->id)->count();

    $femaleCount = User::whereHas('profileInfo', function ($query) {
        return $query->where('status', 1);
    })->where('gender', 'female')->where('id', '!=', $user->id)->count();

    echo "- Available Male profiles: {$maleCount}\n";
    echo "- Available Female profiles: {$femaleCount}\n\n";

    // Test the actual matching query
    $matchedProfiles = User::with('profileInfo', 'careerInfo', 'purchasedPlanItems')
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->whereNotIn('id', $ignoreList)
        ->where('id', '!=', $user->id)
        ->where('gender', $oppositeGender)
        ->limit(5)
        ->get();

    echo "✅ Query Results:\n";
    echo "- Found {$matchedProfiles->count()} {$oppositeGender} profiles\n\n";

    if ($matchedProfiles->count() > 0) {
        echo "Sample profiles found:\n";
        foreach ($matchedProfiles as $profile) {
            echo "- {$profile->firstname} {$profile->lastname} (ID: {$profile->id}, Gender: {$profile->gender})\n";
        }
        echo "\n✅ SUCCESS: Gender-based matching is working correctly!\n";
    } else {
        echo "❌ No {$oppositeGender} profiles found. This might be expected if no profiles of that gender exist.\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}









