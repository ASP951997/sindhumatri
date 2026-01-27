<?php

$backupFile = 'u105084344_matrimony_111.sql';

if (!file_exists($backupFile)) {
    die("Backup file not found: $backupFile\n");
}

$content = file_get_contents($backupFile);

// Search for date_of_birth patterns in the file
$dobPattern = '/\'\d{4}-\d{2}-\d{2}\'/';
preg_match_all($dobPattern, $content, $matches);

echo "=== BACKUP FILE DOB ANALYSIS ===\n\n";
echo "Searching for DOB patterns (YYYY-MM-DD format)...\n\n";

if (!empty($matches[0])) {
    echo "✅ Found " . count($matches[0]) . " DOB entries in backup file\n\n";
    echo "Sample DOB values found:\n";
    $sampleDobs = array_slice($matches[0], 0, 10);
    foreach ($sampleDobs as $dob) {
        echo "- $dob\n";
    }
    echo "\n";
} else {
    echo "❌ No DOB entries found in backup file\n";
}

// Check for NULL DOB values
$nullDobCount = substr_count($content, "'NULL'");
echo "NULL values found: $nullDobCount\n\n";

// Check for empty string DOB values
$emptyDobCount = substr_count($content, "'',");
echo "Empty string DOB values: $emptyDobCount\n\n";

echo "=== CONCLUSION ===\n";
if (!empty($matches[0])) {
    echo "✅ Backup file contains DOB data that can be used for updates\n";
} else {
    echo "❌ Backup file does not contain valid DOB data\n";
}

?>
