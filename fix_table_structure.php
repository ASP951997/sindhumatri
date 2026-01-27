<?php
/**
 * Fix Table Structure and Remove Duplicates
 */

$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== FIXING TABLE STRUCTURE AND REMOVING DUPLICATES ===\n\n";

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

    // Check current structure
    $result = $conn->query("DESCRIBE $table");
    $has_primary_key = false;
    while ($row = $result->fetch_assoc()) {
        if ($row['Key'] == 'PRI') {
            $has_primary_key = true;
            break;
        }
    }

    if (!$has_primary_key) {
        echo "No primary key found, adding auto-increment primary key...\n";

        // Add auto-increment primary key
        $conn->query("ALTER TABLE $table ADD COLUMN new_id INT AUTO_INCREMENT PRIMARY KEY FIRST");

        // Create new table with proper structure
        $temp_table = $table . '_fixed';
        $conn->query("CREATE TABLE $temp_table LIKE $table");
        $conn->query("ALTER TABLE $temp_table DROP COLUMN new_id");

        // Get unique records only
        $result = $conn->query("SELECT DISTINCT * FROM $table ORDER BY $name_column, id");
        $unique_records = [];
        $seen_names = [];

        while ($row = $result->fetch_assoc()) {
            if (!in_array($row[$name_column], $seen_names)) {
                $unique_records[] = $row;
                $seen_names[] = $row[$name_column];
            }
        }

        echo "Found " . count($unique_records) . " unique records\n";

        // Insert unique records
        foreach ($unique_records as $record) {
            $columns = array_keys($record);
            $values = array_map(function($val) use ($conn) {
                return "'" . $conn->real_escape_string($val) . "'";
            }, array_values($record));

            $sql = "INSERT INTO $temp_table (" . implode(',', $columns) . ") VALUES (" . implode(',', $values) . ")";
            $conn->query($sql);
        }

        // Replace original table
        $conn->query("DROP TABLE $table");
        $conn->query("RENAME TABLE $temp_table TO $table");

        // Add proper primary key to new table
        $conn->query("ALTER TABLE $table ADD PRIMARY KEY (id)");
        $conn->query("ALTER TABLE $table MODIFY COLUMN id INT AUTO_INCREMENT");

    } else {
        echo "Table already has primary key, removing duplicates...\n";

        // For tables that already have primary key, just remove duplicates by name
        $temp_table = $table . '_temp';
        $conn->query("CREATE TABLE $temp_table AS SELECT * FROM $table WHERE id IN (SELECT MIN(id) FROM $table GROUP BY $name_column)");

        $result = $conn->query("SELECT COUNT(*) as total FROM $temp_table");
        $row = $result->fetch_assoc();
        $unique_count = $row['total'];

        $conn->query("TRUNCATE TABLE $table");
        $conn->query("INSERT INTO $table SELECT * FROM $temp_table");
        $conn->query("DROP TABLE $temp_table");

        echo "Kept $unique_count unique records\n";
    }

    // Verify final result
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $final_count = $row['total'];
    echo "Final count: $final_count records\n";

    // Check for duplicates
    $result = $conn->query("SELECT $name_column, COUNT(*) as count FROM $table GROUP BY $name_column HAVING COUNT(*) > 1");
    if ($result->num_rows > 0) {
        echo "❌ Still has " . $result->num_rows . " duplicate groups\n";
    } else {
        echo "✅ No duplicates remaining\n";
        echo "Removed " . ($initial_count - $final_count) . " duplicate records\n";
    }

    echo "\n";
}

echo "=== STRUCTURE FIX COMPLETE ===\n";

$conn->close();
?>

