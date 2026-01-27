<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== IMPORTING ALL 508 USER RECORDS WITH EMAILS ===\n\n";

    // Read and parse SQL file
    $sqlFile = 'u105084344_matrimony_1.sql';
    if (!file_exists($sqlFile)) {
        echo "❌ SQL file not found!\n";
        exit(1);
    }

    $sql = file_get_contents($sqlFile);

    // Extract all user INSERT statements
    $pattern = '/INSERT INTO `users` \((.*?)\) VALUES(.*?);/is';
    preg_match_all($pattern, $sql, $matches);

    if (empty($matches[0])) {
        echo "❌ No INSERT INTO users statements found!\n";
        exit(1);
    }

    echo "Found " . count($matches[0]) . " INSERT statements\n";

    // Clear existing users
    echo "\nClearing existing users...\n";
    $pdo->exec("TRUNCATE TABLE users");
    echo "✓ Cleared users table\n";

    $totalImported = 0;

    foreach ($matches[0] as $stmtIndex => $statement) {
        echo "\nProcessing statement " . ($stmtIndex + 1) . "...\n";

        // Parse the statement
        preg_match('/INSERT INTO `users` \((.*?)\) VALUES(.*?);/is', $statement, $match);

        if (!$match) {
            echo "❌ Could not parse statement " . ($stmtIndex + 1) . "\n";
            continue;
        }

        $columnsStr = $match[1];
        $valuesStr = $match[2];

        // Extract column names
        $columns = explode(',', $columnsStr);
        $columns = array_map(function($col) {
            return trim(str_replace('`', '', $col));
        }, $columns);

        // Find indices of columns we want to import
        $columnIndices = [
            'id' => array_search('id', $columns),
            'firstname' => array_search('firstname', $columns),
            'lastname' => array_search('lastname', $columns),
            'username' => array_search('username', $columns),
            'email' => array_search('email', $columns),
            'phone' => array_search('phone', $columns),
            'status' => array_search('status', $columns),
            'password' => array_search('password', $columns),
            'created_at' => array_search('created_at', $columns),
            'updated_at' => array_search('updated_at', $columns),
            'balance' => array_search('balance', $columns),
            'interest_balance' => array_search('interest_balance', $columns),
            'image' => array_search('image', $columns),
            'language_id' => array_search('language_id', $columns),
            'email_verification' => array_search('email_verification', $columns),
            'sms_verification' => array_search('sms_verification', $columns),
            'two_fa' => array_search('two_fa', $columns),
            'two_fa_verify' => array_search('two_fa_verify', $columns),
        ];

        // Parse values - split by "), ("
        $valueSets = explode('), (', $valuesStr);

        // Clean first and last elements
        $valueSets[0] = ltrim($valueSets[0], '(');
        $valueSets[count($valueSets) - 1] = rtrim($valueSets[count($valueSets) - 1], ')');

        echo "Found " . count($valueSets) . " records in this statement\n";

        $statementImported = 0;

        foreach ($valueSets as $valueSet) {
            $values = explode(',', $valueSet);
            $values = array_map('trim', $values);

            // Clean up values (remove quotes, handle NULL)
            $values = array_map(function($val) {
                $val = trim($val);
                if (strtoupper($val) === 'NULL') {
                    return null;
                }
                if (substr($val, 0, 1) === "'" && substr($val, -1) === "'") {
                    $val = substr($val, 1, -1);
                    // Unescape quotes
                    $val = str_replace("\\'", "'", $val);
                    $val = str_replace('\\"', '"', $val);
                    return $val;
                }
                return $val;
            }, $values);

            // Build user data array
            $userData = [];

            foreach ($columnIndices as $field => $index) {
                if ($index !== false && isset($values[$index])) {
                    $userData[$field] = $values[$index];
                }
            }

            // Set defaults for missing fields
            $defaults = [
                'language_id' => 1,
                'balance' => '0.00',
                'interest_balance' => '0.00',
                'email_verification' => 1,
                'sms_verification' => 1,
                'two_fa' => 0,
                'two_fa_verify' => 0,
            ];

            foreach ($defaults as $field => $default) {
                if (!isset($userData[$field]) || $userData[$field] === null) {
                    $userData[$field] = $default;
                }
            }

            // Insert user
            if (!empty($userData)) {
                try {
                    $columns = array_keys($userData);
                    $placeholders = str_repeat('?,', count($columns) - 1) . '?';

                    $stmt = $pdo->prepare("INSERT INTO users (" . implode(',', $columns) . ") VALUES ($placeholders)");
                    $stmt->execute(array_values($userData));
                    $statementImported++;
                    $totalImported++;
                } catch (Exception $e) {
                    // Only show first error per statement
                    if ($statementImported < 1) {
                        echo "  ⚠️ Error: " . substr($e->getMessage(), 0, 100) . "...\n";
                    }
                }
            }
        }

        echo "✓ Imported $statementImported records from statement " . ($stmtIndex + 1) . "\n";
    }

    // Final verification
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    $finalCount = $row['count'];

    echo "\n🎉 IMPORT COMPLETE!\n";
    echo "Total records imported: $totalImported\n";
    echo "Final count in database: $finalCount\n";

    // Check emails
    $result = $pdo->query("SELECT COUNT(*) as count FROM users WHERE email IS NOT NULL AND email != ''");
    $row = $result->fetch();
    $usersWithEmails = $row['count'];

    echo "Users with emails: $usersWithEmails\n\n";

    if ($finalCount > 0) {
        echo "Sample users with emails:\n";
        $result = $pdo->query('SELECT id, firstname, lastname, username, email FROM users LIMIT 5');
        while ($user = $result->fetch()) {
            $email = $user['email'] ?: 'N/A';
            echo "- ID {$user['id']}: {$user['firstname']} {$user['lastname']} ({$user['username']}) - Email: $email\n";
        }
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
?>











