<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('DESCRIBE countries');
echo "Countries table structure:\n";
while ($row = $result->fetch_assoc()) {
    echo $row['Field'] . ' - ' . $row['Type'] . ' - Key: ' . $row['Key'] . "\n";
}

echo "\nChecking indexes:\n";
$result = $conn->query('SHOW INDEX FROM countries');
while ($row = $result->fetch_assoc()) {
    echo 'Index: ' . $row['Key_name'] . ' on ' . $row['Column_name'] . ' (Unique: ' . ($row['Non_unique'] == 0 ? 'Yes' : 'No') . ")\n";
}

$conn->close();
?>

