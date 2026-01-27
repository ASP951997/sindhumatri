<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== VERIFYING SPMO PASSWORD CHANGE ===\n\n";

    $result = $pdo->query("SELECT password FROM admins WHERE username = 'SPMO'");
    $admin = $result->fetch();

    if ($admin) {
        $isValidOld = password_verify('admin123', $admin['password']);
        $isValidNew = password_verify('admin@123', $admin['password']);

        echo "Testing old password 'admin123': " . ($isValidOld ? '✓ VALID' : '✗ INVALID') . "\n";
        echo "Testing new password 'admin@123': " . ($isValidNew ? '✓ VALID' : '✗ INVALID') . "\n";

        if ($isValidNew) {
            echo "\n✅ SPMO password successfully changed to 'admin@123'\n";
            echo "\n🎉 SPMO Admin login credentials:\n";
            echo "   Username: SPMO\n";
            echo "   Password: admin@123\n";
            echo "   URL: http://127.0.0.1:8000/admin\n";
        } else {
            echo "\n❌ Password change failed!\n";
        }
    } else {
        echo "SPMO admin not found\n";
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}

?>











