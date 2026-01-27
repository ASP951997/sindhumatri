<?php
// test_db_connection.php - Test different database credentials
// Try different combinations to find the correct ones

$testCredentials = [
    [
        'host' => 'localhost',
        'username' => 'u105084344_user',
        'password' => 'Spmo@111',
        'database' => 'u105084344_matrimony'
    ],
    [
        'host' => 'localhost',
        'username' => 'u105084344_matrimony',
        'password' => 'Spmo@111',
        'database' => 'u105084344_matrimony'
    ],
    [
        'host' => 'localhost',
        'username' => 'root',
        'password' => 'Spmo@111',
        'database' => 'u105084344_matrimony'
    ],
    [
        'host' => '127.0.0.1',
        'username' => 'u105084344_user',
        'password' => 'Spmo@111',
        'database' => 'u105084344_matrimony'
    ]
];

echo "🧪 Testing database connections...<br><br>";

foreach ($testCredentials as $index => $cred) {
    echo "Test " . ($index + 1) . ": {$cred['username']} @ {$cred['host']}<br>";

    $conn = new mysqli($cred['host'], $cred['username'], $cred['password'], $cred['database']);

    if ($conn->connect_error) {
        echo "❌ Failed: " . $conn->connect_error . "<br><br>";
    } else {
        echo "✅ SUCCESS! Connected to database: {$cred['database']}<br><br>";

        // Test if tables exist
        $result = $conn->query("SHOW TABLES LIKE 'admins'");
        if ($result && $result->num_rows > 0) {
            echo "✅ Admins table found<br>";
        } else {
            echo "⚠️  Admins table not found<br>";
        }

        $conn->close();
        break; // Stop at first successful connection
    }
}

echo "<br>📝 If none work, check your hosting control panel for the correct credentials.<br>";
?>




