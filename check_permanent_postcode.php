<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking for 'permanent_postcode' column...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing address-related):\n";
foreach ($columns as $column) {
    if (strpos($column, 'permanent') !== false || strpos($column, 'present') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking if 'permanent_postcode' column exists...\n";
if (\Schema::hasColumn('users', 'permanent_postcode')) {
    echo "✅ 'permanent_postcode' column exists in users table\n";
} else {
    echo "❌ 'permanent_postcode' column does NOT exist in users table\n";
    echo "Need to add this column.\n";
}










