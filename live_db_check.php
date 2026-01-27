<?php
// live_db_check.php - Check database on live server
// Upload this to your live server and run it

$servername = "localhost";  // Usually localhost for shared hosting
$username = "u105084344_matrimony";  // Replace with your actual database username
$password = "Spmo@111";  // Replace with your actual database password
$dbname = "u105084344_matrimony";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error . "<br><br>Check your database credentials.");
}

echo "🔌 Connected to database: $dbname<br><br>";

// Check current database
$result = $conn->query("SELECT DATABASE() as current_db");
if ($result) {
    $row = $result->fetch_assoc();
    echo "📊 Current database: <strong>" . $row['current_db'] . "</strong><br><br>";
}

// Check if funds table exists
$result = $conn->query("SHOW TABLES LIKE 'funds'");
if ($result && $result->num_rows > 0) {
    echo "✅ Funds table EXISTS<br>";

    // Check table structure
    $columns = $conn->query("DESCRIBE funds");
    if ($columns) {
        $columnCount = $columns->num_rows;
        echo "📋 Table has $columnCount columns<br>";
    }

    // Check record count
    $count = $conn->query("SELECT COUNT(*) as count FROM funds");
    if ($count) {
        $row = $count->fetch_assoc();
        echo "📊 Table has " . $row['count'] . " records<br><br>";
    }
} else {
    echo "❌ Funds table does NOT exist<br><br>";
}

// Test the problematic query
echo "🧪 Testing the problematic query:<br>";
$query = "select SUM(CASE WHEN status = 1 THEN amount END) AS totalAmountReceived, SUM(CASE WHEN status = 1 THEN charge END) AS totalChargeReceived, SUM((CASE WHEN created_at >= CURDATE() AND status = 1 THEN amount END)) AS todayPayment, SUM((CASE WHEN created_at >= DATE_SUB(CURRENT_DATE() , INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) THEN amount END)) AS thisMonthPayment from `funds`";

$result = $conn->query($query);
if ($result) {
    echo "✅ Query executed successfully!<br>";
    $row = $result->fetch_assoc();
    echo "📈 Results returned<br><br>";
} else {
    echo "❌ Query failed: " . $conn->error . "<br><br>";
}

// Check other essential tables
$essentialTables = ['admins', 'users', 'configures'];
echo "🔍 Checking essential tables:<br>";
foreach ($essentialTables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result && $result->num_rows > 0) {
        echo "✅ $table table exists<br>";
    } else {
        echo "❌ $table table MISSING<br>";
    }
}

echo "<br>🎯 SUMMARY:<br>";
echo "If funds table exists but query fails, the issue might be:<br>";
echo "1. Laravel connecting to wrong database<br>";
echo "2. .env file has wrong database name<br>";
echo "3. Laravel cache needs clearing<br><br>";

echo "🔧 FIXES TO TRY:<br>";
echo "1. Check your live .env file database settings<br>";
echo "2. Run: php artisan config:clear (if SSH available)<br>";
echo "3. Verify database name matches phpMyAdmin<br><br>";

echo "⚠️  Delete this file after checking!<br>";

$conn->close();
?>
