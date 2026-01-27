<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Users table columns:\n";
$columns = \Schema::getColumnListing('users');
foreach ($columns as $column) {
    echo "- {$column}\n";
}

echo "\nChecking if 'introduction' column exists...\n";
if (\Schema::hasColumn('users', 'introduction')) {
    echo "✅ 'introduction' column exists in users table\n";
} else {
    echo "❌ 'introduction' column does NOT exist in users table\n";
}

echo "\nChecking profile_infos table...\n";
if (\Schema::hasTable('profile_infos')) {
    echo "profile_infos table exists\n";
    $profileColumns = \Schema::getColumnListing('profile_infos');
    echo "Columns: " . implode(', ', $profileColumns) . "\n";

    if (\Schema::hasColumn('profile_infos', 'introduction')) {
        echo "✅ 'introduction' column exists in profile_infos table\n";
    } else {
        echo "❌ 'introduction' column does NOT exist in profile_infos table\n";
    }
} else {
    echo "❌ profile_infos table does not exist\n";
}