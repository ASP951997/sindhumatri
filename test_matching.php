<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Http\Controllers\User\ProfileViewController;

echo "Testing matched profile functionality...\n\n";

try {
    // Get a test user with partner expectations
    $user = User::find(461); // Use the same user ID from previous tests

    if (!$user) {
        echo "❌ User not found\n";
        exit;
    }

    echo "User found: {$user->firstname} {$user->lastname}\n";
    echo "Partner expectations:\n";
    echo "- Gender: {$user->partner_gender}\n";
    echo "- Age range: {$user->partner_age_min} - {$user->partner_age_max}\n";
    echo "- Religion: {$user->partner_religion}\n";
    echo "- Caste: {$user->partner_caste}\n";
    echo "- Education: {$user->partner_education}\n";
    echo "- Preferred Country: {$user->partner_preferred_country}\n";
    echo "- Preferred State: {$user->partner_preferred_state}\n";
    echo "- Preferred City: {$user->partner_preferred_city}\n\n";

    // Test the matching logic by simulating the controller method
    $ignoreList = collect([]);
    $matchedProfiles = User::with('profileInfo', 'careerInfo', 'purchasedPlanItems')
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->whereNotIn('id', $ignoreList)
        ->where('id', '!=', $user->id)
        ->when(isset($user->partner_age_min), function ($query) use ($user) {
            return $query->where('age', '>=', $user->partner_age_min);
        })
        ->when(isset($user->partner_age_max), function ($query) use ($user) {
            return $query->where('age', '<=', $user->partner_age_max);
        })
        ->when(isset($user->partner_gender), function ($query) use ($user) {
            return $query->where('gender', $user->partner_gender);
        })
        ->when(isset($user->partner_religion), function ($query) use ($user) {
            return $query->where('religion', $user->partner_religion);
        })
        ->when(isset($user->partner_caste), function ($query) use ($user) {
            return $query->where('caste', $user->partner_caste);
        })
        ->when(isset($user->partner_education), function ($query) use ($user) {
            return $query->where('education_level', $user->partner_education);
        })
        ->when(isset($user->partner_preferred_country), function ($query) use ($user) {
            return $query->where('permanent_country', $user->partner_preferred_country);
        })
        ->when(isset($user->partner_preferred_state), function ($query) use ($user) {
            return $query->where('permanent_state', $user->partner_preferred_state);
        })
        ->when(isset($user->partner_preferred_city), function ($query) use ($user) {
            return $query->where('permanent_city', $user->partner_preferred_city);
        })
        ->take(5) // Limit to 5 for testing
        ->get();

    echo "✅ Matching query executed successfully!\n";
    echo "Found {$matchedProfiles->count()} matching profiles:\n\n";

    if ($matchedProfiles->count() == 0) {
        echo "No profiles match all criteria. Let's check individual filters:\n\n";

        // Check gender filter
        $genderCount = User::where('gender', $user->partner_gender)
                          ->where('id', '!=', $user->id)
                          ->whereHas('profileInfo', function ($query) {
                              return $query->where('status', 1);
                          })
                          ->count();
        echo "- Gender filter ({$user->partner_gender}): {$genderCount} profiles\n";

        // Check religion filter
        $religionCount = User::where('religion', $user->partner_religion)
                            ->where('id', '!=', $user->id)
                            ->whereHas('profileInfo', function ($query) {
                                return $query->where('status', 1);
                            })
                            ->count();
        echo "- Religion filter ({$user->partner_religion}): {$religionCount} profiles\n";

        // Check caste filter
        $casteCount = User::where('caste', $user->partner_caste)
                         ->where('id', '!=', $user->id)
                         ->whereHas('profileInfo', function ($query) {
                             return $query->where('status', 1);
                         })
                         ->count();
        echo "- Caste filter ({$user->partner_caste}): {$casteCount} profiles\n";

        // Check education filter
        $educationCount = User::where('education_level', $user->partner_education)
                             ->where('id', '!=', $user->id)
                             ->whereHas('profileInfo', function ($query) {
                                 return $query->where('status', 1);
                             })
                             ->count();
        echo "- Education filter ({$user->partner_education}): {$educationCount} profiles\n";

        // Check country filter
        $countryCount = User::where('permanent_country', $user->partner_preferred_country)
                           ->where('id', '!=', $user->id)
                           ->whereHas('profileInfo', function ($query) {
                               return $query->where('status', 1);
                           })
                           ->count();
        echo "- Country filter ({$user->partner_preferred_country}): {$countryCount} profiles\n";

        // Check combination of gender + religion
        $comboCount = User::where('gender', $user->partner_gender)
                         ->where('religion', $user->partner_religion)
                         ->where('id', '!=', $user->id)
                         ->whereHas('profileInfo', function ($query) {
                             return $query->where('status', 1);
                         })
                         ->count();
        echo "- Gender + Religion combo: {$comboCount} profiles\n";

    } else {
        foreach ($matchedProfiles as $profile) {
            echo "- {$profile->firstname} {$profile->lastname} (ID: {$profile->id})\n";
            echo "  Age: {$profile->age}, Gender: {$profile->gender}\n";
            echo "  Religion: {$profile->religion}, Caste: {$profile->caste}\n";
            echo "  Education Level: {$profile->education_level}\n";
            echo "  Location: {$profile->permanent_country}, {$profile->permanent_state}, {$profile->permanent_city}\n\n";
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
