<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== DATABASE RESTORATION & USER UPDATE ===\n\n";

    // Step 1: Clear existing users table to prepare for restoration
    echo "Step 1: Clearing existing user data...\n";
    try {
        $pdo->exec("TRUNCATE TABLE users");
        echo "✓ Cleared users table\n";
    } catch (Exception $e) {
        echo "Note: Could not clear users table: " . $e->getMessage() . "\n";
    }

    // Step 2: Import user data from SQL file
    echo "\nStep 2: Importing user data from SQL file...\n";
    $sql = file_get_contents('Data Docs/u105084344_matrimony_123.sql');

    // Extract only INSERT INTO users statements
    $lines = explode("\n", $sql);
    $userInserts = [];
    $inUsersInsert = false;
    $currentInsert = '';

    foreach ($lines as $line) {
        $line = trim($line);

        if (strpos($line, 'INSERT INTO `users`') === 0) {
            $inUsersInsert = true;
            $currentInsert = $line;
        } elseif ($inUsersInsert) {
            $currentInsert .= ' ' . $line;
            if (substr($line, -1) === ';') {
                $userInserts[] = $currentInsert;
                $inUsersInsert = false;
                $currentInsert = '';
            }
        }
    }

    echo "Found " . count($userInserts) . " user INSERT statements\n";

    $importedUsers = 0;
    foreach ($userInserts as $insert) {
        try {
            $pdo->exec($insert);
            $importedUsers++;
        } catch (Exception $e) {
            // Skip duplicate key errors but log other issues
            if (strpos($e->getMessage(), 'Duplicate entry') === false) {
                echo "Error importing users: " . substr($e->getMessage(), 0, 100) . "...\n";
            }
        }
    }

    echo "✓ Imported $importedUsers user records\n";

    // Step 3: Update or create SPMO user
    echo "\nStep 3: Setting up SPMO admin user...\n";

    // Check if SPMO user exists
    $result = $pdo->query("SELECT id FROM users WHERE username = 'SPMO'");
    $existingUser = $result->fetch();

    if ($existingUser) {
        // Update existing SPMO user
        $stmt = $pdo->prepare("UPDATE users SET password = ?, firstname = 'SPMO', lastname = 'Admin', status = 1, email_verification = 1, sms_verification = 1, updated_at = ? WHERE username = 'SPMO'");
        $stmt->execute([
            password_hash('admin123', PASSWORD_DEFAULT),
            date('Y-m-d H:i:s')
        ]);
        echo "✓ Updated existing SPMO user with new password\n";
    } else {
        // Create new SPMO user
        $stmt = $pdo->prepare("INSERT INTO users (firstname, lastname, username, password, phone, language_id, status, email_verification, sms_verification, balance, interest_balance, two_fa, two_fa_verify, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            'SPMO',
            'Admin',
            'SPMO',
            password_hash('admin123', PASSWORD_DEFAULT),
            '1234567890',
            1,
            1, // status
            1, // email_verification
            1, // sms_verification
            0.00, // balance
            0.00, // interest_balance
            0, // two_fa
            0, // two_fa_verify
            date('Y-m-d H:i:s'),
            date('Y-m-d H:i:s')
        ]);
        echo "✓ Created new SPMO admin user\n";
    }

    // Step 4: Final verification
    echo "\nStep 4: Final verification...\n";

    // Check total users
    $result = $pdo->query('SELECT COUNT(*) as count FROM users');
    $row = $result->fetch();
    $totalUsers = $row['count'];
    echo "Total users in database: $totalUsers\n";

    // Check SPMO user specifically
    $result = $pdo->query("SELECT id, firstname, lastname, username FROM users WHERE username = 'SPMO'");
    $spmoUser = $result->fetch();

    if ($spmoUser) {
        echo "✓ SPMO user verified: ID {$spmoUser['id']}, Name: {$spmoUser['firstname']} {$spmoUser['lastname']}, Username: {$spmoUser['username']}\n";
    } else {
        echo "✗ SPMO user not found!\n";
    }

    // Show first 3 users as sample
    if ($totalUsers > 0) {
        echo "\nSample users in database:\n";
        $result = $pdo->query('SELECT id, firstname, lastname, username FROM users LIMIT 3');
        while ($user = $result->fetch()) {
            echo "- ID {$user['id']}: {$user['firstname']} {$user['lastname']} ({$user['username']})\n";
        }
    }

    echo "\n=== RESTORATION COMPLETE ===\n";
    echo "Admin login credentials:\n";
    echo "Username: SPMO\n";
    echo "Password: admin123\n";
    echo "URL: http://localhost:8000/admin/login\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
