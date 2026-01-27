<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== CHECKING ADMINS TABLE ===\n\n";

    // Check admins table
    $result = $pdo->query("SELECT id, username, email FROM admins");
    $admins = $result->fetchAll();

    if (count($admins) > 0) {
        echo "Found " . count($admins) . " admin(s) in admins table:\n";
        foreach ($admins as $admin) {
            echo "  ID: {$admin['id']}\n";
            echo "  Username: {$admin['username']}\n";
            echo "  Email: {$admin['email']}\n\n";
        }
    } else {
        echo "No admins found in admins table\n\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>