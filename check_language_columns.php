<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking language columns...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing language-related):\n";
foreach ($columns as $column) {
    if (strpos($column, 'language') !== false || strpos($column, 'tongue') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking for missing language columns:\n";
$requiredColumns = ['mother_tongue', 'known_languages'];

foreach ($requiredColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}










