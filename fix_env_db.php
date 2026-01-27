<?php
// fix_env_db.php - Quick fix for Laravel database configuration

echo "<h2>🔧 QUICK DATABASE FIX</h2>";

// Check if .env file exists
$envFile = '.env';
if (!file_exists($envFile)) {
    die("<p style='color: red;'>❌ .env file not found! Please upload it from your local project.</p>");
}

echo "<p style='color: green;'>✅ .env file found</p>";

// Read current .env
$envContent = file_get_contents($envFile);

// Find current database setting
preg_match('/DB_DATABASE=(.*)/', $envContent, $match);
$currentDb = trim($match[1] ?? '');
$correctDb = 'u105084344_matrimony';

echo "<h3>📊 Current Database Setting:</h3>";
echo "<p><strong>Current:</strong> <span style='color: " . ($currentDb === $correctDb ? 'green' : 'red') . ";'>$currentDb</span></p>";
echo "<p><strong>Should be:</strong> <span style='color: green;'>$correctDb</span></p>";

if ($currentDb !== $correctDb) {
    echo "<h3>🔄 Fixing Database Setting...</h3>";

    // Update the database name
    $newContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE=$correctDb", $envContent);

    if (file_put_contents($envFile, $newContent)) {
        echo "<p style='color: green;'>✅ .env file updated successfully!</p>";
        echo "<p><strong>New database:</strong> $correctDb</p>";
    } else {
        echo "<p style='color: red;'>❌ Failed to update .env file. Check permissions.</p>";
    }
} else {
    echo "<p style='color: green;'>✅ Database setting is already correct</p>";
}

// Test the fix
echo "<h3>🧪 Testing Database Connection:</h3>";

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

    echo "<p style='color: green;'>✅ Laravel now connected to: <strong>$laravelDb</strong></p>";

    // Test languages table
    $langCount = DB::table('languages')->count();
    echo "<p style='color: green;'>✅ Languages table found with $langCount records</p>";

    // Test users
    $userCount = DB::table('users')->count();
    echo "<p style='color: green;'>✅ Users table found with $userCount records</p>";

} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Database connection failed: " . $e->getMessage() . "</p>";
}

echo "<h3>🎯 Next Steps:</h3>";
echo "<ol>";
echo "<li><strong>Refresh your website:</strong> <a href='/' target='_blank'>https://sindhumatri.com/</a></li>";
echo "<li><strong>Test admin login:</strong> <a href='/admin/login' target='_blank'>/admin/login</a></li>";
echo "<li><strong>Username:</strong> SPMO</li>";
echo "<li><strong>Password:</strong> admin123</li>";
echo "</ol>";

echo "<h3>🔧 If Still Issues:</h3>";
echo "<p>Clear Laravel cache:</p>";
echo "<pre style='background: #f5f5f5; padding: 10px;'>php artisan config:clear
php artisan cache:clear</pre>";

echo "<div style='background: #e8f4fd; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h4>✅ Expected Result:</h4>";
echo "<p>After this fix, your website should load normally without the languages table error.</p>";
echo "</div>";

echo "<p style='color: red;'><strong>⚠️ Delete this file after testing!</strong></p>";
?>
