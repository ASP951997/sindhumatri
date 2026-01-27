<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $userCount = DB::table('users')->count();
    $adminCount = DB::table('admins')->count();
    $lastUserUpdate = DB::table('users')->max('updated_at');
    $lastAdminUpdate = DB::table('admins')->max('updated_at');

    echo "=== CURRENT DATABASE STATUS ===\n\n";
    echo "Users: $userCount\n";
    echo "Admins: $adminCount\n";
    echo "Last User Update: $lastUserUpdate\n";
    echo "Last Admin Update: $lastAdminUpdate\n\n";

    // Check backup file
    $backupFile = 'local_backup_20260120_065131.sql';
    if (file_exists($backupFile)) {
        echo "=== BACKUP FILE STATUS ===\n";
        echo "File: $backupFile\n";
        echo "Size: " . filesize($backupFile) . " bytes\n";
        echo "Modified: " . date('Y-m-d H:i:s', filemtime($backupFile)) . "\n";

        // Check if backup contains admin data
        $content = file_get_contents($backupFile);
        if (strpos($content, 'SPMO') !== false) {
            echo "✅ Contains SPMO admin account\n";
        }
        if (strpos($content, 'admin@gmail.com') !== false) {
            echo "✅ Contains admin email\n";
        }
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>




