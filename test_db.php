<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✓ Database connection successful!\n\n";

    // Test if admins table exists and has SPMO user
    $result = $pdo->query("SELECT COUNT(*) as count FROM admins WHERE username = 'SPMO'");
    $count = $result->fetch()['count'];

    if ($count > 0) {
        echo "✓ SPMO admin user exists\n";
    } else {
        echo "✗ SPMO admin user not found\n";
    }

} catch (Exception $e) {
    echo '✗ Database connection failed: ' . $e->getMessage() . "\n";
}
?>











