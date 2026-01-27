<?php
/**
 * Simple Database Import Script
 * Imports local_backup_20260120_065131.sql using mysqli
 * Handles large SQL files by processing statements individually
 */

// Database credentials from .env file
$dbHost = '127.0.0.1';
$dbPort = 3306;
$dbName = 'u105084344_matrimony';
$dbUser = 'u105084344_matrimony';
$dbPass = 'Spmo@111';

echo "=== DATABASE BACKUP IMPORT ===\n\n";
echo "Database: $dbName\n";
echo "Host: $dbHost:$dbPort\n\n";

// SQL file to import
$sqlFile = __DIR__ . '/local_backup_20260120_065131.sql';

if (!file_exists($sqlFile)) {
    die("❌ Error: SQL file not found: $sqlFile\n");
}

echo "📁 SQL File: $sqlFile\n";
echo "📏 File Size: " . number_format(filesize($sqlFile)) . " bytes\n\n";

// Connect to database
$conn = @new mysqli($dbHost, $dbUser, $dbPass);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error . "\n");
}

echo "✅ Connected to MySQL server\n";

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "✅ Database '$dbName' is ready\n";

// Select database
$conn->select_db($dbName);
echo "✅ Selected database '$dbName'\n\n";

// Read SQL file
echo "📖 Reading SQL file...\n";
$sql = file_get_contents($sqlFile);

if ($sql === false) {
    die("❌ Error: Could not read SQL file\n");
}

// Remove BOM if present
$sql = preg_replace('/^\xEF\xBB\xBF/', '', $sql);

echo "✅ SQL file loaded\n\n";

// Disable foreign key checks
echo "🔓 Disabling foreign key checks...\n";
$conn->query("SET FOREIGN_KEY_CHECKS = 0");
$conn->query("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");
$conn->query("SET NAMES utf8mb4");
$conn->query("SET AUTOCOMMIT = 0");

// Split SQL into statements and execute one by one
echo "🔄 Processing SQL statements...\n\n";

// Remove comments and split by semicolons
$statements = [];
$currentStatement = '';
$inString = false;
$stringChar = '';
$escaped = false;

$lines = explode("\n", $sql);
$totalLines = count($lines);

foreach ($lines as $lineNum => $line) {
    // Progress indicator every 1000 lines
    if (($lineNum + 1) % 1000 == 0) {
        echo "   Processing line " . number_format($lineNum + 1) . "/" . number_format($totalLines) . "...\n";
    }
    
    // Skip comment lines
    $trimmedLine = trim($line);
    if (empty($trimmedLine) || preg_match('/^--/', $trimmedLine) || preg_match('/^\/\*/', $trimmedLine)) {
        continue;
    }
    
    $len = strlen($line);
    
    for ($i = 0; $i < $len; $i++) {
        $char = $line[$i];
        
        if ($escaped) {
            $escaped = false;
            $currentStatement .= $char;
            continue;
        }
        
        if ($char === '\\') {
            $escaped = true;
            $currentStatement .= $char;
            continue;
        }
        
        if (($char === '"' || $char === "'") && !$inString) {
            $inString = true;
            $stringChar = $char;
            $currentStatement .= $char;
        } elseif ($char === $stringChar && $inString) {
            $inString = false;
            $stringChar = '';
            $currentStatement .= $char;
        } elseif ($char === ';' && !$inString) {
            $currentStatement .= $char;
            $trimmed = trim($currentStatement);
            if (!empty($trimmed)) {
                // Skip transaction and SET commands (we handle them separately)
                if (!preg_match('/^(START TRANSACTION|COMMIT|ROLLBACK|SET \w+ =)/i', $trimmed)) {
                    $statements[] = $trimmed;
                }
            }
            $currentStatement = '';
        } else {
            $currentStatement .= $char;
        }
    }
    
    // Add newline to preserve statement structure
    if (!empty($currentStatement)) {
        $currentStatement .= "\n";
    }
}

$totalStatements = count($statements);
echo "\n✅ Parsed $totalStatements SQL statements\n";
echo "🚀 Executing statements...\n\n";

// Execute statements
$successCount = 0;
$errorCount = 0;
$errors = [];

foreach ($statements as $index => $statement) {
    $statement = trim($statement);
    
    if (empty($statement)) {
        continue;
    }
    
    try {
        if ($conn->query($statement)) {
            $successCount++;
        } else {
            $errorCount++;
            $errorMsg = $conn->error;
            $errors[] = "Statement " . ($index + 1) . ": " . substr($errorMsg, 0, 150);
            
            // Continue with other statements
            if ($errorCount <= 10) {
                echo "   ⚠️  Warning at statement " . ($index + 1) . ": " . substr($errorMsg, 0, 100) . "\n";
            }
        }
    } catch (Exception $e) {
        $errorCount++;
        $errorMsg = $e->getMessage();
        $errors[] = "Statement " . ($index + 1) . ": " . substr($errorMsg, 0, 150);
    }
    
    // Progress indicator every 100 statements
    if (($index + 1) % 100 == 0) {
        echo "   Progress: " . number_format($index + 1) . "/" . number_format($totalStatements) . " statements...\n";
    }
}

// Commit transaction
echo "\n💾 Committing transaction...\n";
$conn->query("COMMIT");

// Re-enable foreign key checks
echo "🔒 Re-enabling foreign key checks...\n";
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
$conn->query("SET AUTOCOMMIT = 1");

echo "\n=== IMPORT SUMMARY ===\n";
echo "✅ Successful: $successCount statements\n";
echo "⚠️  Errors: $errorCount statements\n\n";

if ($errorCount > 0 && count($errors) > 0) {
    echo "First few errors:\n";
    foreach (array_slice($errors, 0, 5) as $error) {
        echo "  - $error\n";
    }
    if (count($errors) > 5) {
        echo "  ... and " . (count($errors) - 5) . " more errors\n";
    }
}

// Verify tables were created
echo "\n📊 Verifying database...\n";
$result = $conn->query("SHOW TABLES");
$tables = [];

if ($result) {
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }
    echo "✅ Found " . count($tables) . " tables in database\n";
    
    if (in_array('languages', $tables)) {
        $result = $conn->query("SELECT COUNT(*) FROM languages");
        if ($result) {
            $row = $result->fetch_array();
            echo "✅ Languages table exists with " . $row[0] . " records\n";
        }
    } else {
        echo "⚠️  Languages table not found\n";
    }
    
    if (in_array('users', $tables)) {
        $result = $conn->query("SELECT COUNT(*) FROM users");
        if ($result) {
            $row = $result->fetch_array();
            echo "✅ Users table exists with " . $row[0] . " records\n";
        }
    }
    
    if (in_array('admins', $tables)) {
        $result = $conn->query("SELECT COUNT(*) FROM admins");
        if ($result) {
            $row = $result->fetch_array();
            echo "✅ Admins table exists with " . $row[0] . " records\n";
        }
    }
}

$conn->close();
echo "\n✅ Database import completed successfully!\n";
?>
