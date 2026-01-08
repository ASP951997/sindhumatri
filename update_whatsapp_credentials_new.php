<?php

/**
 * Update WhatsApp API Credentials
 * New credentials: API ID: 47fb9881b9f64841b37345dda1c6eadd, Device Name: OnePlus
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Configure;

try {
    echo "==============================================\n";
    echo "WhatsApp Credentials Update\n";
    echo "==============================================\n\n";
    
    $config = Configure::first();
    
    if (!$config) {
        echo "❌ ERROR: Configure record not found!\n";
        exit(1);
    }
    
    // Set new WhatsApp credentials
    $config->whatsapp_api_id = '47fb9881b9f64841b37345dda1c6eadd';
    $config->whatsapp_device_name = 'OnePlus';
    $config->save();
    
    echo "✓ WhatsApp API ID: 47fb9881b9f64841b37345dda1c6eadd\n";
    echo "✓ WhatsApp Device Name: OnePlus\n\n";
    echo "==============================================\n";
    echo "Credentials updated successfully!\n";
    echo "==============================================\n\n";
    echo "You can now access WhatsApp Settings at:\n";
    echo "http://localhost:8000/admin/whatsapp-settings\n\n";
    echo "Or update via Admin Panel:\n";
    echo "Admin Panel → Controls → WhatsApp Settings\n\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}












