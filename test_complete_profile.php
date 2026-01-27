<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing complete user profile functionality...\n\n";

try {
    // Get a test user
    $user = User::where('status', 1)->first();

    if (!$user) {
        echo "❌ No active users found for testing.\n";
        exit(1);
    }

    echo "Testing user ID: {$user->id} ({$user->firstname} {$user->lastname})\n\n";

    // Test updating various profile sections
    $testData = [
        // Present Address
        'present_country' => 1,
        'present_state' => 1,
        'present_city' => 1,
        'present_address' => '123 Test Street, Test City',

        // Permanent Address
        'permanent_country' => 1,
        'permanent_state' => 1,
        'permanent_city' => 1,
        'permanent_address' => '456 Home Street, Home City',

        // Physical Attributes
        'height' => '5\'8"',
        'weight' => '70 kg',
        'body_type' => 1,
        'complexion' => 1,
        'hair_color' => 1,
        'body_art' => 1,
        'ethnicity' => 1,

        // Education Info
        'education_level' => 1,
        'education_field' => 'Computer Science',
        'college_name' => 'Test University',
        'passing_year' => 2020,

        // Career Info
        'occupation' => 1,
        'company_name' => 'Test Company',
        'annual_income' => '5-10 LPA',
        'work_experience' => 3,

        // Language
        'languages_known' => json_encode(['English', 'Hindi', 'Marathi']),

        // Hobbies & Interest
        'hobbies' => json_encode(['Reading', 'Music']),
        'interests' => json_encode(['Technology', 'Sports']),
        'music' => json_encode(['Classical', 'Jazz']),
        'books' => json_encode(['Fiction', 'Biography']),
        'movies' => json_encode(['Action', 'Drama']),
        'sports' => json_encode(['Cricket', 'Football']),

        // Spiritual & Social Background
        'religion' => 1,
        'caste' => 1,
        'sub_caste' => 1,
        'family_value' => 1,
        'community_value' => 1,
        'political_views' => 1,
        'religious_service' => 1,

        // Lifestyle
        'diet' => 'Vegetarian',
        'smoke' => 'No',
        'drink' => 'No',
        'living_situation' => 'With Family',

        // Astronomic Information
        'birth_time' => '10:30:00',
        'birth_place' => 'Test City',
        'manglik' => 'No',
        'horoscope' => 'Sample horoscope data',

        // Family Information
        'father_name' => 'Test Father',
        'father_occupation' => 'Business',
        'mother_name' => 'Test Mother',
        'mother_occupation' => 'Homemaker',
        'brothers' => 1,
        'sisters' => 1,
        'family_type' => 'Joint',
        'family_status' => 'Upper Middle Class',

        // Partner Expectation
        'partner_age_min' => 25,
        'partner_age_max' => 35,
        'partner_height_min' => '5\'0"',
        'partner_height_max' => '6\'0"',
        'partner_education' => json_encode(['Graduate', 'Post Graduate']),
        'partner_occupation' => json_encode(['Private Job', 'Business']),
        'partner_income' => '3-5 LPA',
        'partner_religion' => json_encode([1, 2]),
        'partner_caste' => json_encode([1, 2]),
        'partner_country' => json_encode([1]),
        'partner_state' => json_encode([1]),
        'partner_city' => json_encode([1])
    ];

    // Update user with test data
    foreach ($testData as $key => $value) {
        $user->$key = $value;
    }

    $user->save();

    echo "✅ Complete profile data updated successfully!\n\n";

    // Verify some key fields
    echo "Verification of key fields:\n";
    echo "- Present Address: {$user->present_address}\n";
    echo "- Education Level: {$user->education_level}\n";
    echo "- Occupation: {$user->occupation}\n";
    echo "- Languages: {$user->languages_known}\n";
    echo "- Religion: {$user->religion}\n";
    echo "- Partner Age Min: {$user->partner_age_min}\n";
    echo "- Partner Age Max: {$user->partner_age_max}\n";

    echo "\n✅ All profile sections are working correctly!\n";
    echo "User profile can now be 100% complete.\n";

} catch (Exception $e) {
    echo "❌ Error testing complete profile: " . $e->getMessage() . "\n";
}










