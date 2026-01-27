<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== FIXING USER PROFILE DATA ===\n\n";

try {
    // First, let's clean up the gender data - remove extra quotes and spaces
    echo "Cleaning up gender data...\n";
    $usersWithBadGender = User::where('gender', 'like', '%\'%')->get();

    foreach ($usersWithBadGender as $user) {
        $cleanGender = trim($user->gender, "' ");
        $user->update(['gender' => $cleanGender]);
        echo "Fixed gender for user {$user->id}: '{$user->gender}' → '{$cleanGender}'\n";
    }

    // Add some realistic sample data for testing matched profiles
    echo "\nAdding sample profile data for testing...\n";

    // Sample female profiles
    $femaleProfiles = [
        [
            'id' => 4,
            'gender' => 'Female',
            'age' => 28,
            'height' => '5ft 6in',
            'religion' => 1, // Hindu
            'caste' => 1,
            'marital_status' => 1, // Never Married
            'education_level' => 5, // Bachelor's Degree
            'occupation' => 1,
            'present_country' => 101, // India
            'permanent_country' => 101,
        ],
        [
            'id' => 6,
            'gender' => 'Female',
            'age' => 26,
            'height' => '5ft 4in',
            'religion' => 1,
            'caste' => 2,
            'marital_status' => 1,
            'education_level' => 6, // Master's Degree
            'occupation' => 2,
            'present_country' => 101,
            'permanent_country' => 101,
        ],
    ];

    // Sample male profiles
    $maleProfiles = [
        [
            'id' => 5,
            'gender' => 'Male',
            'age' => 30,
            'height' => '5ft 10in',
            'religion' => 1,
            'caste' => 1,
            'marital_status' => 1,
            'education_level' => 6,
            'occupation' => 3,
            'present_country' => 101,
            'permanent_country' => 101,
        ],
        [
            'id' => 9,
            'gender' => 'Male',
            'age' => 32,
            'height' => '5ft 11in',
            'religion' => 1,
            'caste' => 1,
            'marital_status' => 1,
            'education_level' => 5,
            'occupation' => 1,
            'present_country' => 101,
            'permanent_country' => 101,
        ],
        [
            'id' => 19,
            'gender' => 'Male',
            'age' => 29,
            'height' => '5ft 9in',
            'religion' => 1,
            'caste' => 3,
            'marital_status' => 1,
            'education_level' => 5,
            'occupation' => 2,
            'present_country' => 101,
            'permanent_country' => 101,
        ],
    ];

    // Update profiles
    foreach (array_merge($femaleProfiles, $maleProfiles) as $profileData) {
        $userId = $profileData['id'];
        unset($profileData['id']);

        $user = User::find($userId);
        if ($user) {
            $user->update($profileData);
            echo "✅ Updated profile for user {$user->firstname} {$user->lastname} (ID: {$userId})\n";
        }
    }

    // Set partner preferences for user 461 (our test user)
    $testUser = User::find(461);
    if ($testUser) {
        $partnerPreferences = [
            'partner_gender' => 'Female',
            'partner_age_min' => 20,
            'partner_age_max' => 35,
            'partner_min_height' => '5ft 0in',
            'partner_max_height' => '6ft 0in',
            'partner_religion' => json_encode([1]), // Hindu
            'partner_caste' => json_encode([1, 2]), // Multiple castes
            'partner_education' => json_encode([5, 6]), // Bachelor's and Master's
            'partner_preferred_country' => 101, // India
        ];

        $testUser->update($partnerPreferences);
        echo "\n✅ Set partner preferences for test user {$testUser->firstname} {$testUser->lastname}\n";
    }

    echo "\n=== FINAL VERIFICATION ===\n";

    // Count profiles by gender
    $genderStats = User::selectRaw('gender, COUNT(*) as count')
        ->whereNotNull('gender')
        ->where('gender', '!=', '')
        ->groupBy('gender')
        ->get();

    echo "Gender distribution:\n";
    foreach ($genderStats as $stat) {
        echo "- {$stat->gender}: {$stat->count} profiles\n";
    }

    // Test matched profiles for our test user
    if ($testUser) {
        $oppositeGender = (strtolower($testUser->partner_gender) === 'male') ? 'female' : 'male';

        $matches = User::whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->where('id', '!=', $testUser->id)
        ->where('gender', $oppositeGender)
        ->count();

        echo "\nMatched profiles test for user {$testUser->firstname} (seeking {$oppositeGender} profiles):\n";
        echo "Found: {$matches} potential matches\n";

        if ($matches > 0) {
            $sampleMatches = User::whereHas('profileInfo', function ($query) {
                return $query->where('status', 1);
            })
            ->where('id', '!=', $testUser->id)
            ->where('gender', $oppositeGender)
            ->take(3)
            ->get();

            echo "\nSample matches:\n";
            foreach ($sampleMatches as $match) {
                echo "- {$match->firstname} {$match->lastname} (Age: {$match->age}, Height: {$match->height})\n";
            }
        }
    }

    echo "\n✅ Profile data restoration and setup completed!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}









