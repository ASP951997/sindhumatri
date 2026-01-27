<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== TESTING SP ADMIN PASSWORD ===\n\n";

    $result = $pdo->query("SELECT password FROM admins WHERE username = 'SP'");
    $admin = $result->fetch();

    if ($admin) {
        $isValid = password_verify('admin@123', $admin['password']);
        echo "SP Admin password verification: " . ($isValid ? '✓ VALID' : '✗ INVALID') . "\n";
        echo "\n🎉 SP Admin login credentials:\n";
        echo "   Username: SP\n";
        echo "   Password: admin@123\n";
        echo "   URL: http://127.0.0.1:8000/admin\n";
    } else {
        echo "SP admin not found\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}

?>











