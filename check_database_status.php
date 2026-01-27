<?php
// check_database_status.php - Check current database state

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

// Check current tables
echo "📊 Current Tables in Database:<br>";
$result = $conn->query("SHOW TABLES");

if ($result) {
    $tableCount = $result->num_rows;
    echo "Total tables: $tableCount<br><br>";

    if ($tableCount > 0) {
        while ($row = $result->fetch_array()) {
            echo "  - $row[0]<br>";
        }
    } else {
        echo "✅ Database is EMPTY (good for import)<br>";
    }
} else {
    echo "❌ Could not check tables<br>";
}

echo "<br>";

// Check if admins table exists
echo "🔍 Checking for admins table:<br>";
$adminCheck = $conn->query("SHOW TABLES LIKE 'admins'");
if ($adminCheck && $adminCheck->num_rows > 0) {
    echo "❌ Admins table EXISTS - this is causing the conflict!<br>";

    // Try to show table structure
    $structure = $conn->query("DESCRIBE admins");
    if ($structure) {
        echo "Current admins table structure:<br>";
        while ($field = $structure->fetch_assoc()) {
            echo "  - {$field['Field']} ({$field['Type']})<br>";
        }
    }
} else {
    echo "✅ Admins table does NOT exist (ready for import)<br>";
}

echo "<br>";

// Check user privileges
echo "👤 Database User Privileges:<br>";
$privileges = $conn->query("SHOW GRANTS");
if ($privileges) {
    while ($grant = $privileges->fetch_array()) {
        echo "  - $grant[0]<br>";
    }
} else {
    echo "❌ Could not check privileges<br>";
}

echo "<br>";

// Test table creation
echo "🧪 Testing table creation:<br>";
$testCreate = $conn->query("CREATE TABLE test_import_table (id INT PRIMARY KEY)");
if ($testCreate) {
    echo "✅ Can create tables<br>";
    $conn->query("DROP TABLE test_import_table");
} else {
    echo "❌ Cannot create tables: " . $conn->error . "<br>";
}

echo "<br>🚀 RECOMMENDATIONS:<br>";
echo "1. If tables exist: Run complete_database_reset.php again<br>";
echo "2. If no tables: Proceed with SQL import<br>";
echo "3. If permission errors: Contact hosting support<br><br>";

echo "⚠️  Delete this file after checking!<br>";

$conn->close();
?>




