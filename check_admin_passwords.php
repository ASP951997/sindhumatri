<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== CHECKING ADMIN PASSWORDS ===\n\n";

    // Check all admin users
    $result = $pdo->query("SELECT id, username, email, password, status FROM admins");
    $admins = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($admins as $admin) {
        echo "Admin ID: {$admin['id']}\n";
        echo "Username: {$admin['username']}\n";
        echo "Email: {$admin['email']}\n";
        echo "Status: {$admin['status']}\n";
        echo "Password hash: {$admin['password']}\n";

        // Test common passwords
        $passwords = ['admin123', 'admin@123', 'password', '123456'];
        foreach ($passwords as $password) {
            $valid = password_verify($password, $admin['password']);
            echo "  Password '$password': " . ($valid ? '✓ VALID' : '✗ INVALID') . "\n";
        }
        echo "\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>











