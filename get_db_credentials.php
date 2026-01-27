<?php
// get_db_credentials.php - Help find database credentials
// Upload this to your live server and run it

echo "<h2>🔍 DATABASE CREDENTIALS FINDER</h2>";
echo "<p>This script helps you find your database credentials.</p>";

// Common credential patterns for shared hosting
$commonHosts = ['localhost', '127.0.0.1'];
$commonUsers = [
    'u105084344_user',
    'u105084344_matrimony',
    'u105084344_admin',
    'root',
    'db_user'
];

$commonPasswords = [
    'Spmo@111',
    'admin123',
    'password',
    '123456',
    'database_password'
];

$databases = [
    'u105084344_matrimony',
    'u105084344_matrimony_1',
    'matrimony',
    'sindhumatri_db'
];

echo "<h3>🔄 Testing Common Credentials...</h3>";
echo "<pre>";

$found = false;

foreach ($commonHosts as $host) {
    foreach ($commonUsers as $user) {
        foreach ($commonPasswords as $pass) {
            foreach ($databases as $db) {
                $conn = @new mysqli($host, $user, $pass, $db);

                if ($conn && !$conn->connect_error) {
                    echo "\n✅ SUCCESS! Working credentials found:\n";
                    echo "Host: $host\n";
                    echo "Username: $user\n";
                    echo "Password: $pass\n";
                    echo "Database: $db\n\n";

                    // Test if tables exist
                    $result = $conn->query("SHOW TABLES LIKE 'admins'");
                    if ($result && $result->num_rows > 0) {
                        echo "✅ Admins table exists - database has data\n";
                    } else {
                        echo "ℹ️  Database is empty or tables don't exist yet\n";
                    }

                    $conn->close();
                    $found = true;
                    break 4;
                }
            }
        }
    }
}

if (!$found) {
    echo "\n❌ No working credentials found automatically.\n";
    echo "Please check your hosting control panel manually.\n\n";
}

echo "</pre>";

echo "<div style='background: #e8f4fd; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>📋 Manual Steps:</h3>";
echo "<ol>";
echo "<li>Login to your hosting cPanel</li>";
echo "<li>Go to <strong>Databases → MySQL Databases</strong></li>";
echo "<li>Find your database details in the 'Current Databases' section</li>";
echo "<li>Note down: Database name, Username, and use the password you set</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>🔧 Use These Credentials In:</h3>";
echo "<ul>";
echo "<li><code>complete_live_import.php</code> - For full database import</li>";
echo "<li><code>live_db_check.php</code> - For testing connection</li>";
echo "</ul>";
echo "</div>";
?>




