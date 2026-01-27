<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Starting database restoration...\n";

    // Clear existing data from main tables
    $tablesToClear = ['users', 'templates', 'template_media', 'languages'];

    foreach ($tablesToClear as $table) {
        try {
            $pdo->exec("TRUNCATE TABLE `$table`");
            echo "✓ Cleared table: $table\n";
        } catch (Exception $e) {
            echo "Note: Could not clear $table: " . $e->getMessage() . "\n";
        }
    }

    echo "\nImporting data from u105084344_matrimony_123.sql...\n";

    // Read and execute the SQL file
    $sql = file_get_contents('u105084344_matrimony_123.sql');

    // Split SQL file into individual statements
    $statements = [];
    $lines = explode("\n", $sql);
    $currentStatement = '';
    $inMultilineComment = false;

    foreach ($lines as $line) {
        $line = trim($line);

        // Skip comments and empty lines
        if (empty($line) || strpos($line, '--') === 0 || strpos($line, '/*') === 0) {
            continue;
        }

        // Skip LOCK TABLES and UNLOCK TABLES
        if (strpos($line, 'LOCK TABLES') === 0 || strpos($line, 'UNLOCK TABLES') === 0) {
            continue;
        }

        $currentStatement .= $line . ' ';

        // Check if statement is complete (ends with semicolon)
        if (substr(trim($line), -1) === ';') {
            $statement = trim($currentStatement);

            // Skip certain statements that might cause issues
            if (strpos($statement, 'DROP TABLE') === 0 ||
                strpos($statement, 'CREATE DATABASE') === 0 ||
                strpos($statement, 'USE ') === 0 ||
                strpos($statement, 'SET ') === 0) {
                $currentStatement = '';
                continue;
            }

            $statements[] = $statement;
            $currentStatement = '';
        }
    }

    echo "Found " . count($statements) . " SQL statements to execute\n";

    $successCount = 0;
    $errorCount = 0;

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (empty($statement)) continue;

        try {
            $pdo->exec($statement);
            $successCount++;
        } catch (Exception $e) {
            // Only show errors for non-duplicate key errors
            if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                echo "Error on statement: " . substr($statement, 0, 100) . "...\n";
                echo "Error: " . $e->getMessage() . "\n";
                $errorCount++;
            }
        }
    }

    echo "\nImport completed!\n";
    echo "Successful statements: $successCount\n";
    echo "Errors: $errorCount\n";

    // Check final user count
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    echo "Total users in database: " . $row['count'] . "\n";

    if ($row['count'] > 0) {
        echo "\nFirst 5 users:\n";
        $result = $pdo->query('SELECT id, firstname, lastname, username FROM users LIMIT 5');
        while ($user = $result->fetch()) {
            echo "ID: {$user['id']}, Name: {$user['firstname']} {$user['lastname']}, Username: {$user['username']}\n";
        }
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
