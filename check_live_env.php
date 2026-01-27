<?php
// check_live_env.php - Check and fix live .env database settings

echo "<h2>🔍 LIVE SERVER .ENV CHECK</h2>";

// Check if .env exists
$envFile = '.env';
if (!file_exists($envFile)) {
    echo "<p style='color: red;'>❌ CRITICAL: .env file missing! Upload it from your local project.</p>";
    echo "<p>Local path: E:\\RSL_Intern_T\\Matrimony\\.env</p>";
    exit;
}

echo "<p style='color: green;'>✅ .env file found</p>";

// Read current .env
$envContent = file_get_contents($envFile);

// Parse database settings
preg_match('/DB_CONNECTION=(.*)/', $envContent, $connection);
preg_match('/DB_HOST=(.*)/', $envContent, $host);
preg_match('/DB_PORT=(.*)/', $envContent, $port);
preg_match('/DB_DATABASE=(.*)/', $envContent, $database);
preg_match('/DB_USERNAME=(.*)/', $envContent, $username);
preg_match('/DB_PASSWORD=(.*)/', $envContent, $password);

$currentDb = trim($database[1] ?? '');
$correctDb = 'u105084344_matrimony';

echo "<h3>📊 Current .env Database Configuration:</h3>";
echo "<table border='1' style='border-collapse: collapse; margin: 10px 0;'>";
echo "<tr style='background: #f0f0f0;'><th>Setting</th><th>Current Value</th><th>Status</th></tr>";
echo "<tr><td>DB_CONNECTION</td><td>" . trim($connection[1] ?? 'NOT SET') . "</td><td>✅</td></tr>";
echo "<tr><td>DB_HOST</td><td>" . trim($host[1] ?? 'NOT SET') . "</td><td>✅</td></tr>";
echo "<tr><td>DB_PORT</td><td>" . trim($port[1] ?? 'NOT SET') . "</td><td>✅</td></tr>";
echo "<tr><td>DB_DATABASE</td><td><strong>$currentDb</strong></td><td style='color: " . ($currentDb === $correctDb ? 'green' : 'red') . ";'>" . ($currentDb === $correctDb ? '✅ CORRECT' : '❌ WRONG') . "</td></tr>";
echo "<tr><td>DB_USERNAME</td><td>" . trim($username[1] ?? 'NOT SET') . "</td><td>⚠️ Check</td></tr>";
echo "<tr><td>DB_PASSWORD</td><td>" . (!empty($password[1]) ? '***SET***' : 'NOT SET') . "</td><td>⚠️ Check</td></tr>";
echo "</table>";

// Fix if wrong
if ($currentDb !== $correctDb) {
    echo "<h3 style='color: red;'>❌ DATABASE NAME IS WRONG!</h3>";
    echo "<p>Current: <strong>$currentDb</strong></p>";
    echo "<p>Should be: <strong>$correctDb</strong></p>";

    echo "<h3>🔄 Auto-fixing .env...</h3>";
    $newContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$correctDb", $envContent);

    if (file_put_contents($envFile, $newContent)) {
        echo "<p style='color: green;'>✅ .env updated successfully!</p>";
        echo "<p>Database changed from '$currentDb' to '$correctDb'</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to update .env! Check file permissions.</p>";
    }
} else {
    echo "<h3 style='color: green;'>✅ Database name is correct</h3>";
}

// Test Laravel connection
echo "<h3>🧪 Testing Laravel Database Connection:</h3>";

use Illuminate\Support\Facades\DB;

try {
    require 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $pdo = DB::getPdo();
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    $laravelDb = $result['current_db'];

    echo "<p>🔌 Laravel connected to: <strong>$laravelDb</strong></p>";

    if ($laravelDb === $correctDb) {
        echo "<p style='color: green;'>✅ Laravel is using the correct database!</p>";
    } else {
        echo "<p style='color: red;'>❌ Laravel is still using wrong database: $laravelDb</p>";
        echo "<p style='color: red;'>⚠️ LARAVEL CACHE NEEDS CLEARING!</p>";
    }

    // Test tables
    $tables = ['languages', 'funds', 'users', 'admins'];
    echo "<h4>📋 Table Check:</h4>";

    foreach ($tables as $table) {
        try {
            $count = DB::table($table)->count();
            echo "<p>✅ $table: $count records</p>";
        } catch (Exception $e) {
            echo "<p>❌ $table: ERROR - " . $e->getMessage() . "</p>";
        }
    }

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Laravel connection failed: " . $e->getMessage() . "</p>";
    echo "<p>Check your .env database credentials.</p>";
}

echo "<h3>🚀 SOLUTION STEPS:</h3>";
echo "<ol>";
echo "<li><strong>Check the results above</strong> - if database name was fixed, proceed to step 2</li>";
echo "<li><strong>Clear Laravel cache</strong> (CRITICAL - see below)</li>";
echo "<li><strong>Test your site:</strong> <a href='/' target='_blank'>Home Page</a> | <a href='/admin/login' target='_blank'>Admin Login</a></li>";
echo "</ol>";

echo "<h3>🔧 Clear Laravel Cache (REQUIRED):</h3>";
echo "<div style='background: #f0f8ff; padding: 15px; border: 1px solid #add8e6; border-radius: 5px; margin: 15px 0;'>";
echo "<h4>Option 1: Via SSH (Recommended):</h4>";
echo "<pre style='background: #f5f5f5; padding: 10px; margin: 5px 0;'>cd /home/u105084344/domains/sindhumatri.com/public_html
php artisan config:clear
php artisan cache:clear
php artisan view:clear</pre>";

echo "<h4>Option 2: Manual (via cPanel File Manager):</h4>";
echo "<ol>";
echo "<li>Navigate to: <code>public_html/bootstrap/cache/</code></li>";
echo "<li>Delete all <code>.php</code> files inside (keep the folder)</li>";
echo "<li>Files to delete: <code>config.php</code>, <code>routes*.php</code>, etc.</li>";
echo "</ol>";
echo "</div>";

echo "<div style='background: #fff3cd; padding: 15px; border: 1px solid #ffeaa7; border-radius: 5px; margin: 15px 0;'>";
echo "<h4>⚠️ IMPORTANT:</h4>";
echo "<ul>";
echo "<li>The error will persist until cache is cleared</li>";
echo "<li>Laravel caches the old database configuration</li>";
echo "<li>Cache clearing is required even if .env was updated</li>";
echo "<li>Test both home page and admin panel after clearing cache</li>";
echo "</ul>";
echo "</div>";

echo "<h3>📞 Login Credentials:</h3>";
echo "<p><strong>Admin URL:</strong> https://sindhumatri.com/admin/login</p>";
echo "<p><strong>Username:</strong> SPMO</p>";
echo "<p><strong>Password:</strong> admin123</p>";

echo "<p style='color: red; margin-top: 20px;'><strong>🗑️ Delete this file after fixing!</strong></p>";
?>
