<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = DB::select("SHOW TABLES LIKE 'whatsapp_messages'");
    if (count($tables) > 0) {
        echo "✅ whatsapp_messages table EXISTS\n";

        // Check table structure
        $columns = Schema::getColumnListing('whatsapp_messages');
        echo "Columns: " . implode(', ', $columns) . "\n";
    } else {
        echo "❌ whatsapp_messages table DOES NOT EXIST\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}








