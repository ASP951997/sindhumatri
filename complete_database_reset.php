<?php
// complete_database_reset.php - Complete database cleanup and reset

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

// Step 1: Disable foreign key checks
echo "🔓 Step 1: Disabling foreign key checks...<br>";
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Step 2: Get all tables
echo "📊 Step 2: Finding all tables...<br>";
$result = $conn->query("SHOW TABLES");
$tables = [];

if ($result) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
}

$tableCount = count($tables);
echo "Found $tableCount tables:<br>";
foreach ($tables as $table) {
    echo "  - $table<br>";
}
echo "<br>";

// Step 3: Drop all tables
echo "🗑️  Step 3: Dropping all tables...<br>";
$droppedCount = 0;
$failedCount = 0;

foreach ($tables as $table) {
    if ($conn->query("DROP TABLE IF EXISTS `$table`")) {
        $droppedCount++;
        echo "✅ Dropped: $table<br>";
    } else {
        $failedCount++;
        echo "❌ Failed to drop: $table - " . $conn->error . "<br>";
    }
}

echo "<br>📊 Drop Summary:<br>";
echo "✅ Tables dropped: $droppedCount<br>";
echo "❌ Failed drops: $failedCount<br><br>";

// Step 4: Verify database is empty
echo "🔍 Step 4: Verifying database is clean...<br>";
$result = $conn->query("SHOW TABLES");
$remainingTables = $result->num_rows;

if ($remainingTables == 0) {
    echo "✅ Database is completely empty!<br><br>";
} else {
    echo "⚠️  Still has $remainingTables tables remaining<br><br>";
}

// Step 5: Re-enable foreign key checks
echo "🔒 Step 5: Re-enabling foreign key checks...<br>";
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "<br>🎉 DATABASE RESET COMPLETE!<br><br>";

echo "🚀 Ready for import. Now you can:<br>";
echo "1. Delete this file (complete_database_reset.php)<br>";
echo "2. Go to phpMyAdmin<br>";
echo "3. Select your database ($dbname)<br>";
echo "4. Go to Import tab<br>";
echo "5. Upload local_backup_20260120_065131.sql<br>";
echo "6. Click 'Go' (no special options needed)<br><br>";

echo "🔐 After import, login with:<br>";
echo "   Username: SPMO<br>";
echo "   Password: admin123<br><br>";

echo "⚠️  IMPORTANT: Delete all PHP files after successful import!<br>";

$conn->close();
?>




