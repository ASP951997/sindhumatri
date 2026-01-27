<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing partner education fix...\n\n";

try {
    $user = User::find(461);
    if (!$user) {
        echo "❌ User not found\n";
        exit;
    }

    // Test 1: String value (from old cached form) - simulate controller logic
    echo "Test 1: String input 'High School (10th)'\n";
    $educationValue = 'High School (10th)';

    if (is_numeric($educationValue)) {
        $user->partner_education = $educationValue;
    } else {
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
        $user->partner_education = $educationMapping[$educationValue] ?? null;
    }

    $user->save();
    echo "✅ Success! Stored ID: " . $user->partner_education . "\n\n";

    // Test 2: ID value (from new form)
    echo "Test 2: ID input 5 (Bachelor's Degree)\n";
    $user->partner_education = 5;
    $user->save();
    echo "✅ Success! Stored ID: " . $user->partner_education . "\n\n";

    // Test 3: Full partner expectation update simulation
    echo "Test 3: Full partner expectation update\n";
    $educationValue = 'High School (10th)'; // String input

    if (is_numeric($educationValue)) {
        $user->partner_education = $educationValue;
    } else {
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
        $user->partner_education = $educationMapping[$educationValue] ?? null;
    }
    $user->partner_religion = 3;
    $user->partner_caste = 17;
    $user->partner_general_requirement = 'support';
    $user->partner_min_height = '4ft 5in';
    $user->partner_max_weight = '5ft 6in';
    $user->partner_language = 'Hindi';
    $user->partner_dieting_acceptancy = 'Non-Veg';
    $user->partner_body_type = 2;
    $user->partner_preferred_country = 101;
    $user->partner_family_value = 11;
    $user->partner_complexion = 9;
    $user->save();
    echo "✅ Full update successful!\n";
    echo "Education ID: " . $user->partner_education . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
