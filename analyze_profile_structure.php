<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== ANALYZING USER PROFILE DATABASE STRUCTURE ===\n\n";

echo "1. USERS TABLE COLUMNS:\n";
echo "======================\n";
$usersColumns = \Schema::getColumnListing('users');
foreach ($usersColumns as $column) {
    echo "- {$column}\n";
}

echo "\n2. PROFILE_INFOS TABLE COLUMNS:\n";
echo "===============================\n";
$profileColumns = \Schema::getColumnListing('profile_infos');
foreach ($profileColumns as $column) {
    echo "- {$column}\n";
}

echo "\n3. RELATED TABLES ANALYSIS:\n";
echo "===========================\n";

// Check if other related tables exist
$relatedTables = [
    'education_infos',
    'career_infos',
    'galleries',
    'shortlists',
    'interests',
    'profile_views',
    'user_posts',
    'messengers',
    'reports'
];

foreach ($relatedTables as $table) {
    if (\Schema::hasTable($table)) {
        $count = \Schema::getColumnListing($table);
        echo "✅ {$table}: " . count($count) . " columns\n";
    } else {
        echo "❌ {$table}: Table does not exist\n";
    }
}

echo "\n4. PROFILE SECTIONS TO ANALYZE:\n";
echo "===============================\n";
$profileSections = [
    'Present Address' => ['present_country', 'present_state', 'present_city', 'present_address'],
    'Permanent Address' => ['permanent_country', 'permanent_state', 'permanent_city', 'permanent_address'],
    'Physical Attributes' => ['height', 'weight', 'body_type', 'complexion', 'hair_color', 'body_art', 'ethnicity'],
    'Education Info' => ['education_level', 'education_field', 'college_name', 'passing_year'],
    'Career Info' => ['occupation', 'company_name', 'annual_income', 'work_experience'],
    'Language' => ['languages_known'],
    'Hobbies & Interest' => ['hobbies', 'interests', 'music', 'books', 'movies', 'sports'],
    'Spiritual & Social Background' => ['religion', 'caste', 'sub_caste', 'family_value', 'community_value', 'political_views', 'religious_service'],
    'Lifestyle' => ['diet', 'smoke', 'drink', 'living_situation'],
    'Astronomic Information' => ['birth_time', 'birth_place', 'manglik', 'horoscope'],
    'Family Information' => ['father_name', 'father_occupation', 'mother_name', 'mother_occupation', 'brothers', 'sisters', 'family_type', 'family_status'],
    'Partner Expectation' => ['partner_age_min', 'partner_age_max', 'partner_height_min', 'partner_height_max', 'partner_education', 'partner_occupation', 'partner_income', 'partner_religion', 'partner_caste', 'partner_country', 'partner_state', 'partner_city']
];

$missingColumns = [];

foreach ($profileSections as $section => $fields) {
    echo "\n{$section}:\n";
    foreach ($fields as $field) {
        $exists = in_array($field, $usersColumns);
        if ($exists) {
            echo "  ✅ {$field} (users table)\n";
        } else {
            echo "  ❌ {$field} (MISSING)\n";
            $missingColumns[$section][] = $field;
        }
    }
}

echo "\n5. SUMMARY OF MISSING COLUMNS:\n";
echo "===============================\n";
$totalMissing = 0;
foreach ($missingColumns as $section => $fields) {
    echo "{$section}: " . count($fields) . " missing\n";
    $totalMissing += count($fields);
}
echo "\nTOTAL MISSING COLUMNS: {$totalMissing}\n";

if ($totalMissing > 0) {
    echo "\n6. ACTION REQUIRED:\n";
    echo "==================\n";
    echo "Create migration to add {$totalMissing} missing columns to users table\n";
}










