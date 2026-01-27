<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking physical attributes columns...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing physical attributes):\n";
foreach ($columns as $column) {
    if (strpos($column, 'height') !== false || strpos($column, 'weight') !== false ||
        strpos($column, 'body') !== false || strpos($column, 'complexion') !== false ||
        strpos($column, 'hair') !== false || strpos($column, 'ethnicity') !== false ||
        strpos($column, 'blood') !== false || strpos($column, 'disability') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking for missing physical attribute columns:\n";
$requiredColumns = ['height', 'weight', 'body_type', 'complexion', 'hair_color', 'body_art', 'ethnicity', 'bloodGroup', 'disability'];

foreach ($requiredColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}










