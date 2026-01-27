<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Checking astronomic information columns...\n\n";

$columns = \Schema::getColumnListing('users');
echo "Current users table columns (showing astronomic-related):\n";
foreach ($columns as $column) {
    if (strpos($column, 'birth') !== false || strpos($column, 'time') !== false ||
        strpos($column, 'sun') !== false || strpos($column, 'moon') !== false ||
        strpos($column, 'manglik') !== false || strpos($column, 'horoscope') !== false) {
        echo "- {$column}\n";
    }
}

echo "\nChecking for missing astronomic columns:\n";
$requiredColumns = ['sun_sign', 'moon_sign', 'time_of_birth', 'city_of_birth'];

foreach ($requiredColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}

echo "\nChecking existing similar columns:\n";
$existingColumns = ['birth_time', 'birth_place', 'manglik', 'horoscope'];
foreach ($existingColumns as $column) {
    if (\Schema::hasColumn('users', $column)) {
        echo "✅ EXISTS: {$column}\n";
    } else {
        echo "❌ MISSING: {$column}\n";
    }
}










