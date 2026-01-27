<?php
// import_db.php - One-time use script
$servername = "localhost";
$username = "SPMO";
$password = "admin123";
$dbname = "u105084344_matrimony";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read SQL file
$sql = file_get_contents('local_backup_20260120_065131.sql');

// Execute SQL
if ($conn->multi_query($sql)) {
    echo "Database imported successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>