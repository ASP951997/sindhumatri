<?php
// drop_all_tables.php - Script to drop all tables before import

$servername = "localhost";
$username = "u105084344_matrimony";  // Replace with your actual database username
$password = "Spmo@111";  // Replace with your actual database password
$dbname = "u105084344_matrimony";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "🔌 Connected to database: $dbname<br><br>";

// Get all table names
$result = $conn->query("SHOW TABLES");
$tables = [];

if ($result) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

$tableCount = count($tables);
echo "📊 Found $tableCount tables to drop:<br>";

foreach ($tables as $table) {
    echo "  - $table<br>";
}

echo "<br>🗑️  Dropping all tables...<br>";

// Disable foreign key checks to avoid constraint errors
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Drop all tables
$droppedCount = 0;
foreach ($tables as $table) {
    if ($conn->query("DROP TABLE `$table`")) {
        $droppedCount++;
        echo "✅ Dropped: $table<br>";
    } else {
        echo "❌ Failed to drop: $table - " . $conn->error . "<br>";
    }
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<br>📊 Summary:<br>";
echo "✅ Tables dropped: $droppedCount<br>";
echo "📭 Database is now empty and ready for import!<br><br>";

echo "🚀 Next steps:<br>";
echo "1. Delete this file (drop_all_tables.php)<br>";
echo "2. Go to phpMyAdmin and import your SQL file<br>";
echo "3. Use the import options shown above<br><br>";

echo "🔐 After import, login with:<br>";
echo "   Username: SPMO<br>";
echo "   Password: admin123<br>";

$conn->close();
?>
