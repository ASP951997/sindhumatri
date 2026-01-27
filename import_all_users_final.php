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
    $lines = explode("\n", $sql);

    // Find all INSERT INTO users statements (complete ones)
    $insertStatements = [];
    $currentInsert = '';
    $inUsersInsert = false;

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

    echo "Found " . count($insertStatements) . " complete INSERT statements\n";

    // Clear existing users
    echo "\nClearing existing users...\n";
    $pdo->exec("TRUNCATE TABLE users");
    echo "✓ Cleared users table\n";

    $totalImported = 0;

    foreach ($insertStatements as $stmtIndex => $statement) {
        echo "\nProcessing INSERT statement " . ($stmtIndex + 1) . "...\n";

        // Parse the INSERT statement
        preg_match('/INSERT INTO `users` \((.*?)\) VALUES (.*);/is', $statement, $matches);

        if (!isset($matches[1]) || !isset($matches[2])) {
            echo "❌ Could not parse INSERT statement " . ($stmtIndex + 1) . "\n";
            continue;
        }

        $columnsStr = $matches[1];
        $valuesStr = $matches[2];

        // Extract column names
        $sqlColumns = explode(',', $columnsStr);
        $sqlColumns = array_map('trim', $sqlColumns);
        $sqlColumns = array_map(function($col) {
            return str_replace('`', '', $col);
        }, $sqlColumns);

        // Get current table columns
        $result = $pdo->query("DESCRIBE users");
        $currentColumns = $result->fetchAll(PDO::FETCH_ASSOC);
        $currentColumnNames = array_column($currentColumns, 'Field');

        // Find matching columns
        $matchingColumns = array_intersect($sqlColumns, $currentColumnNames);

        if (empty($matchingColumns)) {
            echo "❌ No matching columns found in statement " . ($stmtIndex + 1) . "\n";
            continue;
        }

        // Create mapping of SQL columns to current columns
        $columnMapping = [];
        foreach ($sqlColumns as $index => $sqlCol) {
            if (in_array($sqlCol, $currentColumnNames)) {
                $columnMapping[$index] = $sqlCol;
            }
        }

        // Parse values - this is the key fix
        // The values are in format: (val1, val2, ...), (val1, val2, ...), ...
        $valuesStr = trim($valuesStr);

        // Split by "), (" to get individual record sets
        $valueSets = explode('), (', $valuesStr);

        // Clean up first and last elements
        $valueSets[0] = ltrim($valueSets[0], '(');
        $valueSets[count($valueSets) - 1] = rtrim($valueSets[count($valueSets) - 1], ')');

        echo "Found " . count($valueSets) . " records in this statement\n";

        $statementImported = 0;

        foreach ($valueSets as $valueSet) {
            $values = explode(',', $valueSet);
            $values = array_map('trim', $values);

            // Clean up values (remove quotes, handle NULL, unescape)
            $values = array_map(function($val) {
                $val = trim($val);
                if (strtoupper($val) === 'NULL') {
                    return null;
                }
                if (substr($val, 0, 1) === "'" && substr($val, -1) === "'") {
                    $val = substr($val, 1, -1);
                    // Unescape quotes and other characters
                    $val = str_replace("\\'", "'", $val);
                    $val = str_replace('\\"', '"', $val);
                    $val = str_replace('\\\\', '\\', $val);
                    return $val;
                }
                return $val;
            }, $values);

            // Create data array with only matching columns
            $userData = [];
            foreach ($columnMapping as $sqlIndex => $columnName) {
                if (isset($values[$sqlIndex])) {
                    $userData[$columnName] = $values[$sqlIndex];
                }
            }

            // Set some defaults for required fields
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
                if (!isset($userData[$field]) || $userData[$field] === null || $userData[$field] === '') {
                    if ($field !== 'balance' && $field !== 'interest_balance') {
                        $userData[$field] = $default;
                    } else {
                        $userData[$field] = $userData[$field] ?? $default;
                    }
                }
            }

            // Insert user if we have essential data
            if (!empty($userData) && isset($userData['username']) && isset($userData['firstname'])) {
                try {
                    $columns = array_keys($userData);
                    $placeholders = str_repeat('?,', count($columns) - 1) . '?';

                    $stmt = $pdo->prepare("INSERT INTO users (" . implode(',', $columns) . ") VALUES ($placeholders)");
                    $stmt->execute(array_values($userData));
                    $statementImported++;
                    $totalImported++;
                } catch (Exception $e) {
                    // Only show errors for first few records per statement
                    if ($statementImported < 2) {
                        echo "  ⚠️ Error importing record: " . substr($e->getMessage(), 0, 100) . "...\n";
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
        $result = $pdo->query('SELECT id, firstname, lastname, username, email FROM users LIMIT 10');
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











