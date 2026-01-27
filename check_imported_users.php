<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== CHECKING IMPORTED USER DATA ===\n\n";

    // Check total users
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    $totalUsers = $row['count'];

    echo "Total users in database: $totalUsers\n\n";

    // Check email field distribution
    echo "Email field analysis:\n";
    $result = $pdo->query("SELECT email, COUNT(*) as count FROM users GROUP BY email ORDER BY count DESC LIMIT 10");
    $emails = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($emails as $email) {
        $emailValue = $email['email'] ?: 'NULL/EMPTY';
        echo "  '$emailValue': {$email['count']} users\n";
    }

    // Check for users with actual email addresses
    $result = $pdo->query("SELECT COUNT(*) as count FROM users WHERE email IS NOT NULL AND email != '' AND email != '0'");
    $row = $result->fetch();
    $usersWithEmails = $row['count'];

    echo "\nUsers with valid emails: $usersWithEmails\n";
    echo "Users without emails: " . ($totalUsers - $usersWithEmails) . "\n\n";

    // Show sample users with email analysis
    echo "Sample users with email status:\n";
    $result = $pdo->query('SELECT id, firstname, lastname, username, email, phone FROM users LIMIT 10');
    while ($user = $result->fetch()) {
        $emailStatus = empty($user['email']) || $user['email'] === '0' ? 'NO EMAIL' : 'HAS EMAIL';
        $emailDisplay = empty($user['email']) || $user['email'] === '0' ? 'N/A' : $user['email'];
        echo "- ID {$user['id']}: {$user['firstname']} {$user['lastname']} ({$user['username']}) - Email: $emailDisplay [$emailStatus]\n";
    }

    // Check if email column exists and what type it is
    echo "\nEmail column structure:\n";
    $result = $pdo->query("DESCRIBE users");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        if ($column['Field'] === 'email') {
            echo "  Column: {$column['Field']}\n";
            echo "  Type: {$column['Type']}\n";
            echo "  Null: {$column['Null']}\n";
            echo "  Default: " . ($column['Default'] ?: 'NULL') . "\n";
            break;
        }
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>











