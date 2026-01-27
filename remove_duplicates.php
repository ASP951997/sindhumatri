<?php
/**
 * Remove Duplicate Entries Script
 * This script removes duplicate entries from dropdown tables while preserving foreign key references
 */

$conn = new mysqli('127.0.0.1', 'u105084344_matrimony', 'Spmo@111', 'u105084344_matrimony');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

echo "=== REMOVING DUPLICATE ENTRIES ===\n\n";

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

    // Get all unique names and their min IDs (keep the first occurrence)
    $result = $conn->query("
        SELECT $nameColumn, MIN(id) as keep_id
        FROM $table
        GROUP BY $nameColumn
        ORDER BY $nameColumn
    ");

    $unique_entries = [];
    while ($row = $result->fetch_assoc()) {
        $unique_entries[$row[$nameColumn]] = $row['keep_id'];
    }

    echo "Found " . count($unique_entries) . " unique entries\n";

    // For each unique entry, update all references to use the keep_id
    foreach ($unique_entries as $name => $keep_id) {
        // Get all IDs for this name (excluding the keep_id)
        $result = $conn->query("
            SELECT id FROM $table
            WHERE $nameColumn = '" . $conn->real_escape_string($name) . "'
            AND id != $keep_id
        ");

        $duplicate_ids = [];
        while ($row = $result->fetch_assoc()) {
            $duplicate_ids[] = $row['id'];
        }

        if (!empty($duplicate_ids)) {
            $duplicate_id_list = implode(',', $duplicate_ids);

            // Update all foreign key references
            foreach ($config['referencing_columns'] as $ref_column) {
                list($ref_table, $ref_col) = explode('.', $ref_column);
                $conn->query("
                    UPDATE $ref_table
                    SET $ref_col = $keep_id
                    WHERE $ref_col IN ($duplicate_id_list)
                ");
                $affected = $conn->affected_rows;
                if ($affected > 0) {
                    echo "  Updated $affected records in $ref_table.$ref_col\n";
                }
            }

            // Delete duplicate records
            $conn->query("DELETE FROM $table WHERE id IN ($duplicate_id_list)");
            $deleted = $conn->affected_rows;
            echo "  Deleted $deleted duplicate records for '$name'\n";
        }
    }

    // Verify cleanup
    $result = $conn->query("SELECT COUNT(*) as total FROM $table");
    $row = $result->fetch_assoc();
    echo "  Final count: {$row['total']} records\n";

    // Check for remaining duplicates
    $result = $conn->query("
        SELECT $nameColumn, COUNT(*) as count
        FROM $table
        GROUP BY $nameColumn
        HAVING COUNT(*) > 1
    ");

    if ($result->num_rows > 0) {
        echo "  ⚠️  Still has duplicates:\n";
        while ($row = $result->fetch_assoc()) {
            echo "    - '{$row[$nameColumn]}' appears {$row['count']} times\n";
        }
    } else {
        echo "  ✅ No duplicates remaining\n";
    }

    echo "\n";
}

// Re-enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");

echo "=== CLEANUP COMPLETE ===\n";
echo "All duplicate entries have been removed and foreign key references updated.\n";

$conn->close();
?>

