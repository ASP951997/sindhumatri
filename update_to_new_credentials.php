<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Updating WhatsApp API Credentials ===\n";

    // New active credentials provided by user
    $newApiId = '9226ba3baf2c47db8fc746a6f6032b81';
    $newDeviceName = 'Vivo';

    // Update the configures table
    $updated = DB::table('configures')
        ->where('id', 1) // Assuming first record
        ->update([
            'whatsapp_api_id' => $newApiId,
            'whatsapp_device_name' => $newDeviceName,
            'updated_at' => now()
        ]);

    if ($updated) {
        echo "✅ WhatsApp credentials updated successfully!\n";
        echo "New API ID: {$newApiId}\n";
        echo "New Device: {$newDeviceName}\n";
    } else {
        echo "❌ Failed to update credentials\n";
    }

    // Verify the update
    $config = DB::table('configures')->first();
    echo "\n=== Verification ===\n";
    echo "Current API ID: " . ($config->whatsapp_api_id ?? 'NOT SET') . "\n";
    echo "Current Device: " . ($config->whatsapp_device_name ?? 'NOT SET') . "\n";

    if ($config->whatsapp_api_id === $newApiId && $config->whatsapp_device_name === $newDeviceName) {
        echo "\n🎉 Credentials updated successfully!\n";
        echo "API URL would be: https://messagesapi.co.in/chat/sendMessageFile/{$newApiId}/{$newDeviceName}\n";
    } else {
        echo "\n❌ Verification failed - credentials not updated properly\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}








