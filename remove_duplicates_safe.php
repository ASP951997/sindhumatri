<?php
/**
 * Safe Duplicate Removal Script
 * Uses temporary tables to avoid foreign key issues
 */

$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== SAFE DUPLICATE REMOVAL ===\n\n";

$tables_to_clean = [
    'countries' => 'name',
    'complexion_details' => 'name',
    'family_value_details' => 'name',
    'body_type_details' => 'name'
];

foreach ($tables_to_clean as $table => $name_column) {
    echo "--- Cleaning $table ---\n";

    // Get initial count
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $initial_count = $row['total'];
    echo "Initial count: $initial_count records\n";

    // Create temporary table with unique records (keeping the first occurrence by ID)
    $temp_table = $table . '_temp_unique';
    $conn->query("DROP TABLE IF EXISTS $temp_table");

    $conn->query("
        CREATE TABLE $temp_table AS
        SELECT * FROM $table
        WHERE id IN (
            SELECT MIN(id) FROM $table GROUP BY $name_column
        )
    ");

    $result = $conn->query("SELECT COUNT(*) as total FROM $temp_table");
    $row = $result->fetch_assoc();
    $unique_count = $row['total'];
    echo "Unique records: $unique_count\n";

    // Clear original table
    $conn->query("TRUNCATE TABLE $table");

    // Insert unique records back
    $conn->query("INSERT INTO $table SELECT * FROM $temp_table");

    // Drop temporary table
    $conn->query("DROP TABLE $temp_table");

    // Verify
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $final_count = $row['total'];
    echo "Final count: $final_count records\n";

    // Check for remaining duplicates
    $result = $conn->query("
        SELECT $name_column, COUNT(*) as count
        FROM $table
        GROUP BY $name_column
        HAVING COUNT(*) > 1
    ");

    if ($result->num_rows > 0) {
        echo "❌ Still has duplicates: " . $result->num_rows . " groups\n";
    } else {
        echo "✅ No duplicates remaining\n";
        echo "Removed " . ($initial_count - $final_count) . " duplicate records\n";
    }

    echo "\n";
}

echo "=== CLEANUP COMPLETE ===\n";
echo "Note: Foreign key references may need to be updated manually if any were broken.\n";

$conn->close();
?>

