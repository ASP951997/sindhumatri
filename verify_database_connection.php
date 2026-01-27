<?php
// verify_database_connection.php - Check which database Laravel is using

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "🔍 LARAVEL DATABASE CONNECTION VERIFICATION<br><br>";

    // Check current database connection
    $pdo = DB::getPdo();
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    $currentDb = $result['current_db'];

    echo "📊 Laravel is connected to database: <strong>$currentDb</strong><br><br>";

    // Check if funds table exists in Laravel's database
    echo "🔍 Checking funds table in Laravel database:<br>";
    $fundsExists = DB::select("SHOW TABLES LIKE 'funds'");

    if (!empty($fundsExists)) {
        echo "✅ Funds table EXISTS in Laravel database<br>";

        // Check funds table structure
        $columns = DB::select("DESCRIBE funds");
        echo "📋 Funds table columns: " . count($columns) . "<br>";

        // Check if there are any records
        $fundsCount = DB::table('funds')->count();
        echo "📊 Funds table records: $fundsCount<br><br>";
    } else {
        echo "❌ Funds table does NOT exist in Laravel database<br><br>";
    }

    // Test the problematic query
    echo "🧪 Testing the problematic query:<br>";
    try {
        $result = DB::select("select SUM(CASE WHEN status = 1 THEN amount END) AS totalAmountReceived, SUM(CASE WHEN status = 1 THEN charge END) AS totalChargeReceived, SUM((CASE WHEN created_at >= CURDATE() AND status = 1 THEN amount END)) AS todayPayment, SUM((CASE WHEN created_at >= DATE_SUB(CURRENT_DATE() , INTERVAL DAYOFMONTH(CURRENT_DATE)-1 DAY) THEN amount END)) AS thisMonthPayment from `funds`");

        echo "✅ Query executed successfully!<br>";
        echo "📈 Results: " . count($result) . " rows<br><br>";
    } catch (Exception $e) {
        echo "❌ Query failed: " . $e->getMessage() . "<br><br>";
    }

    // Show database configuration
    echo "⚙️  Database Configuration:<br>";
    echo "Host: " . config('database.connections.mysql.host') . "<br>";
    echo "Port: " . config('database.connections.mysql.port') . "<br>";
    echo "Database: " . config('database.connections.mysql.database') . "<br>";
    echo "Username: " . config('database.connections.mysql.username') . "<br><br>";

    echo "🎯 POSSIBLE ISSUES:<br>";
    echo "1. Laravel is connecting to different database than phpMyAdmin<br>";
    echo "2. Database name mismatch (check .env file)<br>";
    echo "3. Table exists but has wrong structure<br>";
    echo "4. Caching issue (run: php artisan config:clear)<br><br>";

    echo "🔧 RECOMMENDED FIXES:<br>";
    echo "1. Check your .env file DATABASE settings<br>";
    echo "2. Clear Laravel cache: php artisan config:clear<br>";
    echo "3. Verify .env points to correct database<br>";
    echo "4. Check if database name matches phpMyAdmin<br><br>";

    // Check .env file if it exists
    if (file_exists('.env')) {
        echo "📄 .env file exists - check DATABASE settings<br>";
    } else {
        echo "⚠️  .env file not found - check file permissions<br>";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "<br>";
    echo 'This suggests a database connection problem.<br>';
}
?>




