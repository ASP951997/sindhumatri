<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "=== VERIFYING USER PROFILE DATA RESTORATION ===\n\n";

try {
    // Get sample users to check data restoration
    $sampleUsers = User::with(['getReligion', 'getCaste', 'getPresentCountry'])
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->take(5)
        ->get();

    echo "Sample Users After Restoration:\n";
    echo str_repeat("=", 80) . "\n";

    foreach ($sampleUsers as $user) {
        echo "User ID: {$user->id}\n";
        echo "Name: {$user->firstname} {$user->lastname}\n";
        echo "Email: {$user->email}\n";
        echo "Phone: {$user->phone}\n\n";

        echo "Demographic Data:\n";
        echo "- Gender: '{$user->gender}'\n";
        echo "- Age: '{$user->age}'\n";
        echo "- Height: '{$user->height}'\n";
        echo "- Weight: '{$user->weight}'\n\n";

        echo "Religious & Social:\n";
        echo "- Religion ID: '{$user->religion}' → Name: '" . (optional($user->getReligion)->name ?? 'N/A') . "'\n";
        echo "- Caste ID: '{$user->caste}' → Name: '" . (optional($user->getCaste)->name ?? 'N/A') . "'\n\n";

        echo "Location:\n";
        echo "- Present Country: '{$user->present_country}' → Name: '" . (optional($user->getPresentCountry)->name ?? 'N/A') . "'\n";
        echo "- Permanent Country: '{$user->permanent_country}'\n\n";

        echo "Education & Career:\n";
        echo "- Education Level: '{$user->education_level}'\n";
        echo "- Occupation: '{$user->occupation}'\n";
        echo "- Marital Status: '{$user->marital_status}'\n\n";

        echo "Partner Expectations:\n";
        echo "- Partner Gender: '{$user->partner_gender}'\n";
        echo "- Partner Religion: '{$user->partner_religion}'\n";
        echo "- Partner Caste: '{$user->partner_caste}'\n";
        echo "- Partner Education: '{$user->partner_education}'\n\n";

        echo str_repeat("-", 80) . "\n";
    }

    // Overall statistics
    echo "\n=== DATA POPULATION STATISTICS ===\n";

    $totalUsers = User::count();
    $activeProfiles = DB::table('profile_infos')->where('status', 1)->count();

    $dataCounts = [
        'gender' => User::whereNotNull('gender')->where('gender', '!=', '')->count(),
        'age' => User::whereNotNull('age')->where('age', '>', 0)->count(),
        'height' => User::whereNotNull('height')->where('height', '!=', '')->count(),
        'weight' => User::whereNotNull('weight')->where('weight', '!=', '')->count(),
        'religion' => User::whereNotNull('religion')->where('religion', '!=', '')->count(),
        'caste' => User::whereNotNull('caste')->where('caste', '!=', '')->count(),
        'marital_status' => User::whereNotNull('marital_status')->where('marital_status', '!=', '')->count(),
        'education_level' => User::whereNotNull('education_level')->where('education_level', '!=', '')->count(),
        'occupation' => User::whereNotNull('occupation')->where('occupation', '!=', '')->count(),
        'present_country' => User::whereNotNull('present_country')->where('present_country', '!=', '')->count(),
        'permanent_country' => User::whereNotNull('permanent_country')->where('permanent_country', '!=', '')->count(),
        'partner_gender' => User::whereNotNull('partner_gender')->where('partner_gender', '!=', '')->count(),
        'partner_religion' => User::whereNotNull('partner_religion')->where('partner_religion', '!=', '')->count(),
        'partner_caste' => User::whereNotNull('partner_caste')->where('partner_caste', '!=', '')->count(),
        'partner_education' => User::whereNotNull('partner_education')->where('partner_education', '!=', '')->count(),
    ];

    echo "Total Users: {$totalUsers}\n";
    echo "Active Profiles: {$activeProfiles}\n\n";

    echo "Data Population:\n";
    foreach ($dataCounts as $field => $count) {
        $percentage = $totalUsers > 0 ? round(($count / $totalUsers) * 100, 1) : 0;
        $status = $percentage > 50 ? '✅' : ($percentage > 20 ? '⚠️' : '❌');
        echo "{$status} {$field}: {$count} users ({$percentage}%)\n";
    }

    echo "\n=== MATCHED PROFILES TEST ===\n";

    // Test matched profiles for user 461 (the one we know has partner preferences)
    $testUser = User::find(461);
    if ($testUser && !empty($testUser->partner_gender)) {
        echo "Testing matched profiles for user {$testUser->firstname} {$testUser->lastname} (ID: {$testUser->id})\n";
        echo "Partner preferences: Gender={$testUser->partner_gender}\n\n";

        // Count potential matches
        $potentialMatches = User::whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->where('id', '!=', $testUser->id)
        ->where('gender', $testUser->partner_gender)
        ->count();

        echo "Potential matches found: {$potentialMatches}\n";

        if ($potentialMatches > 0) {
            $sampleMatches = User::whereHas('profileInfo', function ($query) {
                return $query->where('status', 1);
            })
            ->where('id', '!=', $testUser->id)
            ->where('gender', $testUser->partner_gender)
            ->take(3)
            ->get();

            echo "\nSample matches:\n";
            foreach ($sampleMatches as $match) {
                echo "- {$match->firstname} {$match->lastname} (ID: {$match->id}) - Age: {$match->age}, Height: {$match->height}\n";
            }
        }
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}









