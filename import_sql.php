<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

        $currentStatement .= $line;

        // Check if statement is complete (ends with semicolon)
        if (substr($line, -1) === ';') {
            $statements[] = $currentStatement;
            $currentStatement = '';
        }
    }

    echo "Found " . count($statements) . " SQL statements to execute\n";

    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (empty($statement)) continue;

        try {
            $pdo->exec($statement);
            echo "✓ Executed successfully\n";
        } catch (Exception $e) {
            echo "✗ Error: " . $e->getMessage() . "\n";
            // Continue with other statements
        }
    }

    echo "Import completed!\n";

} catch (Exception $e) {
    echo "Connection error: " . $e->getMessage() . "\n";
}
