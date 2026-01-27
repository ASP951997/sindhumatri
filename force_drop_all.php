<?php
// force_drop_all.php - Force drop all tables with multiple methods

$servername = "localhost";
$username = "your_live_db_username";  // Replace with your actual database username
$password = "your_live_db_password";  // Replace with your actual database password
$dbname = "u105084344_matrimony";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "🔌 Connected to database: $dbname<br><br>";

// Method 1: Disable constraints and drop
echo "🗑️  Method 1: Force drop all tables...<br>";
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Get all tables
$tables = [];
$result = $conn->query("SHOW TABLES");
if ($result) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

echo "Found " . count($tables) . " tables<br>";

// Drop each table
foreach ($tables as $table) {
    $conn->query("DROP TABLE IF EXISTS `$table`");
    echo "Dropped: $table<br>";
}

// Method 2: Clear any remaining views/procedures
echo "<br>🧹 Method 2: Clear views and procedures...<br>";
$views = $conn->query("SHOW FULL TABLES WHERE Table_type = 'VIEW'");
if ($views) {
    while ($view = $views->fetch_array()) {
        $conn->query("DROP VIEW IF EXISTS `{$view[0]}`");
        echo "Dropped view: {$view[0]}<br>";
    }
}

$procedures = $conn->query("SHOW PROCEDURE STATUS WHERE Db = '$dbname'");
if ($procedures) {
    while ($proc = $procedures->fetch_assoc()) {
        $conn->query("DROP PROCEDURE IF EXISTS `{$proc['Name']}`");
        echo "Dropped procedure: {$proc['Name']}<br>";
    }
}

// Method 3: Reset auto_increment
echo "<br>🔄 Method 3: Reset database...<br>";
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

// Verify clean
$result = $conn->query("SHOW TABLES");
$remaining = $result ? $result->num_rows : 0;

if ($remaining == 0) {
    echo "<br>✅ SUCCESS: Database is completely clean!<br>";
    echo "🚀 You can now import your SQL file safely.<br><br>";
} else {
    echo "<br>⚠️  Still has $remaining tables remaining<br>";
}

echo "📋 Next steps:<br>";
echo "1. Delete this file (force_drop_all.php)<br>";
echo "2. Delete check_database_status.php<br>";
echo "3. Go to phpMyAdmin and import local_backup_20260120_065131.sql<br>";
echo "4. Use default import settings<br><br>";

echo "🔐 After import, login with:<br>";
echo "   Username: SPMO<br>";
echo "   Password: admin123<br><br>";

$conn->close();
?>



