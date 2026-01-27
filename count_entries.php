<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== DATABASE ENTRIES COUNT ===\n\n";

    // Get all tables
    $result = $pdo->query('SHOW TABLES');
    $tables = [];
    while ($row = $result->fetch()) {
        $tables[] = $row[0];
    }

    echo 'Total tables in database: ' . count($tables) . "\n\n";

    $totalRecords = 0;
    $tablesWithData = 0;

    echo "TABLE RECORDS COUNT:\n";
    echo str_repeat("-", 40) . "\n";

    foreach ($tables as $table) {
        try {
            $countResult = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
            $count = $countResult->fetch()['count'];
            $totalRecords += $count;

            if ($count > 0) {
                $tablesWithData++;
                printf("%-30s: %d records\n", $table, $count);
            } else {
                printf("%-30s: %d records\n", $table, $count);
            }
        } catch (Exception $e) {
            printf("%-30s: Error - %s\n", $table, substr($e->getMessage(), 0, 50));
        }
    }

    echo str_repeat("-", 40) . "\n";
    echo "SUMMARY:\n";
    echo "Total tables: " . count($tables) . "\n";
    echo "Tables with data: " . $tablesWithData . "\n";
    echo "Total records across all tables: " . $totalRecords . "\n\n";

    // Show details for key tables
    $keyTables = ['users', 'templates', 'template_media', 'languages'];
    echo "KEY TABLES DETAILS:\n";
    echo str_repeat("-", 40) . "\n";

    foreach ($keyTables as $table) {
        if (in_array($table, $tables)) {
            try {
                $countResult = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
                $count = $countResult->fetch()['count'];

                echo "$table ($count records):\n";

                if ($table === 'users' && $count > 0) {
                    $result = $pdo->query("SELECT id, firstname, lastname, username FROM `$table` LIMIT 5");
                    while ($row = $result->fetch()) {
                        echo "  - ID {$row['id']}: {$row['firstname']} {$row['lastname']} ({$row['username']})\n";
                    }
                    if ($count > 5) {
                        echo "  ... and " . ($count - 5) . " more users\n";
                    }
                } elseif ($table === 'languages' && $count > 0) {
                    $result = $pdo->query("SELECT id, name, short_name FROM `$table`");
                    while ($row = $result->fetch()) {
                        echo "  - ID {$row['id']}: {$row['name']} ({$row['short_name']})\n";
                    }
                } elseif ($table === 'templates' && $count > 0) {
                    $result = $pdo->query("SELECT section_name, COUNT(*) as count FROM `$table` GROUP BY section_name");
                    while ($row = $result->fetch()) {
                        echo "  - {$row['section_name']}: {$row['count']} templates\n";
                    }
                }

                echo "\n";
            } catch (Exception $e) {
                echo "  Error reading $table: " . $e->getMessage() . "\n\n";
            }
        } else {
            echo "$table: Table does not exist\n\n";
        }
    }

} catch (Exception $e) {
    echo 'Database connection error: ' . $e->getMessage() . "\n";
}
