<?php

// Database configuration
$host = '127.0.0.1';
$port = '3306';
$username = 'root';
$password = '';

// Database name to create
$databaseName = 'u105084344_matrimony_123';

// SQL file path
$sqlFile = __DIR__ . '/Data Docs/u105084344_matrimony_123.sql';

try {
    echo "Connecting to MySQL server...\n";

    // Connect to MySQL server (without specifying a database)
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected successfully!\n";

    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$databaseName'");
    $exists = $stmt->fetch();

    if ($exists) {
        echo "Database '$databaseName' already exists.\n";
    } else {
        echo "Creating database '$databaseName'...\n";

        // Create the database
        $pdo->exec("CREATE DATABASE `$databaseName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        echo "Database '$databaseName' created successfully!\n";
    }

    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$databaseName", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if SQL file exists
    if (!file_exists($sqlFile)) {
        throw new Exception("SQL file not found: $sqlFile");
    }

    echo "Importing SQL file...\n";

    // Read and execute SQL file
    $sql = file_get_contents($sqlFile);

    // Split SQL file into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    $successCount = 0;
    $errorCount = 0;

    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $pdo->exec($statement);
                $successCount++;
            } catch (Exception $e) {
                echo "Error executing statement: " . $e->getMessage() . "\n";
                $errorCount++;
            }
        }
    }

    echo "\nImport completed!\n";
    echo "Successful statements: $successCount\n";
    echo "Failed statements: $errorCount\n";

    if ($errorCount == 0) {
        echo "Database import successful!\n";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage() . "\n";

    if (strpos($e->getMessage(), 'Connection refused') !== false) {
        echo "\nMySQL server is not running. Please start MySQL service first.\n";
        echo "Try running: net start mysql\n";
        echo "Or check if you have XAMPP/WAMP running.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>


