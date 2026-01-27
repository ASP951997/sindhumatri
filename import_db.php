<?php
// import_db.php - One-time use script
$servername = "localhost";  // Usually localhost for shared hosting
$username = "your_live_db_username";  // Replace with your actual database username
$password = "your_live_db_password";  // Replace with your actual database password
$dbname = "u105084344_matrimony";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if SQL file exists
$sqlFile = 'local_backup_20260120_065131.sql';
if (!file_exists($sqlFile)) {
    die("Error: SQL file '$sqlFile' not found in the same directory!");
}

// Read SQL file
$sql = file_get_contents($sqlFile);
if ($sql === false) {
    die("Error: Could not read SQL file!");
}

echo "Starting database import...<br>";
echo "File size: " . strlen($sql) . " bytes<br>";
echo "Database: $dbname<br><br>";
echo "⏳ Importing... This may take a few minutes...<br><br>";

// Disable foreign key checks to avoid constraint errors
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Execute SQL with error handling
if ($conn->multi_query($sql)) {
    // Process all results to ensure all queries are executed
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());

    // Re-enable foreign key checks
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    echo "✅ Database imported successfully!<br>";
    echo "🎉 Your matrimony database has been restored.<br><br>";

    // Verify the import by checking user count
    $userResult = $conn->query("SELECT COUNT(*) as count FROM users");
    if ($userResult) {
        $userCount = $userResult->fetch_assoc()['count'];
        echo "👥 Users imported: $userCount<br>";
    }

    $adminResult = $conn->query("SELECT COUNT(*) as count FROM admins");
    if ($adminResult) {
        $adminCount = $adminResult->fetch_assoc()['count'];
        echo "👨‍💼 Admins imported: $adminCount<br><br>";
    }

    echo "🔐 Admin Login Credentials:<br>";
    echo "   Username: SPMO<br>";
    echo "   Password: admin123<br><br>";
    echo "🌐 Login URL: https://sindhumatri.com/admin/login<br><br>";
    echo "⚠️  IMPORTANT: Delete this file immediately after import for security!";
} else {
    // Re-enable foreign key checks even on error
    $conn->query("SET FOREIGN_KEY_CHECKS = 1");

    echo "❌ Import Error: " . $conn->error . "<br>";
    echo "Please check your database credentials and file permissions.";
}

$conn->close();
?>