<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== ADMIN LOGIN DEBUG ===\n\n";

    // Check admins table structure
    echo "Admins table structure:\n";
    $result = $pdo->query("DESCRIBE admins");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $column) {
        echo "  {$column['Field']} - {$column['Type']}\n";
    }
    echo "\n";

    // Check admin users
    echo "Admin users in database:\n";
    $result = $pdo->query("SELECT id, username, email, status, created_at FROM admins");
    $admins = $result->fetchAll(PDO::FETCH_ASSOC);

    if (count($admins) > 0) {
        foreach ($admins as $admin) {
            echo "  ID: {$admin['id']}\n";
            echo "  Username: {$admin['username']}\n";
            echo "  Email: {$admin['email']}\n";
            echo "  Status: {$admin['status']}\n";
            echo "  Created: {$admin['created_at']}\n\n";
        }
    } else {
        echo "No admin users found!\n\n";
    }

    // Test password verification for SPMO
    echo "Testing password verification:\n";
    $result = $pdo->query("SELECT password FROM admins WHERE username = 'SPMO'");
    $admin = $result->fetch();

    if ($admin) {
        $isValidAdmin123 = password_verify('admin@123', $admin['password']);
        $isValidAdmin123Plain = password_verify('admin123', $admin['password']);

        echo "  SPMO password 'admin@123': " . ($isValidAdmin123 ? '✓ VALID' : '✗ INVALID') . "\n";
        echo "  SPMO password 'admin123': " . ($isValidAdmin123Plain ? '✓ VALID' : '✗ INVALID') . "\n";
    } else {
        echo "  SPMO user not found\n";
    }

    // Test password verification for SP
    $result = $pdo->query("SELECT password FROM admins WHERE username = 'SP'");
    $admin = $result->fetch();

    if ($admin) {
        $isValidAdmin123 = password_verify('admin@123', $admin['password']);
        $isValidAdmin123Plain = password_verify('admin123', $admin['password']);

        echo "  SP password 'admin@123': " . ($isValidAdmin123 ? '✓ VALID' : '✗ INVALID') . "\n";
        echo "  SP password 'admin123': " . ($isValidAdmin123Plain ? '✓ VALID' : '✗ INVALID') . "\n";
    } else {
        echo "  SP user not found\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>