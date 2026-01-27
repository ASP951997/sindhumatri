<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== RAW DATABASE CHECK ===\n\n";

    $result = $pdo->query("SELECT id, username, email, status FROM admins");
    $admins = $result->fetchAll(PDO::FETCH_ASSOC);

    echo "Database admins:\n";
    foreach ($admins as $admin) {
        echo "  ID: {$admin['id']}, Username: {$admin['username']}, Email: {$admin['email']}, Status: {$admin['status']}\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>











