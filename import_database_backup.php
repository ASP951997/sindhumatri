<?php
/**
 * Import Database Backup Script
 * This script imports the local_backup_20260120_065131.sql file into the database
 * using credentials from .env file
 */

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env file
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get database credentials from .env
$dbHost = $_ENV['DB_HOST'] ?? '127.0.0.1';
$dbPort = $_ENV['DB_PORT'] ?? '3306';
$dbName = $_ENV['DB_DATABASE'] ?? 'u105084344_matrimony';
$dbUser = $_ENV['DB_USERNAME'] ?? 'u105084344_matrimony';
$dbPass = $_ENV['DB_PASSWORD'] ?? 'Spmo@111';

echo "=== DATABASE BACKUP IMPORT ===\n\n";
echo "Database: $dbName\n";
echo "Host: $dbHost:$dbPort\n";
echo "User: $dbUser\n\n";

// SQL file to import
$sqlFile = __DIR__ . '/local_backup_20260120_065131.sql';

if (!file_exists($sqlFile)) {
    die("❌ Error: SQL file not found: $sqlFile\n");
}

echo "📁 SQL File: $sqlFile\n";
echo "📏 File Size: " . number_format(filesize($sqlFile)) . " bytes\n\n";

// Connect to database
try {
    $pdo = new PDO(
        "mysql:host=$dbHost;port=$dbPort;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 300,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        ]
    );
    echo "✅ Connected to MySQL server\n\n";
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage() . "\n");
}

// Create database if it doesn't exist
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "✅ Database '$dbName' is ready\n\n";
} catch (PDOException $e) {
    die("❌ Failed to create/check database: " . $e->getMessage() . "\n");
}

// Select database
try {
    $pdo->exec("USE `$dbName`");
    echo "✅ Selected database '$dbName'\n\n";
} catch (PDOException $e) {
    die("❌ Failed to select database: " . $e->getMessage() . "\n");
}

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
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO'");
$pdo->exec("SET AUTOCOMMIT = 0");
$pdo->exec("START TRANSACTION");

// Split SQL into individual statements
echo "🔄 Processing SQL statements...\n";

// Split by semicolons, but preserve those in quotes
$statements = [];
$currentStatement = '';
$inString = false;
$stringChar = '';
$escaped = false;

$lines = explode("\n", $sql);
$totalLines = count($lines);
$processedLines = 0;

foreach ($lines as $lineNum => $line) {
    $processedLines++;
    
    // Progress indicator every 1000 lines
    if ($processedLines % 1000 == 0) {
        echo "   Progress: " . number_format($processedLines) . "/" . number_format($totalLines) . " lines...\n";
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
            if (!empty($trimmed) && 
                !preg_match('/^--/', $trimmed) && 
                !preg_match('/^\/\*/', $trimmed) &&
                strpos(strtoupper($trimmed), 'SET ') !== 0) {
                $statements[] = $trimmed;
            }
            $currentStatement = '';
        } else {
            $currentStatement .= $char;
        }
    }
    
    $currentStatement .= "\n";
}

// Execute statements in batches
$totalStatements = count($statements);
echo "\n✅ Parsed $totalStatements SQL statements\n";
echo "🚀 Executing statements...\n\n";

$successCount = 0;
$errorCount = 0;
$errors = [];

foreach ($statements as $index => $statement) {
    $statement = trim($statement);
    
    if (empty($statement) || preg_match('/^(--|\/\*)/', $statement)) {
        continue;
    }
    
    // Skip transaction commands as we handle them manually
    if (preg_match('/^(START TRANSACTION|COMMIT|ROLLBACK|SET)/i', $statement)) {
        continue;
    }
    
    try {
        $pdo->exec($statement);
        $successCount++;
        
        // Progress indicator every 100 statements
        if (($index + 1) % 100 == 0) {
            echo "   Progress: " . number_format($index + 1) . "/" . number_format($totalStatements) . " statements...\n";
        }
    } catch (PDOException $e) {
        $errorCount++;
        $errorMsg = substr($e->getMessage(), 0, 200);
        $errors[] = "Statement " . ($index + 1) . ": " . $errorMsg;
        
        // Continue with other statements
        if ($errorCount <= 10) {
            echo "   ⚠️  Warning at statement " . ($index + 1) . ": " . $errorMsg . "\n";
        }
    }
}

// Commit transaction
echo "\n💾 Committing transaction...\n";
$pdo->exec("COMMIT");

// Re-enable foreign key checks
echo "🔒 Re-enabling foreign key checks...\n";
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
$pdo->exec("SET AUTOCOMMIT = 1");

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
try {
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "✅ Found " . count($tables) . " tables in database\n";
    
    if (in_array('languages', $tables)) {
        $langCount = $pdo->query("SELECT COUNT(*) FROM languages")->fetchColumn();
        echo "✅ Languages table exists with $langCount records\n";
    } else {
        echo "⚠️  Languages table not found\n";
    }
    
    if (in_array('users', $tables)) {
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo "✅ Users table exists with $userCount records\n";
    }
    
    if (in_array('admins', $tables)) {
        $adminCount = $pdo->query("SELECT COUNT(*) FROM admins")->fetchColumn();
        echo "✅ Admins table exists with $adminCount records\n";
    }
    
} catch (PDOException $e) {
    echo "⚠️  Could not verify tables: " . $e->getMessage() . "\n";
}

echo "\n✅ Database import completed!\n";
?>

