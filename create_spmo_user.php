<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Creating SPMO admin user...\n";

    // Check if SPMO user already exists
    $result = $pdo->query("SELECT id, firstname, lastname FROM users WHERE username = 'SPMO'");
    $existingUser = $result->fetch();

    if ($existingUser) {
        // Update existing user
        $stmt = $pdo->prepare("UPDATE users SET password = ?, firstname = 'SPMO', lastname = 'Admin', status = 1, email_verification = 1, sms_verification = 1, updated_at = ? WHERE username = 'SPMO'");
        $stmt->execute([
            password_hash('admin123', PASSWORD_DEFAULT),
            date('Y-m-d H:i:s')
        ]);
        echo "✓ Updated existing SPMO user\n";
    } else {
        // Create new SPMO user
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, password, email, phone, language_id, status, email_verification, sms_verification, two_fa, two_fa_verify, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            'SPMO',
            'Admin',
            'SPMO',
            password_hash('admin123', PASSWORD_DEFAULT),
            'spmo@matrimony.com', // email (required field)
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
        echo "✓ Created new SPMO admin user\n";
    }

    // Verification
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    echo "Total users in database: " . $row['count'] . "\n";

    $result = $pdo->query("SELECT id, firstname, lastname, username FROM users WHERE username = 'SPMO'");
    $user = $result->fetch();

    if ($user) {
        echo "✓ SPMO user confirmed: {$user['firstname']} {$user['lastname']} ({$user['username']})\n";
    }

    echo "\nAdmin login credentials:\n";
    echo "Username: SPMO\n";
    echo "Password: admin123\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
