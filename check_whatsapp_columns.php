<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$columns = Schema::getColumnListing('configures');
echo 'Columns in configures table: ' . implode(', ', $columns) . PHP_EOL;
echo 'Has whatsapp_api_id: ' . (in_array('whatsapp_api_id', $columns) ? 'YES' : 'NO') . PHP_EOL;
echo 'Has whatsapp_device_name: ' . (in_array('whatsapp_device_name', $columns) ? 'YES' : 'NO') . PHP_EOL;








