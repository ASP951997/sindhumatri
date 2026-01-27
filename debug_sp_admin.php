<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

echo "=== DEBUGGING SP ADMIN ===\n\n";

try {
    // Try different queries
    echo "Query 1 - Eloquent where:\n";
    $admin1 = Admin::where('username', 'SP')->first();
    echo "  Result: " . ($admin1 ? "Found - {$admin1->username}" : "Not found") . "\n";

    echo "\nQuery 2 - Eloquent where with email:\n";
    $admin2 = Admin::where('email', 'sp@matrimony.com')->first();
    echo "  Result: " . ($admin2 ? "Found - {$admin2->email}" : "Not found") . "\n";

    echo "\nQuery 3 - Raw DB query:\n";
    $admin3 = DB::select("SELECT * FROM admins WHERE username = 'SP' LIMIT 1");
    echo "  Result: " . (count($admin3) > 0 ? "Found - {$admin3[0]->username}" : "Not found") . "\n";

    echo "\nQuery 4 - All admins:\n";
    $allAdmins = Admin::all();
    echo "  Total: " . $allAdmins->count() . "\n";
    foreach ($allAdmins as $admin) {
        echo "    - {$admin->username} ({$admin->email})\n";
    }

    echo "\nQuery 5 - Raw all admins:\n";
    $rawAdmins = DB::select("SELECT username, email FROM admins");
    echo "  Total: " . count($rawAdmins) . "\n";
    foreach ($rawAdmins as $admin) {
        echo "    - {$admin->username} ({$admin->email})\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
    echo 'Trace: ' . $e->getTraceAsString() . "\n";
}
?>











