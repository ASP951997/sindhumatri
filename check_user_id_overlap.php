<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== CHECKING USER ID OVERLAP ===\n\n";

    $backupFile = 'u105084344_matrimony_111.sql';

    if (!file_exists($backupFile)) {
        die("❌ Backup file not found: $backupFile\n");
    }

    // Get all user IDs from current database
    $currentUserIds = DB::table('users')->pluck('id')->toArray();
    echo "Current database has " . count($currentUserIds) . " users\n";
    echo "Current user ID range: " . min($currentUserIds) . " - " . max($currentUserIds) . "\n\n";

    // Extract user IDs from backup file
    $sqlContent = file_get_contents($backupFile);
    $pattern = '/INSERT INTO `users` \([^)]+\) VALUES([^;]+);/';
    preg_match_all($pattern, $sqlContent, $matches);

    $backupUserIds = [];

    foreach ($matches[1] as $insertChunk) {
        $values = trim($insertChunk);
        $rows = preg_split('/\),\s*\(/', $values);

        foreach ($rows as $row) {
            $row = trim($row, '()');
            if (empty($row)) continue;

            $fields = str_getcsv($row);
            if (count($fields) >= 1) {
                $userId = trim($fields[0], "'");
                if (is_numeric($userId)) {
                    $backupUserIds[] = (int)$userId;
                }
            }
        }
    }

    $backupUserIds = array_unique($backupUserIds);
    sort($backupUserIds);

    echo "Backup file has " . count($backupUserIds) . " users\n";
    echo "Backup user ID range: " . min($backupUserIds) . " - " . max($backupUserIds) . "\n\n";

    // Find overlapping IDs
    $overlappingIds = array_intersect($currentUserIds, $backupUserIds);
    echo "Overlapping user IDs: " . count($overlappingIds) . "\n";

    if (count($overlappingIds) > 0) {
        echo "Sample overlapping IDs: " . implode(', ', array_slice($overlappingIds, 0, 10)) . (count($overlappingIds) > 10 ? '...' : '') . "\n\n";
    }

    // Check how many overlapping users are missing DOB
    $overlappingWithoutDob = DB::table('users')
        ->whereIn('id', $overlappingIds)
        ->where(function($q) { $q->whereNull('date_of_birth')->orWhere('date_of_birth', ''); })
        ->count();

    echo "Overlapping users missing DOB: $overlappingWithoutDob\n\n";

    if ($overlappingWithoutDob > 0) {
        echo "✅ There are overlapping users that can be updated with DOB data\n";
    } else {
        echo "❌ All overlapping users already have DOB data\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>
