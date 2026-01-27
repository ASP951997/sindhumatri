<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Check current WhatsApp configuration
    $config = DB::table('configures')->first();

    echo "=== Current WhatsApp Configuration ===\n";
    echo "API ID: " . ($config->whatsapp_api_id ?? 'NOT SET') . "\n";
    echo "Device Name: " . ($config->whatsapp_device_name ?? 'NOT SET') . "\n";

    // Check if using the old/expired credentials
    if ($config->whatsapp_api_id === '9226ba3baf2c47db8fc746a6f6032b81' && $config->whatsapp_device_name === 'Vivo') {
        echo "\n❌ OLD/EXPIRED credentials detected!\n";
        echo "Current URL would be: https://messagesapi.co.in/chat/sendMessageFile/{$config->whatsapp_api_id}/{$config->whatsapp_device_name}\n";
    } elseif ($config->whatsapp_api_id === 'ad7838b8e5b94b978757bb5ce9b634f9' && $config->whatsapp_device_name === 'OnePlus9') {
        echo "\n✅ NEW/ACTIVE credentials detected!\n";
        echo "Current URL would be: https://messagesapi.co.in/chat/sendMessageFile/{$config->whatsapp_api_id}/{$config->whatsapp_device_name}\n";
    } else {
        echo "\n⚠️  Unknown credentials - may need updating\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}








