<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // Check configures table for WhatsApp settings
    $config = DB::table('configures')->first();

    echo "=== WhatsApp Configuration ===\n";
    echo "API ID: " . ($config->whatsapp_api_id ?? 'NOT SET') . "\n";
    echo "Device Name: " . ($config->whatsapp_device_name ?? 'NOT SET') . "\n";

    // Check if API credentials are properly configured
    if (empty($config->whatsapp_api_id) || empty($config->whatsapp_device_name)) {
        echo "\n❌ ERROR: WhatsApp API credentials are not configured!\n";
        echo "Please set whatsapp_api_id and whatsapp_device_name in the configures table.\n";
    } else {
        echo "\n✅ WhatsApp API credentials are configured\n";
    }

    // Check recent WhatsApp messages
    echo "\n=== Recent WhatsApp Messages ===\n";
    $messages = DB::table('whatsapp_messages')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    if ($messages->count() > 0) {
        foreach ($messages as $msg) {
            echo "ID: {$msg->id} | Phone: {$msg->phone} | Status: {$msg->status} | Created: {$msg->created_at}\n";
            if (!empty($msg->error_message)) {
                echo "  Error: {$msg->error_message}\n";
            }
            if (!empty($msg->api_response)) {
                echo "  API Response: {$msg->api_response}\n";
            }
        }
    } else {
        echo "No WhatsApp messages found in database\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}








