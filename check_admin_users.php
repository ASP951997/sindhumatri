<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== CHECKING ADMIN USERS ===\n\n";

    // Check for 'admin' user
    $result = $pdo->query("SELECT id, firstname, lastname, username, email FROM users WHERE username = 'admin'");
    $adminUser = $result->fetch();

    if ($adminUser) {
        echo "✓ Admin user found:\n";
        echo "  ID: {$adminUser['id']}\n";
        echo "  Name: {$adminUser['firstname']} {$adminUser['lastname']}\n";
        echo "  Username: {$adminUser['username']}\n";
        echo "  Email: {$adminUser['email']}\n\n";
    } else {
        echo "✗ Admin user 'admin' not found\n\n";
    }

    // Check for 'SPMO' user
    $result = $pdo->query("SELECT id, firstname, lastname, username, email FROM users WHERE username = 'SPMO'");
    $spmoUser = $result->fetch();

    if ($spmoUser) {
        echo "✓ SPMO admin user found:\n";
        echo "  ID: {$spmoUser['id']}\n";
        echo "  Name: {$spmoUser['firstname']} {$spmoUser['lastname']}\n";
        echo "  Username: {$spmoUser['username']}\n";
        echo "  Email: {$spmoUser['email']}\n\n";
    } else {
        echo "✗ SPMO admin user 'SPMO' not found\n\n";
    }

    echo "ADMIN LOGIN CREDENTIALS:\n";
    echo "------------------------\n";
    if ($adminUser) {
        echo "Regular Admin:\n";
        echo "  Username: admin\n";
        echo "  Password: admin123\n\n";
    }

    if ($spmoUser) {
        echo "SPMO Admin:\n";
        echo "  Username: SPMO\n";
        echo "  Password: admin123\n\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>












