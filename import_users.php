<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Starting user data import...\n";

    // Insert some sample users including an admin
    $users = [
        [
            'firstname' => 'Admin',
            'lastname' => 'User',
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'phone' => '1234567890',
            'language_id' => 1,
            'status' => 1,
            'email_verification' => 1,
            'sms_verification' => 1,
            'balance' => 0.00,
            'interest_balance' => 0.00,
            'two_fa' => 0,
            'two_fa_verify' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'firstname' => 'John',
            'lastname' => 'Doe',
            'username' => 'johndoe',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'phone' => '9876543210',
            'language_id' => 1,
            'status' => 1,
            'email_verification' => 1,
            'sms_verification' => 1,
            'balance' => 100.00,
            'interest_balance' => 0.00,
            'two_fa' => 0,
            'two_fa_verify' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ],
        [
            'firstname' => 'Jane',
            'lastname' => 'Smith',
            'username' => 'janesmith',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'phone' => '5556667777',
            'language_id' => 1,
            'status' => 1,
            'email_verification' => 1,
            'sms_verification' => 1,
            'balance' => 50.00,
            'interest_balance' => 0.00,
            'two_fa' => 0,
            'two_fa_verify' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, password, phone, language_id, status, email_verification, sms_verification, balance, interest_balance, two_fa, two_fa_verify, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($users as $user) {
        $stmt->execute([
            $user['firstname'],
            $user['lastname'],
            $user['username'],
            $user['password'],
            $user['phone'],
            $user['language_id'],
            $user['status'],
            $user['email_verification'],
            $user['sms_verification'],
            $user['balance'],
            $user['interest_balance'],
            $user['two_fa'],
            $user['two_fa_verify'],
            $user['created_at'],
            $user['updated_at']
        ]);
        echo "✓ Created user: " . $user['firstname'] . " " . $user['lastname'] . " (" . $user['username'] . ")\n";
    }

    echo "\nUser import completed successfully!\n";
    echo "Admin login credentials:\n";
    echo "Username: admin\n";
    echo "Email: admin@matrimony.com\n";
    echo "Password: admin123\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
