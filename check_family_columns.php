<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking family information columns...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing family-related):\n";
foreach ($columns as $column) {
    if (strpos($column, 'father') !== false || strpos($column, 'mother') !== false ||
        strpos($column, 'brother') !== false || strpos($column, 'sister') !== false ||
        strpos($column, 'family') !== false || strpos($column, 'sibling') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking for missing family columns:\n";
$requiredColumns = ['father', 'mother', 'brother_no', 'brother_married', 'sister_no', 'sibling_position', 'family_income'];

foreach ($requiredColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}

echo "\nChecking existing similar columns:\n";
$existingColumns = ['father_name', 'father_occupation', 'mother_name', 'mother_occupation', 'brothers', 'sisters', 'family_type', 'family_status'];
foreach ($existingColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}










