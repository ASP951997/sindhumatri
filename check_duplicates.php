<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$result = $conn->query('SHOW TABLES');
$tables = [];
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

// Check for tables related to the mentioned dropdowns
$relevant_tables = array_filter($tables, function($table) {
    return strpos($table, 'country') !== false ||
           strpos($table, 'complexion') !== false ||
           strpos($table, 'family_value') !== false ||
           strpos($table, 'body_type') !== false ||
           strpos($table, 'caste') !== false ||
           strpos($table, 'religion') !== false ||
           strpos($table, 'marital') !== false;
});

echo "=== DUPLICATE DATA ANALYSIS ===\n\n";
echo "Relevant tables found: " . implode(', ', $relevant_tables) . "\n";
echo "Total relevant tables: " . count($relevant_tables) . "\n\n";

// Check each relevant table for duplicates
$tables_to_check = [
    'countries' => 'name',
    'complexion_details' => 'name',
    'family_value_details' => 'name',
    'body_type_details' => 'name',
    'caste_details' => 'name',
    'religion_details' => 'name',
    'marital_status_details' => 'name'
];

foreach ($tables_to_check as $table => $column) {
    if (in_array($table, $tables)) {
        echo "--- $table ---\n";

        // Check total records
        $result = $conn->query("SELECT COUNT(*) as total FROM $table");
        $row = $result->fetch_assoc();
        echo "Total records: " . $row['total'] . "\n";

        // Check for duplicates
        $result = $conn->query("SELECT $column, COUNT(*) as count FROM $table GROUP BY $column HAVING COUNT(*) > 1 ORDER BY count DESC LIMIT 10");

        if ($result->num_rows > 0) {
            echo "DUPLICATES FOUND:\n";
            while ($row = $result->fetch_assoc()) {
                echo "  - '" . $row[$column] . "' appears " . $row['count'] . " times\n";
            }
        } else {
            echo "No duplicates found\n";
        }
        echo "\n";
    }
}

// Check countries table specifically since it's mentioned multiple times
if (in_array('countries', $tables)) {
    echo "--- COUNTRIES TABLE ANALYSIS ---\n";
    $result = $conn->query("SELECT name, COUNT(*) as count FROM countries GROUP BY name HAVING COUNT(*) > 1 ORDER BY count DESC");
    if ($result->num_rows > 0) {
        echo "Country duplicates:\n";
        while ($row = $result->fetch_assoc()) {
            echo "  - '" . $row['name'] . "' appears " . $row['count'] . " times\n";
        }
    }
    echo "\n";
}

$conn->close();
?>

