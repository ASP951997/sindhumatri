<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== IMPORTING ALL 508 USER RECORDS ===\n\n";

    // Check current table structure
    $result = $pdo->query("DESCRIBE users");
    $currentColumns = $result->fetchAll(PDO::FETCH_ASSOC);
    $currentColumnNames = array_column($currentColumns, 'Field');

    echo "Current users table has " . count($currentColumnNames) . " columns\n";

    // Read and parse SQL file
    $sqlFile = 'u105084344_matrimony_1.sql';
    if (!file_exists($sqlFile)) {
        echo "❌ SQL file not found!\n";
        exit(1);
    }

    $sql = file_get_contents($sqlFile);
    $lines = explode("\n", $sql);

    // Find all INSERT INTO users statements
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

    echo "Found " . count($insertStatements) . " INSERT statements for users\n";

    // Clear existing users first
    echo "\nClearing existing users...\n";
    $pdo->exec("TRUNCATE TABLE users");
    echo "✓ Cleared users table\n";

    // Process each INSERT statement
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

        // Parse values
        $valuesStr = trim($valuesStr);
        $valueSets = explode('), (', $valuesStr);

        // Clean up first and last elements
        $valueSets[0] = ltrim($valueSets[0], '(');
        $valueSets[count($valueSets) - 1] = rtrim($valueSets[count($valueSets) - 1], ')');

        echo "Found " . count($valueSets) . " records in this statement\n";

        // Import records from this statement
        $statementImported = 0;

        foreach ($valueSets as $valueSet) {
            $values = explode(',', $valueSet);
            $values = array_map('trim', $values);

            // Remove quotes from values and handle NULL values
            $values = array_map(function($val) {
                $val = trim($val);
                if (strtoupper($val) === 'NULL') {
                    return null;
                }
                if (substr($val, 0, 1) === "'" && substr($val, -1) === "'") {
                    return substr($val, 1, -1);
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

            // Insert user if we have data
            if (!empty($userData)) {
                try {
                    $columns = array_keys($userData);
                    $placeholders = str_repeat('?,', count($columns) - 1) . '?';

                    $stmt = $pdo->prepare("INSERT INTO users (" . implode(',', $columns) . ") VALUES ($placeholders)");
                    $stmt->execute(array_values($userData));
                    $statementImported++;
                    $totalImported++;
                } catch (Exception $e) {
                    // Skip individual record errors but log them
                    if ($statementImported < 3) { // Only show first few errors
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

    if ($finalCount > 0) {
        echo "\nSample users:\n";
        $result = $pdo->query('SELECT id, firstname, lastname, username, email, phone, status FROM users LIMIT 5');
        while ($user = $result->fetch()) {
            $email = $user['email'] ?: 'N/A';
            echo "- ID {$user['id']}: {$user['firstname']} {$user['lastname']} ({$user['username']}) - Email: $email - Status: {$user['status']}\n";
        }
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . "\n";
}
?>











