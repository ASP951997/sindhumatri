<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== Updating WhatsApp API Credentials ===\n";

    // New working credentials from documentation
    $newApiId = 'ad7838b8e5b94b978757bb5ce9b634f9';
    $newDeviceName = 'OnePlus9';

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
        echo "\n🎉 Credentials updated successfully! WhatsApp should now work.\n";
    } else {
        echo "\n❌ Verification failed - credentials not updated properly\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}