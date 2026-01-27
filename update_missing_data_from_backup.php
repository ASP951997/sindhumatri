<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== UPDATING MISSING DATA FROM BACKUP ===\n\n";

    $backupFile = 'u105084344_matrimony_111.sql';

    if (!file_exists($backupFile)) {
        die("❌ Backup file not found: $backupFile\n");
    }

    echo "✅ Backup file found: $backupFile\n";

    // Read and parse the SQL file
    $sqlContent = file_get_contents($backupFile);
    echo "📄 Reading backup file...\n";

    // Extract users INSERT statements (new format with column names)
    $pattern = '/INSERT INTO `users` \([^)]+\) VALUES([^;]+);/';
    preg_match_all($pattern, $sqlContent, $matches);

    if (empty($matches[1])) {
        die("❌ No user data found in backup file\n");
    }

    echo "✅ Found " . count($matches[1]) . " user data chunks in backup\n\n";

    $updatedUsers = [];
    $totalUpdates = 0;

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
                'image' => isset($fields[13]) ? trim($fields[13], "'") : null,
                'gender' => isset($fields[18]) ? trim($fields[18], "'") : null,
                'date_of_birth' => isset($fields[19]) ? trim($fields[19], "'") : null,
                'age' => isset($fields[20]) ? trim($fields[20], "'") : null,
            ];

            // Skip if ID is invalid
            if (empty($userData['id']) || !is_numeric($userData['id'])) {
                continue;
            }

            $userId = (int)$userData['id'];

            // Check if this user exists in current database
            $existingUser = DB::table('users')->where('id', $userId)->first();

            if (!$existingUser) {
                // User doesn't exist in current DB, skip
                continue;
            }

            $updates = [];
            $updateData = [];

            // Check and update age if missing
            if ((empty($existingUser->age) || $existingUser->age == 0) && !empty($userData['age']) && $userData['age'] != '0') {
                $updateData['age'] = $userData['age'];
                $updates[] = "age: {$existingUser->age} → {$userData['age']}";
            }

            // Check and update image if missing
            if ((empty($existingUser->image) || $existingUser->image == '') && !empty($userData['image'])) {
                $updateData['image'] = $userData['image'];
                $updates[] = "image: '{$existingUser->image}' → '{$userData['image']}'";
            }

            // Check and update date_of_birth if missing
            if ((empty($existingUser->date_of_birth) || $existingUser->date_of_birth == '') && !empty($userData['date_of_birth'])) {
                $updateData['date_of_birth'] = $userData['date_of_birth'];
                $updates[] = "date_of_birth: '{$existingUser->date_of_birth}' → '{$userData['date_of_birth']}'";
            }

            // Check and update gender if missing
            if ((empty($existingUser->gender) || $existingUser->gender == '') && !empty($userData['gender'])) {
                $updateData['gender'] = $userData['gender'];
                $updates[] = "gender: '{$existingUser->gender}' → '{$userData['gender']}'";
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
    echo "Total field updates: $totalUpdates\n\n";

    // Verify the updates
    echo "=== VERIFICATION ===\n\n";

    $currentStats = [
        'without_age' => DB::table('users')->where(function($q) { $q->whereNull('age')->orWhere('age', 0); })->count(),
        'without_images' => DB::table('users')->where(function($q) { $q->whereNull('image')->orWhere('image', ''); })->count(),
        'without_both' => DB::table('users')->where(function($q) { $q->whereNull('age')->orWhere('age', 0); })->where(function($q) { $q->whereNull('image')->orWhere('image', ''); })->count(),
    ];

    echo "After update:\n";
    echo "- Users without age: {$currentStats['without_age']}\n";
    echo "- Users without images: {$currentStats['without_images']}\n";
    echo "- Users missing both: {$currentStats['without_both']}\n\n";

    echo "✅ Data update completed successfully!\n";
    echo "The missing age, image, and other profile information has been restored from the backup.\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
