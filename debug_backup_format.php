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
            echo "Complete INSERT statement (first 500 chars):\n";
            echo substr($userInsertData, 0, 500) . "...\n\n";
            break;
        }
    }
}

echo "=== ANALYSIS ===\n";
echo "Pattern used in script: '/INSERT INTO `users` VALUES([^;]+);/'\n";
echo "This should work if the format matches.\n";

?>
