<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== UPDATING MISSING DATE OF BIRTH AND AGE FROM BACKUP ===\n\n";

    $backupFile = 'u105084344_matrimony_1.sql';

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
                'date_of_birth' => isset($fields[19]) ? trim($fields[19], "' ") : null, // Trim quotes and spaces
                'age' => isset($fields[20]) ? trim($fields[20], "' ") : null, // Trim quotes and spaces
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

            $updates = [];
            $updateData = [];

            // Check and update date_of_birth if missing
            if ((empty($existingUser->date_of_birth) || $existingUser->date_of_birth == '' || $existingUser->date_of_birth == '0000-00-00') &&
                !empty($userData['date_of_birth']) &&
                $userData['date_of_birth'] != 'NULL' &&
                $userData['date_of_birth'] != '' &&
                $userData['date_of_birth'] != '0000-00-00') {

                // Validate date format - should be in YYYY-MM-DD format
                $datePattern = '/^\d{4}-\d{2}-\d{2}$/';
                if (preg_match($datePattern, $userData['date_of_birth'])) {
                    $updateData['date_of_birth'] = $userData['date_of_birth'];
                    $updates[] = "date_of_birth: '{$existingUser->date_of_birth}' → '{$userData['date_of_birth']}'";
                } else {
                    echo "⚠️  Skipping invalid DOB format for User ID {$userId}: '{$userData['date_of_birth']}'\n";
                }
            }

            // Check and update age if missing or invalid
            if ((empty($existingUser->age) || $existingUser->age == '' || $existingUser->age == '0' || !is_numeric($existingUser->age)) &&
                !empty($userData['age']) &&
                $userData['age'] != 'NULL' &&
                $userData['age'] != '' &&
                is_numeric($userData['age'])) {

                $age = (int)$userData['age'];
                // Validate age range (reasonable range for matrimony users)
                if ($age >= 18 && $age <= 100) {
                    $updateData['age'] = $age;
                    $updates[] = "age: '{$existingUser->age}' → '{$age}'";
                } else {
                    echo "⚠️  Skipping invalid age for User ID {$userId}: '{$userData['age']}'\n";
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
    echo "Total users processed from backup: $processedUsers\n";
    echo "Total users updated: " . count($updatedUsers) . "\n";
    echo "Total field updates: $totalUpdates\n\n";

    // Verify the updates
    echo "=== VERIFICATION ===\n\n";

    $currentDobStats = [
        'with_dob' => DB::table('users')->whereNotNull('date_of_birth')->where('date_of_birth', '!=', '')->where('date_of_birth', '!=', '0000-00-00')->count(),
        'without_dob' => DB::table('users')->where(function($q) {
            $q->whereNull('date_of_birth')->orWhere('date_of_birth', '')->orWhere('date_of_birth', '0000-00-00');
        })->count(),
    ];

    $currentAgeStats = [
        'with_age' => DB::table('users')->whereNotNull('age')->where('age', '!=', '')->whereRaw('CAST(age AS UNSIGNED) >= 18 AND CAST(age AS UNSIGNED) <= 100')->count(),
        'without_age' => DB::table('users')->where(function($q) {
            $q->whereNull('age')->orWhere('age', '')->orWhereRaw('CAST(age AS UNSIGNED) < 18 OR CAST(age AS UNSIGNED) > 100');
        })->count(),
    ];

    echo "After update:\n";
    echo "- Users with valid DOB: {$currentDobStats['with_dob']}\n";
    echo "- Users missing DOB: {$currentDobStats['without_dob']}\n";
    echo "- Users with valid age: {$currentAgeStats['with_age']}\n";
    echo "- Users missing age: {$currentAgeStats['without_age']}\n";

    $totalUsers = DB::table('users')->count();
    $dobCompletionRate = $totalUsers > 0 ? round(($currentDobStats['with_dob'] / $totalUsers) * 100, 2) : 0;
    $ageCompletionRate = $totalUsers > 0 ? round(($currentAgeStats['with_age'] / $totalUsers) * 100, 2) : 0;

    echo "- DOB completion rate: {$dobCompletionRate}%\n";
    echo "- Age completion rate: {$ageCompletionRate}%\n\n";

    // Show some examples of users who now have DOB and age
    if ($currentDobStats['with_dob'] > 0 || $currentAgeStats['with_age'] > 0) {
        echo "=== EXAMPLES OF UPDATED PROFILES ===\n\n";

        $updatedProfiles = DB::table('users')
            ->where(function($q) {
                $q->where(function($sq) {
                    $sq->whereNotNull('date_of_birth')
                       ->where('date_of_birth', '!=', '')
                       ->where('date_of_birth', '!=', '0000-00-00');
                })
                ->orWhere(function($sq) {
                    $sq->whereNotNull('age')
                       ->where('age', '!=', '')
                       ->whereRaw('CAST(age AS UNSIGNED) >= 18 AND CAST(age AS UNSIGNED) <= 100');
                });
            })
            ->select('id', 'firstname', 'lastname', 'username', 'date_of_birth', 'age')
            ->limit(15)
            ->get();

        foreach ($updatedProfiles as $profile) {
            echo "✅ {$profile->firstname} {$profile->lastname} (ID: {$profile->id})\n";
            echo "   DOB: " . ($profile->date_of_birth ?: 'Not set') . ", Age: " . ($profile->age ?: 'Not set') . "\n\n";
        }
    }

    echo "✅ Date of Birth and Age data update completed successfully!\n";
    echo "Missing DOB and age information has been restored from the backup where available.\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
