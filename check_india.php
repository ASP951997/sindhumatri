<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('SELECT id, name FROM countries WHERE name = "India" LIMIT 10');
echo "India records in countries table:\n";
while ($row = $result->fetch_assoc()) {
    echo 'ID: ' . $row['id'] . ', Name: ' . $row['name'] . "\n";
}

// Check the DISTINCT approach
$result = $conn->query('SELECT DISTINCT name FROM countries WHERE name = "India"');
echo "\nDistinct India names: " . $result->num_rows . "\n";

// Check the MIN ID approach
$result = $conn->query('SELECT MIN(id) as min_id FROM countries WHERE name = "India"');
$row = $result->fetch_assoc();
echo "Min ID for India: " . $row['min_id'] . "\n";

$conn->close();
?>

