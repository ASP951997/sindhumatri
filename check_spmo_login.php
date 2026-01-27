<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== SPMO USER LOGIN DEBUG ===\n\n";

    // Check SPMO user details
    $result = $pdo->query("SELECT id, username, password, email, status, email_verification, sms_verification FROM users WHERE username = 'SPMO'");
    $user = $result->fetch();

    if ($user) {
        echo "SPMO User Details:\n";
        echo "ID: {$user['id']}\n";
        echo "Username: {$user['username']}\n";
        echo "Email: {$user['email']}\n";
        echo "Status: {$user['status']}\n";
        echo "Email Verified: {$user['email_verification']}\n";
        echo "SMS Verified: {$user['sms_verification']}\n";
        echo "Password Hash: " . substr($user['password'], 0, 20) . "...\n\n";

        // Test password verification
        $testPassword = 'admin123';
        $isValid = password_verify($testPassword, $user['password']);
        echo "Password Verification Test:\n";
        echo "Testing password 'admin123': " . ($isValid ? '✓ VALID' : '✗ INVALID') . "\n";

        if (!$isValid) {
            echo "ERROR: Password verification failed!\n";
            echo "This means the password hash doesn't match 'admin123'\n";
        }
    } else {
        echo "✗ SPMO user not found in database!\n";
    }

    // Also check if there are any authentication-related settings
    echo "\n=== CHECKING AUTHENTICATION SETTINGS ===\n";

    // Check if user has required verifications
    if ($user) {
        $issues = [];

        if ($user['status'] != 1) {
            $issues[] = "User status is not active (current: {$user['status']})";
        }

        if ($user['email_verification'] != 1) {
            $issues[] = "Email verification is disabled (current: {$user['email_verification']})";
        }

        if ($user['sms_verification'] != 1) {
            $issues[] = "SMS verification is disabled (current: {$user['sms_verification']})";
        }

        if (empty($user['password'])) {
            $issues[] = "Password field is empty";
        }

        if (count($issues) > 0) {
            echo "Potential login issues:\n";
            foreach ($issues as $issue) {
                echo "  - $issue\n";
            }
        } else {
            echo "✓ All authentication settings look correct\n";
        }
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>












