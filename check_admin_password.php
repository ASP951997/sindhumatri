<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    $admin = DB::table('admins')->first();
    echo 'Admin Password Hash from database: ' . $admin->password . "\n";

    if (Hash::check('admin123', $admin->password)) {
        echo '✅ Password admin123 is CORRECT' . "\n";
    } else {
        echo '❌ Password admin123 is INCORRECT' . "\n";
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>