<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking for 'present_postcode' column...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing address-related):\n";
foreach ($columns as $column) {
    if (strpos($column, 'present') !== false || strpos($column, 'address') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking if 'present_postcode' column exists...\n";
if (\Schema::hasColumn('users', 'present_postcode')) {
    echo "✅ 'present_postcode' column exists in users table\n";
} else {
    echo "❌ 'present_postcode' column does NOT exist in users table\n";
    echo "Need to add this column.\n";
}










