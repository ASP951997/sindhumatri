<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== FINAL DOB UPDATE FROM BACKUP ===\n\n";

    $backupFile = 'u105084344_matrimony_111.sql';

    if (!file_exists($backupFile)) {
        die("❌ Backup file not found: $backupFile\n");
    }

    // First, let's manually extract DOB data from the backup
    $sqlContent = file_get_contents($backupFile);

    // Extract all DOB values from the backup
    $dobData = [];

    // Pattern to match date_of_birth values in the SQL
    $pattern = '/INSERT INTO `users` \([^)]+\) VALUES([^;]+);/';
    preg_match_all($pattern, $sqlContent, $matches);

    echo "Processing " . count($matches[1]) . " INSERT statements...\n\n";

    foreach ($matches[1] as $insertChunk) {
        $values = trim($insertChunk);
        $rows = preg_split('/\),\s*\(/', $values);

        foreach ($rows as $row) {
            $row = trim($row, '()');
            if (empty($row)) continue;

            $fields = str_getcsv($row);

            if (count($fields) >= 20) { // Ensure we have enough fields
                $userId = trim($fields[0], "'");
                $dob = isset($fields[19]) ? trim($fields[19], "'") : '';

                if (is_numeric($userId) && !empty($dob) && $dob != 'NULL' && $dob != '') {
                    $dobData[$userId] = $dob;
                }
            }
        }
    }

    echo "Found " . count($dobData) . " users with DOB data in backup\n\n";

    // Sample of DOB data found
    echo "Sample DOB data from backup:\n";
    $sampleCount = 0;
    foreach ($dobData as $id => $dob) {
        if ($sampleCount < 10) {
            echo "User ID $id: '$dob'\n";
            $sampleCount++;
        }
    }
    echo "\n";

    // Now update the database
    $updatedCount = 0;
    $skippedCount = 0;

    foreach ($dobData as $userId => $dob) {
        // Check if user exists and is missing DOB
        $user = DB::table('users')
            ->where('id', $userId)
            ->where(function($q) {
                $q->whereNull('date_of_birth')
                  ->orWhere('date_of_birth', '');
            })
            ->first();

        if ($user) {
            // Validate DOB format (should be YYYY-MM-DD and not start with 00)
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dob) &&
                !preg_match('/^00\d{2}-/', $dob) &&
                $dob != '0000-00-00') {

                DB::table('users')->where('id', $userId)->update([
                    'date_of_birth' => $dob
                ]);

                $updatedCount++;
                echo "✅ Updated User ID $userId: DOB set to '$dob'\n";

            } else {
                $skippedCount++;
                echo "⚠️  Skipped User ID $userId: Invalid DOB format '$dob'\n";
            }
        }
    }

    echo "\n=== FINAL RESULTS ===\n";
    echo "DOB data found in backup: " . count($dobData) . "\n";
    echo "Users successfully updated: $updatedCount\n";
    echo "Users skipped (invalid DOB): $skippedCount\n\n";

    // Final verification
    $finalStats = [
        'with_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->count(),
        'without_dob' => DB::table('users')->where(function($q) { $q->whereNull('date_of_birth')->orWhere('date_of_birth', ''); })->count(),
    ];

    echo "AFTER UPDATE:\n";
    echo "- Users with DOB: {$finalStats['with_dob']}\n";
    echo "- Users missing DOB: {$finalStats['without_dob']}\n";

    $completionRate = round(($finalStats['with_dob'] / 441) * 100, 1);
    echo "- DOB completion rate: {$completionRate}%\n\n";

    if ($updatedCount > 0) {
        echo "🎉 SUCCESS: Successfully restored DOB data for $updatedCount users!\n";
    } else {
        echo "❌ No users were updated. The backup may not contain valid DOB data for missing users.\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
