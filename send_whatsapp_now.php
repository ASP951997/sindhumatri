<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$service = new \App\Services\WhatsAppService();
$result = $service->sendMessage('9503109635', 'Hi ');

print_r($result);

