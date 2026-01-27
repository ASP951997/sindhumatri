<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $result = $pdo->query('DESCRIBE users');
    echo 'Users table structure:' . PHP_EOL;
    echo str_pad('Field', 30) . str_pad('Type', 20) . 'Null' . PHP_EOL;
    echo str_repeat('-', 60) . PHP_EOL;

    while ($row = $result->fetch()) {
        echo str_pad($row['Field'], 30) . str_pad($row['Type'], 20) . $row['Null'] . PHP_EOL;
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
