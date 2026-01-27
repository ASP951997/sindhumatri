<?php

$backupFile = 'u105084344_matrimony_111.sql';

if (!file_exists($backupFile)) {
    die("Backup file not found: $backupFile\n");
}

$content = file_get_contents($backupFile);

// Find INSERT INTO users statements
$lines = explode("\n", $content);
$inUsersInsert = false;
$userInsertData = '';

foreach ($lines as $line) {
    if (strpos($line, 'INSERT INTO `users`') === 0) {
        echo "Found users INSERT statement:\n";
        echo $line . "\n\n";
        $inUsersInsert = true;
        $userInsertData = $line;
    } elseif ($inUsersInsert) {
        $userInsertData .= "\n" . $line;
        if (strpos($line, ';') !== false) {
            // End of INSERT statement
            echo "Complete INSERT statement sample (first 300 chars):\n";
            echo substr($userInsertData, 0, 300) . "...\n\n";

            // Extract first VALUES entry to check DOB position
            $valuesStart = strpos($userInsertData, 'VALUES');
            if ($valuesStart !== false) {
                $valuesPart = substr($userInsertData, $valuesStart + 6); // Skip "VALUES"
                $firstRowEnd = strpos($valuesPart, '),(');
                if ($firstRowEnd === false) {
                    $firstRowEnd = strpos($valuesPart, ');');
                }
                if ($firstRowEnd !== false) {
                    $firstRow = substr($valuesPart, 0, $firstRowEnd);
                    echo "First row data:\n";
                    echo $firstRow . "\n\n";

                    // Parse the first row
                    $fields = str_getcsv(trim($firstRow, '()'));
                    echo "Total fields in row: " . count($fields) . "\n";
                    echo "DOB field (position 19): '" . (isset($fields[19]) ? $fields[19] : 'NOT FOUND') . "'\n";
                    echo "Age field (position 20): '" . (isset($fields[20]) ? $fields[20] : 'NOT FOUND') . "'\n\n";
                }
            }
            break;
        }
    }
}

echo "=== ANALYSIS ===\n";
echo "Column positions (0-indexed):\n";
echo "- ID: 0\n";
echo "- First Name: 1\n";
echo "- Last Name: 2\n";
echo "- Username: 3\n";
echo "- Email: 6\n";
echo "- Date of Birth: 19\n";
echo "- Age: 20\n\n";

?>
