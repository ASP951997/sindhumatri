<?php
$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check foreign key constraints for tables we want to clean
$tables_to_check = ['countries', 'complexion_details', 'family_value_details', 'body_type_details'];

echo "=== FOREIGN KEY CONSTRAINTS ANALYSIS ===\n\n";

foreach ($tables_to_check as $table) {
    echo "--- $table ---\n";

    // Check if table exists
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows == 0) {
        echo "Table $table does not exist\n\n";
        continue;
    }

    // Get foreign key constraints
    $result = $conn->query("
        SELECT
            TABLE_NAME,
            COLUMN_NAME,
            CONSTRAINT_NAME,
            REFERENCED_TABLE_NAME,
            REFERENCED_COLUMN_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE REFERENCED_TABLE_SCHEMA = 'u105084344_matrimony'
        AND REFERENCED_TABLE_NAME = '$table'
        AND REFERENCED_COLUMN_NAME IS NOT NULL
    ");

    if ($result->num_rows > 0) {
        echo "Foreign key constraints:\n";
        while ($row = $result->fetch_assoc()) {
            echo "  - {$row['TABLE_NAME']}.{$row['COLUMN_NAME']} -> $table.{$row['REFERENCED_COLUMN_NAME']}\n";
        }
    } else {
        echo "No foreign key constraints found\n";
    }

    // Check how many records reference this table
    $referencing_tables = [];
    $result = $conn->query("
        SELECT DISTINCT TABLE_NAME, COLUMN_NAME
        FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
        WHERE REFERENCED_TABLE_SCHEMA = 'u105084344_matrimony'
        AND REFERENCED_TABLE_NAME = '$table'
    ");

    while ($row = $result->fetch_assoc()) {
        $referencing_tables[] = $row['TABLE_NAME'];
    }

    if (!empty($referencing_tables)) {
        echo "Tables that reference $table: " . implode(', ', $referencing_tables) . "\n";
    }

    echo "\n";
}

$conn->close();
?>

