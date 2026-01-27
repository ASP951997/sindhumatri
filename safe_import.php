<?php
// safe_import.php - Alternative import script with better error handling

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

echo "🔌 Connected to database successfully<br>";
echo "📊 Database: $dbname<br><br>";

// Check if SQL file exists
$sqlFile = 'local_backup_20260120_065131.sql';
if (!file_exists($sqlFile)) {
    die("❌ Error: SQL file '$sqlFile' not found!");
}

// Read SQL file
$sql = file_get_contents($sqlFile);
if ($sql === false) {
    die("❌ Error: Could not read SQL file!");
}

echo "📁 SQL file loaded<br>";
echo "📏 File size: " . strlen($sql) . " bytes<br><br>";

// Split SQL into individual statements
$statements = array_filter(array_map('trim', explode(';', $sql)));
$totalStatements = count($statements);

echo "🔄 Processing $totalStatements SQL statements...<br>";
echo "⏳ This may take several minutes...<br><br>";

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
echo "🔓 Foreign key checks disabled<br>";

// Process each statement
$successCount = 0;
$errorCount = 0;

foreach ($statements as $index => $statement) {
    $statement = trim($statement);
    if (empty($statement)) continue;

    if ($conn->query($statement)) {
        $successCount++;
    } else {
        $errorCount++;
        echo "⚠️  Statement " . ($index + 1) . " error: " . $conn->error . "<br>";
        // Continue with other statements
    }

    // Progress indicator every 100 statements
    if (($index + 1) % 100 == 0) {
        echo "📈 Progress: " . ($index + 1) . "/$totalStatements statements processed<br>";
    }
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
echo "🔒 Foreign key checks re-enabled<br><br>";

echo "📊 Import Summary:<br>";
echo "✅ Successful statements: $successCount<br>";
echo "❌ Failed statements: $errorCount<br><br>";

// Verify the import
$userResult = $conn->query("SELECT COUNT(*) as count FROM users");
if ($userResult) {
    $userCount = $userResult->fetch_assoc()['count'];
    echo "👥 Users in database: $userCount<br>";
}

$adminResult = $conn->query("SELECT COUNT(*) as count FROM admins");
if ($adminResult) {
    $adminCount = $adminResult->fetch_assoc()['count'];
    echo "👨‍💼 Admins in database: $adminCount<br><br>";
}

if ($errorCount == 0) {
    echo "🎉 Database import completed successfully!<br><br>";
} else {
    echo "⚠️  Import completed with $errorCount errors. Some data may be missing.<br><br>";
}

echo "🔐 Admin Login Credentials:<br>";
echo "   Username: SPMO<br>";
echo "   Password: admin123<br><br>";
echo "🌐 Login URL: https://sindhumatri.com/admin/login<br><br>";
echo "🗑️  Remember to delete both import files after testing!<br>";
echo "📁 Files to delete: import_db.php, safe_import.php, local_backup_*.sql<br>";

$conn->close();
?>



