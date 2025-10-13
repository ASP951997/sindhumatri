<?php

/**
 * Update WhatsApp Settings in Database
 * Sets the default API credentials
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Configure;

try {
    echo "==============================================\n";
    echo "WhatsApp Settings Update\n";
    echo "==============================================\n\n";
    
    $config = Configure::first();
    
    if (!$config) {
        echo "❌ ERROR: Configure record not found!\n";
        exit(1);
    }
    
    // Set WhatsApp credentials
    $config->whatsapp_api_id = '7e78b0f48d5c4428b3d0cdf70406db2f';
    $config->whatsapp_device_name = 'Motorola';
    $config->save();
    
    echo "✓ WhatsApp API ID: 7e78b0f48d5c4428b3d0cdf70406db2f\n";
    echo "✓ WhatsApp Device Name: Motorola\n\n";
    echo "==============================================\n";
    echo "Settings updated successfully!\n";
    echo "==============================================\n\n";
    echo "You can now access WhatsApp Settings at:\n";
    echo "http://localhost:8000/admin/whatsapp-settings\n\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

