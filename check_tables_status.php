<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get all tables
    $result = $pdo->query('SHOW TABLES');
    $tables = [];
    while ($row = $result->fetch()) {
        $tables[] = $row[0];
    }

    echo 'Database contains ' . count($tables) . ' tables:' . PHP_EOL;

    foreach ($tables as $table) {
        try {
            $countResult = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
            $count = $countResult->fetch()['count'];
            echo "- $table: $count records" . PHP_EOL;
        } catch (Exception $e) {
            echo "- $table: Error checking count - " . $e->getMessage() . PHP_EOL;
        }
    }

} catch (Exception $e) {
    echo 'Database connection error: ' . $e->getMessage() . PHP_EOL;
}
