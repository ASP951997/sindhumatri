<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('DESCRIBE users');
echo "=== USERS TABLE COLUMNS ===\n";
$columns = [];
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
    echo $row['Field'] . ' - ' . $row['Type'] . "\n";
}

echo "\n=== POTENTIAL DROPDOWN COLUMNS ===\n";

// Look for columns that might reference dropdown tables
$potential_columns = array_filter($columns, function($col) {
    return strpos($col, 'country') !== false ||
           strpos($col, 'complexion') !== false ||
           strpos($col, 'family_value') !== false ||
           strpos($col, 'body_type') !== false ||
           strpos($col, 'caste') !== false ||
           strpos($col, 'religion') !== false ||
           strpos($col, 'marital') !== false ||
           strpos($col, 'present_address') !== false ||
           strpos($col, 'permanent_address') !== false;
});

foreach ($potential_columns as $col) {
    echo "- $col\n";
}

$conn->close();
?>
