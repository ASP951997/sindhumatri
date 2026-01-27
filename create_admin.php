<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Creating admin user...\n";

    // Check if admin already exists
    $result = $pdo->query("SELECT COUNT(*) as count FROM users WHERE username = 'admin'");
    $count = $result->fetch()['count'];

    if ($count > 0) {
        echo "Admin user already exists!\n";
    } else {
        // Insert admin user
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, password, email, phone, language_id, status, email_verification, sms_verification, two_fa, two_fa_verify, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            'Super',
            'Admin',
            'admin',
            password_hash('admin123', PASSWORD_DEFAULT),
            'admin@matrimony.com', // email (required field)
            '1234567890',
            1,
            1, // status
            1, // email_verification
            1, // sms_verification
            0, // two_fa
            1, // two_fa_verify (set to 1 as default)
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);

        echo "✓ Admin user created successfully!\n";
    }

    // Show current user count
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    echo "Total users in database: " . $row['count'] . "\n";

    echo "\nAdmin login credentials:\n";
    echo "Username: admin\n";
    echo "Password: admin123\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
