<?php
// debug_laravel_db.php - Debug Laravel database connection and fix issues

echo "<h2>🔍 LARAVEL DATABASE DEBUG & FIX</h2>";

// Check if .env file exists
$envFile = '.env';
if (!file_exists($envFile)) {
    echo "<p style='color: red;'>❌ CRITICAL: .env file not found!</p>";
    echo "<p>You must upload your .env file from the local project.</p>";
    exit;
}

echo "<p style='color: green;'>✅ .env file found</p>";

// Read and display current .env database settings
$envContent = file_get_contents($envFile);

preg_match('/DB_CONNECTION=(.*)/', $envContent, $connection);
preg_match('/DB_HOST=(.*)/', $envContent, $host);
preg_match('/DB_PORT=(.*)/', $envContent, $port);
preg_match('/DB_DATABASE=(.*)/', $envContent, $database);
preg_match('/DB_USERNAME=(.*)/', $envContent, $username);
preg_match('/DB_PASSWORD=(.*)/', $envContent, $password);

$currentDb = trim($database[1] ?? '');
$workingDb = 'u105084344_matrimony';

echo "<h3>📋 Current .env Database Settings:</h3>";
echo "<table border='1' style='border-collapse: collapse;'>";
echo "<tr><td><strong>DB_CONNECTION</strong></td><td>" . trim($connection[1] ?? 'NOT SET') . "</td></tr>";
echo "<tr><td><strong>DB_HOST</strong></td><td>" . trim($host[1] ?? 'NOT SET') . "</td></tr>";
echo "<tr><td><strong>DB_PORT</strong></td><td>" . trim($port[1] ?? 'NOT SET') . "</td></tr>";
echo "<tr><td><strong>DB_DATABASE</strong></td><td><span style='color: " . ($currentDb === $workingDb ? 'green' : 'red') . ";'>$currentDb</span></td></tr>";
echo "<tr><td><strong>DB_USERNAME</strong></td><td>" . trim($username[1] ?? 'NOT SET') . "</td></tr>";
echo "<tr><td><strong>DB_PASSWORD</strong></td><td>" . (!empty($password[1]) ? '***SET***' : '<span style="color: red;">NOT SET</span>') . "</td></tr>";
echo "</table><br>";

if ($currentDb !== $workingDb) {
    echo "<p style='color: red; font-size: 16px;'>❌ DATABASE MISMATCH!</p>";
    echo "<p>Laravel is configured for: <strong>$currentDb</strong></p>";
    echo "<p>But your working database is: <strong>$workingDb</strong></p>";

    echo "<h3>🔄 Fixing .env file...</h3>";

    // Update the database name in .env
    $newEnvContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$workingDb", $envContent);

    if (file_put_contents($envFile, $newEnvContent)) {
        echo "<p style='color: green;'>✅ .env file updated successfully!</p>";
        echo "<p>New database: <strong>$workingDb</strong></p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to update .env file!</p>";
        echo "<p>Check file permissions (should be 644).</p>";
    }
} else {
    echo "<p style='color: green;'>✅ Database name is correct</p>";
}

// Test Laravel database connection
echo "<h3>🧪 Testing Laravel Database Connection:</h3>";

try {
    require 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    use Illuminate\Support\Facades\DB;

    $pdo = DB::getPdo();
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    $laravelDb = $result['current_db'];

    echo "<p style='color: green;'>✅ Laravel connected to: <strong>$laravelDb</strong></p>";

    // Test essential tables
    $essentialTables = ['admins', 'users', 'languages', 'funds'];
    echo "<h4>📊 Table Status:</h4>";

    foreach ($essentialTables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "<p>✅ $table: $count records</p>";
        } catch (Exception $e) {
            echo "<p>❌ $table: MISSING - " . $e->getMessage() . "</p>";
        }
    }

    // Test the languages query that was failing
    echo "<h4>🧪 Testing Languages Query:</h4>";
    try {
        $langResult = DB::table('languages')->where('short_name', 'en')->first();
        if ($langResult) {
            echo "<p style='color: green;'>✅ Languages query works! Found: {$langResult->name}</p>";
        } else {
            echo "<p style='color: orange;'>⚠️ Languages query works but no 'en' language found</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>❌ Languages query failed: " . $e->getMessage() . "</p>";
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Laravel database connection failed: " . $e->getMessage() . "</p>";
    echo "<p>This means your .env settings are wrong or database credentials are incorrect.</p>";
}

echo "<h3>🚀 Next Steps:</h3>";
echo "<ol>";
echo "<li><strong>Refresh this page</strong> to see if the fix worked</li>";
echo "<li>Test your admin login: <a href='/admin/login' target='_blank'>/admin/login</a></li>";
echo "<li>If still issues, clear Laravel cache (see below)</li>";
echo "<li>Delete this debug file after fixing</li>";
echo "</ol>";

echo "<h3>🔧 Clear Laravel Cache (if needed):</h3>";
echo "<p>If you're still getting errors, try clearing the cache:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px;'>";
// Check if we can run artisan commands
if (function_exists('exec')) {
    echo "Try running these commands via SSH:\n";
    echo "cd /home/u105084344/domains/sindhumatri.com/public_html\n";
    echo "php artisan config:clear\n";
    echo "php artisan cache:clear\n";
    echo "php artisan view:clear\n";
} else {
    echo "SSH access needed for cache clearing:\n";
    echo "php artisan config:clear\n";
    echo "php artisan cache:clear\n";
    echo "php artisan view:clear\n";
}
echo "</pre>";

echo "<div style='background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>⚠️ If All Else Fails:</h4>";
echo "<p>The issue might be that your database import was incomplete. You may need to:</p>";
echo "<ol>";
echo "<li>Re-run the database import script</li>";
echo "<li>Ensure all 82 tables were created</li>";
echo "<li>Check that the languages table exists and has data</li>";
echo "</ol>";
echo "</div>";
?>
