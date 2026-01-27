<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "whatsapp.api_url: " . config('whatsapp.api_url') . PHP_EOL;
echo "whatsapp.api_id: " . config('whatsapp.api_id') . PHP_EOL;
echo "whatsapp.device_name: " . config('whatsapp.device_name') . PHP_EOL;
echo "whatsapp.uid: " . config('whatsapp.uid') . PHP_EOL;
echo "whatsapp.simulation_mode.enabled: " . (config('whatsapp.simulation_mode.enabled') ? 'true' : 'false') . PHP_EOL;
echo "whatsapp.simulation_mode.success_rate: " . config('whatsapp.simulation_mode.success_rate') . PHP_EOL;

exit(0);
























