<?php
/**
 * Simple Duplicate Removal
 * For tables without proper primary keys
 */

$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== SIMPLE DUPLICATE REMOVAL ===\n\n";

$tables_to_fix = [
    'countries' => 'name',
    'complexion_details' => 'name',
    'family_value_details' => 'name',
    'body_type_details' => 'name'
];

foreach ($tables_to_fix as $table => $name_column) {
    echo "--- Fixing $table ---\n";

    // Get initial count
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $initial_count = $row['total'];
    echo "Initial count: $initial_count records\n";

    // Create backup table
    $backup_table = $table . '_backup_' . time();
    $conn->query("CREATE TABLE $backup_table AS SELECT * FROM $table");
    echo "Created backup: $backup_table\n";

    // Clear original table
    $conn->query("TRUNCATE TABLE $table");

    // Insert unique records only (group by name, take first record for each group)
    $conn->query("
        INSERT INTO $table
        SELECT * FROM $backup_table
        GROUP BY $name_column
    ");

    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $final_count = $row['total'];
    echo "Final count: $final_count records\n";
    echo "Removed " . ($initial_count - $final_count) . " duplicates\n";

    // Verify no duplicates
    $result = $conn->query("SELECT $name_column, COUNT(*) as count FROM $table GROUP BY $name_column HAVING COUNT(*) > 1");
    if ($result->num_rows > 0) {
        echo "❌ Still has duplicates\n";
    } else {
        echo "✅ No duplicates remaining\n";
    }

    // Optional: drop backup table after verification
    // $conn->query("DROP TABLE $backup_table");

    echo "\n";
}

echo "=== REMOVAL COMPLETE ===\n";
echo "Note: Backup tables created with timestamp suffix if you need to restore\n";

$conn->close();
?>

