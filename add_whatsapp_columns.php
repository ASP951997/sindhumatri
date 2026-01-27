<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Add whatsapp_api_id column
    DB::statement("ALTER TABLE `configures` ADD COLUMN `whatsapp_api_id` VARCHAR(255) NULL AFTER `id`");

    // Add whatsapp_device_name column
    DB::statement("ALTER TABLE `configures` ADD COLUMN `whatsapp_device_name` VARCHAR(255) NULL AFTER `whatsapp_api_id`");

    echo "WhatsApp columns added successfully!\n";

    // Verify the columns were added
    $columns = Schema::getColumnListing('configures');
    echo 'Has whatsapp_api_id: ' . (in_array('whatsapp_api_id', $columns) ? 'YES' : 'NO') . PHP_EOL;
    echo 'Has whatsapp_device_name: ' . (in_array('whatsapp_device_name', $columns) ? 'YES' : 'NO') . PHP_EOL;

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}








