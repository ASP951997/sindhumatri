<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

echo "=== LARAVEL DATABASE CONFIG ===\n\n";

echo "Database Config:\n";
echo "  Connection: " . Config::get('database.default') . "\n";
echo "  Host: " . Config::get('database.connections.mysql.host') . "\n";
echo "  Port: " . Config::get('database.connections.mysql.port') . "\n";
echo "  Database: " . Config::get('database.connections.mysql.database') . "\n";
echo "  Username: " . Config::get('database.connections.mysql.username') . "\n\n";

echo "Testing connection:\n";
try {
    $pdo = DB::getPdo();
    echo "  PDO Connection: ✅ SUCCESS\n";

    $stmt = $pdo->query("SELECT DATABASE() as db");
    $result = $stmt->fetch();
    echo "  Current Database: {$result['db']}\n\n";

    echo "Admin table check:\n";
    $count = DB::table('admins')->count();
    echo "  Total admins in admins table: $count\n";

    $admins = DB::table('admins')->get();
    foreach ($admins as $admin) {
        echo "    - {$admin->username} ({$admin->email})\n";
    }

} catch (Exception $e) {
    echo "  ❌ Error: " . $e->getMessage() . "\n";
}
?>











