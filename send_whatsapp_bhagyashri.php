<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Target phone number (with country code, no plus sign)
$phone = '919503109635';
$message = 'Hi';
$name = 'Sunil Advani';

try {
    $service = new \App\Services\WhatsAppService();
    $result = $service->sendMessage($phone, $message, $name);

    echo "Send attempt result:\n";
    echo json_encode($result, JSON_PRETTY_PRINT) . PHP_EOL;
} catch (\Exception $e) {
    echo "Exception while sending message: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}


