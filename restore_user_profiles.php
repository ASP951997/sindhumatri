<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== RESTORING USER PROFILE DATA ===\n\n";

try {
    // Get total users count before restoration
    $totalUsersBefore = User::count();
    echo "Users before restoration: {$totalUsersBefore}\n\n";

    // Read the SQL backup file
    $sqlFile = 'u105084344_matrimony_1.sql';
    if (!file_exists($sqlFile)) {
        echo "❌ SQL backup file not found: {$sqlFile}\n";
        exit(1);
    }

    echo "Reading SQL backup file...\n";
    $sql = file_get_contents($sqlFile);
    $lines = explode("\n", $sql);

    // Find all INSERT INTO users statements
    $insertStatements = [];
    $currentInsert = '';
    $inUsersInsert = false;

    echo "Parsing INSERT statements...\n";
    foreach ($lines as $line) {
        $line = trim($line);

        if (strpos($line, 'INSERT INTO `users`') === 0) {
            if ($inUsersInsert && !empty($currentInsert)) {
                $insertStatements[] = $currentInsert;
            }
            $inUsersInsert = true;
            $currentInsert = $line;
        } elseif ($inUsersInsert) {
            $currentInsert .= ' ' . $line;
            if (substr($line, -1) === ';') {
                $insertStatements[] = $currentInsert;
                $inUsersInsert = false;
                $currentInsert = '';
            }
        }
    }

    if ($inUsersInsert && !empty($currentInsert)) {
        $insertStatements[] = $currentInsert;
    }

    echo "Found " . count($insertStatements) . " INSERT statements\n\n";

    // Process each INSERT statement to extract and update user data
    $updatedUsers = 0;
    $skippedUsers = 0;

    foreach ($insertStatements as $index => $insertStmt) {
        echo "Processing statement " . ($index + 1) . "/" . count($insertStatements) . "...\n";

        // Extract VALUES part
        $valuesStart = strpos($insertStmt, 'VALUES');
        if ($valuesStart === false) continue;

        $valuesPart = substr($insertStmt, $valuesStart + 6);
        $valuesPart = trim($valuesPart, '(); ');

        // Split multiple value sets (if any)
        $valueSets = explode('), (', $valuesPart);

        foreach ($valueSets as $valueSet) {
            $valueSet = trim($valueSet, '()');

            // Parse the VALUES
            $values = str_getcsv($valueSet);

            if (count($values) < 5) continue; // Not enough data

            $userId = trim($values[0], "'\"");
            $firstname = trim($values[1], "'\"");
            $lastname = trim($values[2], "'\"");
            $username = trim($values[3], "'\"");

            // Check if user exists
            $existingUser = User::find($userId);

            if (!$existingUser) {
                echo "  Skipping user ID {$userId} - not found in current database\n";
                $skippedUsers++;
                continue;
            }

            // Extract profile data from VALUES array
            // Map array indices to database columns based on the INSERT statement
            $profileData = [];

            // Basic info
            $profileData['firstname'] = !empty($firstname) ? $firstname : $existingUser->firstname;
            $profileData['lastname'] = !empty($lastname) ? $lastname : $existingUser->lastname;
            $profileData['username'] = !empty($username) ? $username : $existingUser->username;

            // Demographic data (indices based on INSERT statement)
            if (isset($values[18]) && !empty(trim($values[18], "'\""))) {
                $profileData['gender'] = trim($values[18], "'\"");
            }
            if (isset($values[19]) && !empty(trim($values[19], "'\""))) {
                $profileData['date_of_birth'] = trim($values[19], "'\"");
            }
            if (isset($values[20]) && !empty(trim($values[20], "'\""))) {
                $profileData['age'] = (int)trim($values[20], "'\"");
            }
            if (isset($values[21]) && !empty(trim($values[21], "'\""))) {
                $profileData['on_behalf'] = (int)trim($values[21], "'\"");
            }
            if (isset($values[22]) && !empty(trim($values[22], "'\""))) {
                $profileData['marital_status'] = (int)trim($values[22], "'\"");
            }
            if (isset($values[25]) && !empty(trim($values[25], "'\""))) {
                $profileData['height'] = trim($values[25], "'\"");
            }
            if (isset($values[26]) && !empty(trim($values[26], "'\""))) {
                $profileData['weight'] = trim($values[26], "'\"");
            }

            // Religious & Social background
            if (isset($values[116]) && !empty(trim($values[116], "'\""))) {
                $profileData['religion'] = (int)trim($values[116], "'\"");
            }
            if (isset($values[117]) && !empty(trim($values[117], "'\""))) {
                $profileData['caste'] = (int)trim($values[117], "'\"");
            }
            if (isset($values[118]) && !empty(trim($values[118], "'\""))) {
                $profileData['sub_caste'] = (int)trim($values[118], "'\"");
            }

            // Physical attributes
            if (isset($values[31]) && !empty(trim($values[31], "'\""))) {
                $profileData['body_type'] = (int)trim($values[31], "'\"");
            }
            if (isset($values[33]) && !empty(trim($values[33], "'\""))) {
                $profileData['complexion'] = (int)trim($values[33], "'\"");
            }
            if (isset($values[28]) && !empty(trim($values[28], "'\""))) {
                $profileData['hair_color'] = (int)trim($values[28], "'\"");
            }

            // Education & Career
            if (isset($values[119]) && !empty(trim($values[119], "'\""))) {
                $profileData['education_level'] = (int)trim($values[119], "'\"");
            }
            if (isset($values[34]) && !empty(trim($values[34], "'\""))) {
                $profileData['occupation'] = (int)trim($values[34], "'\"");
            }

            // Location data
            if (isset($values[36]) && !empty(trim($values[36], "'\""))) {
                $profileData['present_country'] = (int)trim($values[36], "'\"");
            }
            if (isset($values[37]) && !empty(trim($values[37], "'\""))) {
                $profileData['present_state'] = (int)trim($values[37], "'\"");
            }
            if (isset($values[38]) && !empty(trim($values[38], "'\""))) {
                $profileData['present_city'] = (int)trim($values[38], "'\"");
            }
            if (isset($values[41]) && !empty(trim($values[41], "'\""))) {
                $profileData['permanent_country'] = (int)trim($values[41], "'\"");
            }
            if (isset($values[42]) && !empty(trim($values[42], "'\""))) {
                $profileData['permanent_state'] = (int)trim($values[42], "'\"");
            }
            if (isset($values[43]) && !empty(trim($values[43], "'\""))) {
                $profileData['permanent_city'] = (int)trim($values[43], "'\"");
            }

            // Partner expectations
            if (isset($values[66]) && !empty(trim($values[66], "'\""))) {
                $profileData['partner_gender'] = trim($values[66], "'\"");
            }
            if (isset($values[68]) && !empty(trim($values[68], "'\""))) {
                $profileData['partner_min_height'] = trim($values[68], "'\"");
            }
            if (isset($values[69]) && !empty(trim($values[69], "'\""))) {
                $profileData['partner_max_weight'] = trim($values[69], "'\"");
            }
            if (isset($values[70]) && !empty(trim($values[70], "'\""))) {
                $profileData['partner_religion'] = json_encode([trim($values[70], "'\"")]);
            }
            if (isset($values[71]) && !empty(trim($values[71], "'\""))) {
                $profileData['partner_caste'] = json_encode([trim($values[71], "'\"")]);
            }
            if (isset($values[74]) && !empty(trim($values[74], "'\""))) {
                $profileData['partner_education'] = json_encode([trim($values[74], "'\"")]);
            }

            // Update the user if we have data to update
            if (!empty($profileData)) {
                $existingUser->update($profileData);
                $updatedUsers++;
                echo "  ✅ Updated user ID {$userId} ({$firstname} {$lastname})\n";
            } else {
                echo "  ⏭️  No data to update for user ID {$userId}\n";
            }
        }
    }

    // Final statistics
    $totalUsersAfter = User::count();
    echo "\n=== RESTORATION COMPLETE ===\n";
    echo "Users updated: {$updatedUsers}\n";
    echo "Users skipped: {$skippedUsers}\n";
    echo "Total users before: {$totalUsersBefore}\n";
    echo "Total users after: {$totalUsersAfter}\n\n";

    // Check data population after restoration
    echo "=== DATA POPULATION AFTER RESTORATION ===\n";
    $dataCounts = [
        'gender' => User::whereNotNull('gender')->where('gender', '!=', '')->count(),
        'age' => User::whereNotNull('age')->where('age', '>', 0)->count(),
        'height' => User::whereNotNull('height')->where('height', '!=', '')->count(),
        'religion' => User::whereNotNull('religion')->where('religion', '!=', '')->count(),
        'caste' => User::whereNotNull('caste')->where('caste', '!=', '')->count(),
        'marital_status' => User::whereNotNull('marital_status')->where('marital_status', '!=', '')->count(),
        'education_level' => User::whereNotNull('education_level')->where('education_level', '!=', '')->count(),
        'occupation' => User::whereNotNull('occupation')->where('occupation', '!=', '')->count(),
    ];

    foreach ($dataCounts as $field => $count) {
        $percentage = $totalUsersAfter > 0 ? round(($count / $totalUsersAfter) * 100, 1) : 0;
        echo "- {$field}: {$count} users ({$percentage}%)\n";
    }

    echo "\n✅ User profile data restoration completed!\n";

} catch (Exception $e) {
    echo "❌ Error during restoration: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}









