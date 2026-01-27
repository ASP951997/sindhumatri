<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== CREATING NEW SP ADMIN USER ===\n\n";

    // Check if SP admin already exists
    $result = $pdo->query("SELECT COUNT(*) as count FROM admins WHERE username = 'SP'");
    $count = $result->fetch()['count'];

    if ($count > 0) {
        echo "SP admin user already exists!\n";

        // Update the password instead
        $newPassword = password_hash('admin@123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE admins SET password = ? WHERE username = 'SP'");
        $result = $stmt->execute([$newPassword]);

        if ($result) {
            echo "✓ Successfully updated SP admin password to 'admin@123'\n\n";
        }
    } else {
        // Insert new SP admin user
        $stmt = $pdo->prepare("INSERT INTO admins (name, username, email, password, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            'SP Admin',
            'SP',
            'sp@matrimony.com',
            password_hash('admin@123', PASSWORD_DEFAULT),
            1, // status active
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        echo "✓ SP admin user created successfully!\n";
    }

    // Verify the admin user
    $result = $pdo->query("SELECT id, name, username, email, status FROM admins WHERE username = 'SP'");
    $admin = $result->fetch();

    if ($admin) {
        echo "\n✓ SP Admin Details:\n";
        echo "  ID: {$admin['id']}\n";
        echo "  Name: {$admin['name']}\n";
        echo "  Username: {$admin['username']}\n";
        echo "  Email: {$admin['email']}\n";
        echo "  Status: {$admin['status']}\n\n";

        // Test password verification
        $testPassword = 'admin@123';
        $adminPassword = $pdo->query("SELECT password FROM admins WHERE username = 'SP'")->fetch()['password'];
        $isValid = password_verify($testPassword, $adminPassword);
        echo "Password verification test: " . ($isValid ? '✓ VALID' : '✗ INVALID') . "\n";
    }

    // Show current admin count
    $result = $pdo->query('SELECT COUNT(*) as count FROM admins');
    $row = $result->fetch();
    echo "Total admins in database: " . $row['count'] . "\n";

    echo "\n🎉 New SP Admin login credentials:\n";
    echo "   Username: SP\n";
    echo "   Password: admin@123\n";
    echo "   URL: http://127.0.0.1:8000/admin\n";

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}

?>











