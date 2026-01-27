<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $userCount = DB::table('users')->count();
    echo "=== USER COUNT IN DATABASE ===\n\n";
    echo "Total Users: $userCount\n\n";

    // Also check the max ID to confirm
    $maxId = DB::table('users')->max('id');
    echo "Highest User ID: $maxId\n\n";

    echo "This should match the user count in your backup file.\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>




