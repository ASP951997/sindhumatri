<?php
/**
 * Remove Duplicate Entries Script v2
 * Simplified approach: for each duplicate group, keep min ID and delete others
 */

$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== REMOVING DUPLICATE ENTRIES v2 ===\n\n";

// Disable foreign key checks temporarily
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

$tables_to_clean = [
    'countries' => [
        'name_column' => 'name',
        'referencing_columns' => [
            'users.present_country',
            'users.permanent_country',
            'users.partner_residence_country',
            'users.partner_preferred_country'
        ]
    ],
    'complexion_details' => [
        'name_column' => 'name',
        'referencing_columns' => [
            'users.complexion',
            'users.partner_complexion'
        ]
    ],
    'family_value_details' => [
        'name_column' => 'name',
        'referencing_columns' => [
            'users.family_value',
            'users.partner_family_value'
        ]
    ],
    'body_type_details' => [
        'name_column' => 'name',
        'referencing_columns' => [
            'users.body_type',
            'users.partner_body_type'
        ]
    ]
];

foreach ($tables_to_clean as $table => $config) {
    echo "--- Cleaning $table ---\n";

    $nameColumn = $config['name_column'];

    // Get initial count
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $initial_count = $row['total'];
    echo "Initial count: $initial_count records\n";

    // Find all duplicate groups (names that appear more than once)
    $result = $conn->query("
        SELECT $nameColumn, COUNT(*) as count
        FROM $table
        GROUP BY $nameColumn
        HAVING COUNT(*) > 1
        ORDER BY $nameColumn
    ");

    $duplicate_names = [];
    while ($row = $result->fetch_assoc()) {
        $duplicate_names[] = $row[$nameColumn];
    }

    echo "Found " . count($duplicate_names) . " duplicate groups\n";

    // Process each duplicate group
    foreach ($duplicate_names as $name) {
        // Get all IDs for this name, ordered by ID (keep the smallest)
        $result = $conn->query("
            SELECT id FROM $table
            WHERE $nameColumn = '" . $conn->real_escape_string($name) . "'
            ORDER BY id ASC
        ");

        $ids = [];
        while ($row = $result->fetch_assoc()) {
            $ids[] = $row['id'];
        }

        if (count($ids) > 1) {
            $keep_id = $ids[0]; // Keep the first (smallest ID)
            $duplicate_ids = array_slice($ids, 1); // All others are duplicates
            $duplicate_id_list = implode(',', $duplicate_ids);

            echo "  Processing '$name' - keeping ID $keep_id, removing " . count($duplicate_ids) . " duplicates\n";

            // Update all foreign key references to point to the kept ID
            foreach ($config['referencing_columns'] as $ref_column) {
                list($ref_table, $ref_col) = explode('.', $ref_column);
                $conn->query("
                    UPDATE $ref_table
                    SET $ref_col = $keep_id
                    WHERE $ref_col IN ($duplicate_id_list)
                ");
                $affected = $conn->affected_rows;
                if ($affected > 0) {
                    echo "    Updated $affected records in $ref_table.$ref_col\n";
                }
            }

            // Delete duplicate records
            $conn->query("DELETE FROM $table WHERE id IN ($duplicate_id_list)");
            $deleted = $conn->affected_rows;
            echo "    Deleted $deleted duplicate records\n";
        }
    }

    // Get final count
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    $final_count = $row['total'];
    echo "Final count: $final_count records (removed " . ($initial_count - $final_count) . " duplicates)\n";

    // Verify no duplicates remain
    $result = $conn->query("
        SELECT $nameColumn, COUNT(*) as count
        FROM $table
        GROUP BY $nameColumn
        HAVING COUNT(*) > 1
    ");

    if ($result->num_rows > 0) {
        echo "  ❌ Still has " . $result->num_rows . " duplicate groups remaining\n";
    } else {
        echo "  ✅ No duplicates remaining\n";
    }

    echo "\n";
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "=== CLEANUP COMPLETE ===\n";

$conn->close();
?>

