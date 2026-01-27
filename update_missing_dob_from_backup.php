<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== UPDATING MISSING DATE OF BIRTH FROM BACKUP ===\n\n";

    $backupFile = 'u105084344_matrimony_111.sql';

    if (!file_exists($backupFile)) {
        die("❌ Backup file not found: $backupFile\n");
    }

    echo "✅ Backup file found: $backupFile\n";

    // Read the SQL file
    $sqlContent = file_get_contents($backupFile);
    echo "📄 Reading backup file...\n";

    // Extract users INSERT statements
    $pattern = '/INSERT INTO `users` \([^)]+\) VALUES([^;]+);/';
    preg_match_all($pattern, $sqlContent, $matches);

    if (empty($matches[1])) {
        die("❌ No user data found in backup file\n");
    }

    echo "✅ Found " . count($matches[1]) . " user data chunks in backup\n\n";

    $updatedUsers = [];
    $totalUpdates = 0;
    $processedUsers = 0;

    foreach ($matches[1] as $insertChunk) {
        // Parse the VALUES part
        $values = trim($insertChunk);

        // Split by individual row inserts (they're separated by ),( )
        $rows = preg_split('/\),\s*\(/', $values);

        foreach ($rows as $row) {
            // Clean up the row data
            $row = trim($row, '()');

            if (empty($row)) continue;

            // Split by comma, but be careful with quoted strings
            $fields = str_getcsv($row);

            if (count($fields) < 5) continue; // Skip invalid rows

            // Map fields based on the column order from the INSERT statement
            // Column order: id, firstname, lastname, username, referral_id, language_id, email, country_code, phone_code, phone, member_id, chat_last_seen, user_post_status, image, aadhar, pan, kyc_verified, address, gender, date_of_birth, age, ...
            $userData = [
                'id' => trim($fields[0], "'"),
                'firstname' => trim($fields[1], "'"),
                'lastname' => trim($fields[2], "'"),
                'username' => trim($fields[3], "'"),
                'email' => trim($fields[6], "'"),
                'date_of_birth' => isset($fields[19]) ? trim($fields[19], "'") : null,
                'age' => isset($fields[20]) ? trim($fields[20], "'") : null,
            ];

            // Skip if ID is invalid
            if (empty($userData['id']) || !is_numeric($userData['id'])) {
                continue;
            }

            $userId = (int)$userData['id'];
            $processedUsers++;

            // Check if this user exists in current database
            $existingUser = DB::table('users')->where('id', $userId)->first();

            if (!$existingUser) {
                // User doesn't exist in current DB, skip
                continue;
            }

            // Debug: Show DOB data found
            if (!empty($userData['date_of_birth']) && $userData['date_of_birth'] != 'NULL' && $userData['date_of_birth'] != '') {
                echo "📅 Found DOB for User ID {$userId}: '{$userData['date_of_birth']}' (Current: '{$existingUser->date_of_birth}')\n";
            }

            $updates = [];
            $updateData = [];

            // Check and update date_of_birth if missing
            if ((empty($existingUser->date_of_birth) || $existingUser->date_of_birth == '') &&
                !empty($userData['date_of_birth']) &&
                $userData['date_of_birth'] != 'NULL' &&
                $userData['date_of_birth'] != '') {

                // Validate date format - should be in YYYY-MM-DD format
                $datePattern = '/^\d{4}-\d{2}-\d{2}$/';
                if (preg_match($datePattern, $userData['date_of_birth'])) {
                    $updateData['date_of_birth'] = $userData['date_of_birth'];
                    $updates[] = "date_of_birth: '{$existingUser->date_of_birth}' → '{$userData['date_of_birth']}'";
                } else {
                    echo "⚠️  Skipping invalid DOB format for User ID {$userId}: '{$userData['date_of_birth']}'\n";
                }
            }

            // Apply updates if any
            if (!empty($updateData)) {
                DB::table('users')->where('id', $userId)->update($updateData);

                $updatedUsers[] = [
                    'id' => $userId,
                    'name' => trim(($userData['firstname'] ?: '') . ' ' . ($userData['lastname'] ?: '')),
                    'username' => $userData['username'],
                    'updates' => $updates
                ];

                $totalUpdates += count($updates);
                echo "✅ Updated User ID {$userId} ({$userData['firstname']} {$userData['lastname']}): " . implode(', ', $updates) . "\n";
            }
        }
    }

    echo "\n=== UPDATE SUMMARY ===\n\n";
    echo "Total users processed: " . count($updatedUsers) . "\n";
    echo "Total DOB field updates: $totalUpdates\n\n";

    // Verify the updates
    echo "=== VERIFICATION ===\n\n";

    $currentDobStats = [
        'with_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->count(),
        'without_dob' => DB::table('users')->where(function($q) { $q->whereNull('date_of_birth')->orWhere('date_of_birth', ''); })->count(),
    ];

    echo "After update:\n";
    echo "- Users with DOB: {$currentDobStats['with_dob']}\n";
    echo "- Users missing DOB: {$currentDobStats['without_dob']}\n";

    $totalUsers = 441; // Define total users
    $completionRate = $totalUsers > 0 ? round(($currentDobStats['with_dob'] / $totalUsers) * 100, 2) : 0;
    echo "- DOB completion rate: {$completionRate}%\n\n";

    // Show some examples of users who now have DOB
    if ($currentDobStats['with_dob'] > 0) {
        echo "=== EXAMPLES OF UPDATED PROFILES ===\n\n";

        $updatedProfiles = DB::table('users')
            ->whereNotNull('date_of_birth')
            ->where('date_of_birth', '!=', '')
            ->select('id', 'firstname', 'lastname', 'username', 'date_of_birth', 'age')
            ->limit(10)
            ->get();

        foreach ($updatedProfiles as $profile) {
            echo "✅ {$profile->firstname} {$profile->lastname} (ID: {$profile->id})\n";
            echo "   DOB: {$profile->date_of_birth}, Age: {$profile->age}\n\n";
        }
    }

    echo "✅ Date of Birth data update completed successfully!\n";
    echo "Missing DOB information has been restored from the backup where available.\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
