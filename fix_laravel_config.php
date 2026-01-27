<?php
// fix_laravel_config.php - Fix Laravel database configuration
// Upload this to your live server root directory

echo "<h2>🔧 LARAVEL CONFIGURATION FIX</h2>";

// Check if .env file exists
$envFile = '.env';
if (!file_exists($envFile)) {
    echo "<p style='color: red;'>❌ .env file not found! This is required for Laravel to work.</p>";
    echo "<p>Please upload your .env file from the local project.</p>";
    exit;
}

echo "<p style='color: green;'>✅ .env file found</p>";

// Read current .env file
$envContent = file_get_contents($envFile);
echo "<h3>📋 Current .env Database Settings:</h3>";

// Extract database settings
preg_match('/DB_CONNECTION=(.*)/', $envContent, $connection);
preg_match('/DB_HOST=(.*)/', $envContent, $host);
preg_match('/DB_PORT=(.*)/', $envContent, $port);
preg_match('/DB_DATABASE=(.*)/', $envContent, $database);
preg_match('/DB_USERNAME=(.*)/', $envContent, $username);
preg_match('/DB_PASSWORD=(.*)/', $envContent, $password);

echo "<pre style='background: #f5f5f5; padding: 10px;'>";
echo "DB_CONNECTION: " . ($connection[1] ?? 'NOT SET') . "\n";
echo "DB_HOST: " . ($host[1] ?? 'NOT SET') . "\n";
echo "DB_PORT: " . ($port[1] ?? 'NOT SET') . "\n";
echo "DB_DATABASE: " . ($database[1] ?? 'NOT SET') . "\n";
echo "DB_USERNAME: " . ($username[1] ?? 'NOT SET') . "\n";
echo "DB_PASSWORD: " . (!empty($password[1]) ? '***SET***' : 'NOT SET') . "\n";
echo "</pre>";

// Check if database name matches what we tested
$expectedDb = 'u105084344_matrimony';
$currentDb = $database[1] ?? '';

if (trim($currentDb) !== $expectedDb) {
    echo "<p style='color: orange;'>⚠️ Database name mismatch!<br>";
    echo "Expected: <strong>$expectedDb</strong><br>";
    echo "Current: <strong>$currentDb</strong></p>";

    // Update .env file
    echo "<h3>🔄 Updating .env file...</h3>";

    $envContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$expectedDb", $envContent);

    if (file_put_contents($envFile, $envContent)) {
        echo "<p style='color: green;'>✅ .env file updated successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to update .env file. Check file permissions.</p>";
    }
} else {
    echo "<p style='color: green;'>✅ Database name is correct</p>";
}

// Test Laravel database connection
echo "<h3>🧪 Testing Laravel Database Connection:</h3>";

try {
    // Include Laravel bootstrap
    require 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    use Illuminate\Support\Facades\DB;

    // Test connection
    $pdo = DB::getPdo();
    $stmt = $pdo->query("SELECT DATABASE() as current_db");
    $result = $stmt->fetch();
    $laravelDb = $result['current_db'];

    echo "<p style='color: green;'>✅ Laravel connected to database: <strong>$laravelDb</strong></p>";

    // Test the problematic query
    $fundsData = DB::select("select SUM(CASE WHEN status = 1 THEN amount END) AS totalAmountReceived from funds");

    if ($fundsData) {
        echo "<p style='color: green;'>✅ Funds query works in Laravel!</p>";
    }

    // Test user count
    $userCount = DB::table('users')->count();
    $adminCount = DB::table('admins')->count();

    echo "<p>👥 Users in database: <strong>$userCount</strong></p>";
    echo "<p>👨‍💼 Admins in database: <strong>$adminCount</strong></p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Laravel database error: " . $e->getMessage() . "</p>";
}

echo "<h3>🚀 Next Steps:</h3>";
echo "<ol>";
echo "<li>Delete this file (fix_laravel_config.php)</li>";
echo "<li>Delete live_db_check.php</li>";
echo "<li>Try accessing your admin panel</li>";
echo "<li>If still issues, clear Laravel cache</li>";
echo "</ol>";

echo "<h3>🌐 Test Admin Login:</h3>";
echo "<p><strong>URL:</strong> https://sindhumatri.com/admin/login</p>";
echo "<p><strong>Username:</strong> SPMO</p>";
echo "<p><strong>Password:</strong> admin123</p>";

echo "<div style='background: #e8f4fd; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>🔧 If Still Having Issues:</h4>";
echo "<p>Try clearing Laravel cache:</p>";
echo "<pre style='background: white; padding: 10px;'>php artisan config:clear
php artisan cache:clear
php artisan view:clear</pre>";
echo "<p>If you have SSH access to your server.</p>";
echo "</div>";
?>
