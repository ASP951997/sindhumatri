<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $tables = DB::select('SHOW TABLES');
    $output = "-- Database Export from u105084344_matrimony_1\n";
    $output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
    $output .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
    $output .= "START TRANSACTION;\n\n";

    foreach ($tables as $table) {
        $tableName = current($table);
        $output .= "-- Table: $tableName\n";

        // Get CREATE TABLE
        $createTable = DB::select("SHOW CREATE TABLE $tableName")[0];
        $output .= $createTable->{'Create Table'} . ";\n\n";

        // Get data
        $data = DB::table($tableName)->get();
        if ($data->count() > 0) {
            $columns = array_keys((array)$data[0]);
            $output .= "INSERT INTO $tableName (" . implode(', ', $columns) . ") VALUES\n";

            $values = [];
            foreach ($data as $row) {
                $rowData = [];
                foreach ($columns as $col) {
                    $val = $row->$col;
                    if (is_null($val)) {
                        $rowData[] = 'NULL';
                    } elseif (is_numeric($val)) {
                        $rowData[] = $val;
                    } else {
                        $rowData[] = "'" . addslashes($val) . "'";
                    }
                }
                $values[] = '(' . implode(', ', $rowData) . ')';
            }
            $output .= implode(",\n", $values) . ";\n\n";
        }
    }

    $output .= "COMMIT;\n";
    $filename = 'local_backup_' . date('Ymd_His') . '.sql';
    file_put_contents($filename, $output);
    echo "✅ Database exported successfully!\n";
    echo "📁 File: $filename\n";
    echo "📊 Size: " . filesize($filename) . " bytes\n";

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>




