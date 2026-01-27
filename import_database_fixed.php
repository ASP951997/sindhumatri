<?php
/**
 * Fixed Database Import Script
 * Properly handles large multi-line SQL statements
 */

// Database credentials
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

// Set connection options (only if constants are available)
if (defined('MYSQLI_OPT_CONNECT_TIMEOUT')) {
    $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 300);
}
if (defined('MYSQLI_OPT_READ_TIMEOUT')) {
    $conn->options(MYSQLI_OPT_READ_TIMEOUT, 300);
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

// Better SQL parsing that handles multi-line statements
echo "🔄 Processing SQL statements...\n\n";

// Remove comments and split properly
$sql = preg_replace('/--.*$/m', '', $sql); // Remove single-line comments
$sql = preg_replace('/\/\*.*?\*\//s', '', $sql); // Remove multi-line comments

// Split by semicolon but respect strings
$statements = [];
$currentStatement = '';
$inSingleQuote = false;
$inDoubleQuote = false;
$escaped = false;

$len = strlen($sql);
$lineCount = substr_count($sql, "\n");

for ($i = 0; $i < $len; $i++) {
    $char = $sql[$i];
    
    // Progress indicator every 100k characters
    if ($i % 100000 == 0 && $i > 0) {
        $progress = round(($i / $len) * 100, 1);
        echo "   Processing: " . $progress . "%...\n";
    }
    
    // Handle escape characters
    if ($escaped) {
        $currentStatement .= $char;
        $escaped = false;
        continue;
    }
    
    if ($char === '\\') {
        $currentStatement .= $char;
        $escaped = true;
        continue;
    }
    
    // Handle string literals
    if ($char === "'" && !$inDoubleQuote) {
        $inSingleQuote = !$inSingleQuote;
        $currentStatement .= $char;
        continue;
    }
    
    if ($char === '"' && !$inSingleQuote) {
        $inDoubleQuote = !$inDoubleQuote;
        $currentStatement .= $char;
        continue;
    }
    
    // Split on semicolon (end of statement) when not in a string
    if ($char === ';' && !$inSingleQuote && !$inDoubleQuote) {
        $currentStatement .= $char;
        $trimmed = trim($currentStatement);
        
        // Only add non-empty statements that aren't transaction commands
        if (!empty($trimmed) && 
            !preg_match('/^(START TRANSACTION|COMMIT|ROLLBACK|SET \w+ =)/i', $trimmed) &&
            !preg_match('/^SET SQL_MODE/i', $trimmed)) {
            $statements[] = $trimmed;
        }
        
        $currentStatement = '';
        continue;
    }
    
    $currentStatement .= $char;
}

// Add any remaining statement
if (!empty(trim($currentStatement))) {
    $statements[] = trim($currentStatement);
}

$totalStatements = count($statements);
echo "\n✅ Parsed $totalStatements SQL statements\n";
echo "🚀 Executing statements...\n\n";

// Execute statements with batch commits
$successCount = 0;
$errorCount = 0;
$errors = [];
$batchSize = 50; // Commit every 50 statements
$batchCount = 0;

foreach ($statements as $index => $statement) {
    $statement = trim($statement);
    
    if (empty($statement)) {
        continue;
    }
    
    try {
        if ($conn->query($statement)) {
            $successCount++;
            $batchCount++;
            
            // Commit in batches to avoid timeout
            if ($batchCount >= $batchSize) {
                $conn->query("COMMIT");
                $conn->query("START TRANSACTION");
                $batchCount = 0;
            }
        } else {
            $errorCount++;
            $errorMsg = $conn->error;
            
            // Only track first 20 errors
            if (count($errors) < 20) {
                $errors[] = "Statement " . ($index + 1) . ": " . substr($errorMsg, 0, 150);
            }
            
            // Continue with other statements
            if ($errorCount <= 10) {
                echo "   ⚠️  Warning at statement " . ($index + 1) . ": " . substr($errorMsg, 0, 100) . "\n";
            }
        }
    } catch (Exception $e) {
        $errorCount++;
        $errorMsg = $e->getMessage();
        
        // Check if connection was lost
        if (strpos($errorMsg, 'gone away') !== false || strpos($errorMsg, 'server has gone away') !== false) {
            echo "\n   ⚠️  Connection lost, reconnecting...\n";
            
            // Reconnect
            $conn->close();
            $conn = @new mysqli($dbHost, $dbUser, $dbPass, $dbName);
            if ($conn->connect_error) {
                die("❌ Reconnection failed: " . $conn->connect_error . "\n");
            }
            
            if (defined('MYSQLI_OPT_CONNECT_TIMEOUT')) {
                $conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 300);
            }
            if (defined('MYSQLI_OPT_READ_TIMEOUT')) {
                $conn->options(MYSQLI_OPT_READ_TIMEOUT, 300);
            }
            
            $conn->query("SET FOREIGN_KEY_CHECKS = 0");
            $conn->query("SET AUTOCOMMIT = 0");
            $conn->query("START TRANSACTION");
            
            echo "   ✅ Reconnected, continuing...\n";
        }
        
        // Only track first 20 errors
        if (count($errors) < 20) {
            $errors[] = "Statement " . ($index + 1) . ": " . substr($errorMsg, 0, 150);
        }
    }
    
    // Progress indicator every 100 statements
    if (($index + 1) % 100 == 0) {
        echo "   Progress: " . number_format($index + 1) . "/" . number_format($totalStatements) . " statements...\n";
    }
}

// Final commit
if ($batchCount > 0) {
    echo "\n💾 Committing remaining changes...\n";
    $conn->query("COMMIT");
}

// Re-enable foreign key checks
echo "🔒 Re-enabling foreign key checks...\n";
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
$conn->query("SET AUTOCOMMIT = 1");

echo "\n=== IMPORT SUMMARY ===\n";
echo "✅ Successful: $successCount statements\n";
echo "⚠️  Errors: $errorCount statements\n\n";

if ($errorCount > 0 && count($errors) > 0) {
    echo "First few errors:\n";
    foreach (array_slice($errors, 0, 10) as $error) {
        echo "  - $error\n";
    }
    if (count($errors) > 10) {
        echo "  ... and " . (count($errors) - 10) . " more errors\n";
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
        echo "❌ Languages table NOT found\n";
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

