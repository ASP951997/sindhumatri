<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== CHECKING CORRECT DATABASE ===\n\n";

try {
    // Check current Laravel database
    $pdo = DB::getPdo();
    $stmt = $pdo->query("SELECT DATABASE() as db");
    $result = $stmt->fetch();
    $currentDb = $result['db'];
    echo "Laravel is using database: $currentDb\n\n";

    // Check admins in current database
    echo "Admins in current database ($currentDb):\n";
    $admins = DB::table('admins')->get();
    echo "  Count: " . $admins->count() . "\n";
    foreach ($admins as $admin) {
        echo "    - {$admin->username} ({$admin->email})\n";
    }

    echo "\n";

    // Check the other database
    $otherDb = ($currentDb === 'u105084344_matrimony_1') ? 'u105084344_matrimony_123' : 'u105084344_matrimony_1';
    echo "Checking other database ($otherDb):\n";

    // Switch to other database temporarily
    DB::statement("USE `$otherDb`");
    $admins2 = DB::table('admins')->get();
    echo "  Count: " . $admins2->count() . "\n";
    foreach ($admins2 as $admin) {
        echo "    - {$admin->username} ({$admin->email})\n";
    }

    // Switch back
    DB::statement("USE `$currentDb`");

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}
?>











