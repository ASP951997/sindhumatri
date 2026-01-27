<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check user count
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    echo 'Total users in database: ' . $row['count'] . PHP_EOL;

    if ($row['count'] > 0) {
        echo PHP_EOL . 'First 10 users:' . PHP_EOL;
        $result = $pdo->query('SELECT id, firstname, lastname, username, email FROM users LIMIT 10');
        while ($user = $result->fetch()) {
            echo 'ID: ' . $user['id'] . ', Name: ' . $user['firstname'] . ' ' . $user['lastname'] . ', Username: ' . $user['username'] . ', Email: ' . $user['email'] . PHP_EOL;
        }

        // Check for admin-like users
        echo PHP_EOL . 'Checking for admin users...' . PHP_EOL;
        $result = $pdo->query("SELECT id, firstname, lastname, username FROM users WHERE username LIKE '%admin%' OR firstname LIKE '%admin%' OR lastname LIKE '%admin%' OR username LIKE '%super%' LIMIT 5");
        $adminCount = 0;
        while ($admin = $result->fetch()) {
            echo 'POTENTIAL ADMIN - ID: ' . $admin['id'] . ', Name: ' . $admin['firstname'] . ' ' . $admin['lastname'] . ', Username: ' . $admin['username'] . PHP_EOL;
            $adminCount++;
        }

        if ($adminCount == 0) {
            echo 'No obvious admin users found.' . PHP_EOL;
        }
    } else {
        echo 'No users found in database.' . PHP_EOL;
    }

} catch (Exception $e) {
    echo 'Database connection error: ' . $e->getMessage() . PHP_EOL;
}
