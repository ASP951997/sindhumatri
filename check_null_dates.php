<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== CHECKING NULL DATE FIELDS ===\n\n";

    // Check for NULL created_at
    $result = $pdo->query("SELECT COUNT(*) as count FROM users WHERE created_at IS NULL");
    $nullCreated = $result->fetch()['count'];

    // Check for NULL updated_at
    $result = $pdo->query("SELECT COUNT(*) as count FROM users WHERE updated_at IS NULL");
    $nullUpdated = $result->fetch()['count'];

    echo "Users with NULL created_at: $nullCreated\n";
    echo "Users with NULL updated_at: $nullUpdated\n\n";

    if ($nullCreated > 0 || $nullUpdated > 0) {
        echo "Fixing NULL timestamps...\n";

        // Update NULL created_at with current timestamp
        if ($nullCreated > 0) {
            $pdo->exec("UPDATE users SET created_at = NOW() WHERE created_at IS NULL");
            echo "✓ Fixed created_at timestamps\n";
        }

        // Update NULL updated_at with current timestamp
        if ($nullUpdated > 0) {
            $pdo->exec("UPDATE users SET updated_at = NOW() WHERE updated_at IS NULL");
            echo "✓ Fixed updated_at timestamps\n";
        }

        echo "\nAll NULL timestamps have been fixed!\n";
    } else {
        echo "✅ No NULL timestamps found - all dates are properly set!\n";
    }

    // Show sample users to verify
    echo "\nSample users with timestamps:\n";
    $result = $pdo->query('SELECT id, firstname, lastname, created_at, updated_at FROM users LIMIT 5');
    while ($user = $result->fetch()) {
        echo "- ID {$user['id']}: {$user['firstname']} {$user['lastname']} - Created: {$user['created_at']} - Updated: {$user['updated_at']}\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>











