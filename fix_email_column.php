<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== FIXING EMAIL COLUMN TYPE ===\n\n";

    // Check current email column structure
    echo "Current email column:\n";
    $result = $pdo->query("DESCRIBE users");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        if ($column['Field'] === 'email') {
            echo "  Type: {$column['Type']}\n";
            echo "  Null: {$column['Null']}\n";
            break;
        }
    }

    // Alter the email column to VARCHAR
    echo "\nChanging email column to VARCHAR(191)...\n";
    $pdo->exec("ALTER TABLE users MODIFY COLUMN email VARCHAR(191) NULL DEFAULT NULL");
    echo "✓ Email column changed to VARCHAR(191)\n";

    // Verify the change
    echo "\nVerifying email column change:\n";
    $result = $pdo->query("DESCRIBE users");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        if ($column['Field'] === 'email') {
            echo "  Type: {$column['Type']}\n";
            echo "  Null: {$column['Null']}\n";
            echo "  Default: " . ($column['Default'] ?: 'NULL') . "\n";
            break;
        }
    }

    echo "\n✅ Email column fix complete!\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}
?>











