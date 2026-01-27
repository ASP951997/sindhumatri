<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking lifestyle columns...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing lifestyle-related):\n";
foreach ($columns as $column) {
    if (strpos($column, 'diet') !== false || strpos($column, 'smoke') !== false ||
        strpos($column, 'drink') !== false || strpos($column, 'living') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking for missing lifestyle columns:\n";
$requiredColumns = ['diet', 'smoke', 'drink', 'living_with'];

foreach ($requiredColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}










