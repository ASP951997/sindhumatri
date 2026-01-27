<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u105084344_matrimony_123', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "=== ADMINS TABLE STRUCTURE ===\n\n";

    $result = $pdo->query('DESCRIBE admins');
    echo "Column Name\t\tType\t\t\tNull\tKey\tDefault\n";
    echo "---------------------------------------------------------------\n";

    while ($row = $result->fetch()) {
        $field = $row['Field'];
        $type = $row['Type'];
        $null = $row['Null'];
        $key = $row['Key'] ?: '';
        $default = $row['Default'] ?: 'NULL';

        echo sprintf("%-20s %-20s %-8s %-8s %s\n", $field, $type, $null, $key, $default);
    }

    echo "\n=== SPMO ADMIN RECORD ===\n\n";
    $result = $pdo->query("SELECT * FROM admins WHERE username = 'SPMO'");
    $admin = $result->fetch();

    if ($admin) {
        foreach ($admin as $key => $value) {
            echo sprintf("%-20s: %s\n", $key, $value ?? 'NULL');
        }
    }

} catch (Exception $e) {
    echo 'Database error: ' . $e->getMessage() . "\n";
}
?>












