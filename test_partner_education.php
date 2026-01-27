<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

try {
    $user = User::find(461);
    if ($user) {
        echo "User found. Current partner_education: " . ($user->partner_education ?? 'NULL') . "\n";

        // Test the full partner expectation update like the controller does
        $testData = [
            'partner_education' => "Bachelor's Degree",
            'partner_religion' => '3',
            'partner_caste' => '17',
            'partner_general_requirement' => 'supportive, and believe',
            'partner_sub_caste' => '',
            'partner_language' => 'English',
            'partner_profession' => '',
            'partner_personal_value' => '',
            'partner_manglik' => 'Does Not Matter',
            'partner_preferred_state' => '',
            'partner_preferred_city' => '',
            'partner_family_value' => '13'
        ];

        // Map education string to ID (simulating controller logic)
        $educationMapping = [
            'Below 10th' => 1,
            'High School (10th)' => 2,
            'Intermediate (12th)' => 3,
            'Diploma' => 4,
            "Bachelor's Degree" => 5,
            "Master's Degree" => 6,
            'Doctorate (PhD)' => 7,
            'Post-Doctorate' => 8,
        ];

        $user->partner_education = $educationMapping[$testData['partner_education']] ?? null;
        $user->partner_religion = $testData['partner_religion'];
        $user->partner_caste = $testData['partner_caste'];
        $user->partner_general_requirement = $testData['partner_general_requirement'];
        $user->partner_sub_caste = $testData['partner_sub_caste'] ?: [];
        $user->partner_language = $testData['partner_language'];
        $user->partner_profession = $testData['partner_profession'];
        $user->partner_smoking_acceptancy = 'Does Not Matter'; // Default values
        $user->partner_drinking_acceptancy = 'Does Not Matter';
        $user->partner_dieting_acceptancy = 'Occasionally non-veg';
        $user->partner_body_type = 1;
        $user->partner_personal_value = $testData['partner_personal_value'];
        $user->partner_manglik = $testData['partner_manglik'];
        $user->partner_preferred_country = null;
        $user->partner_preferred_state = null;
        $user->partner_preferred_city = null;
        $user->partner_family_value = $testData['partner_family_value'];
        $user->partner_complexion = 1;

        $user->save();

        echo "Full partner expectation update successful!\n";
        echo "partner_education: " . $user->partner_education . "\n";
        echo "partner_religion: " . $user->partner_religion . "\n";
        echo "partner_caste: " . $user->partner_caste . "\n";
    } else {
        echo "User not found\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
