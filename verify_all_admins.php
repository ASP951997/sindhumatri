<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== VERIFYING ALL ADMIN USERS ===\n\n";

    $result = $pdo->query('SELECT id, name, username, email, status FROM admins ORDER BY id');

    echo "All Admin Users:\n";
    echo "================\n";

    $count = 0;
    while ($admin = $result->fetch()) {
        $count++;
        echo "ID: {$admin['id']}\n";
        echo "  Name: {$admin['name']}\n";
        echo "  Username: {$admin['username']}\n";
        echo "  Email: {$admin['email']}\n";
        echo "  Status: {$admin['status']}\n\n";
    }

    echo "Total admin users: $count\n";

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}

?>











