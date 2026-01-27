<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== DATABASE CLEANUP VERIFICATION ===\n\n";

// Test countries
$result = $conn->query('SELECT COUNT(*) as count FROM countries');
$row = $result->fetch_assoc();
echo "Countries: " . $row['count'] . " records\n";

// Check for India specifically
$result = $conn->query('SELECT COUNT(*) as count FROM countries WHERE name = "India"');
$row = $result->fetch_assoc();
echo "India entries: " . $row['count'] . " (should be 1)\n\n";

// Test complexion_details
$result = $conn->query('SELECT COUNT(*) as count FROM complexion_details');
$row = $result->fetch_assoc();
echo "Complexion details: " . $row['count'] . " records\n";

// Test family_value_details
$result = $conn->query('SELECT COUNT(*) as count FROM family_value_details');
$row = $result->fetch_assoc();
echo "Family value details: " . $row['count'] . " records\n";

// Test body_type_details
$result = $conn->query('SELECT COUNT(*) as count FROM body_type_details');
$row = $result->fetch_assoc();
echo "Body type details: " . $row['count'] . " records\n";

// Test a sample query like Laravel would use
$result = $conn->query('SELECT * FROM languages WHERE short_name = "US" LIMIT 1');
if ($result->num_rows > 0) {
    echo "\n✅ Language query works (the original error should be fixed)\n";
} else {
    echo "\n❌ Language query failed\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";

$conn->close();
?>

