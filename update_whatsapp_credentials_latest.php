<?php

/**
 * Update WhatsApp API Credentials
 * New credentials: API ID: ee49864d6ce84458b84f82d2a55d00fb, Device Name: Motorola
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
    $config->whatsapp_api_id = 'ee49864d6ce84458b84f82d2a55d00fb';
    $config->whatsapp_device_name = 'Motorola';
    $config->save();
    
    echo "✓ WhatsApp API ID: ee49864d6ce84458b84f82d2a55d00fb\n";
    echo "✓ WhatsApp Device Name: Motorola\n\n";
    echo "==============================================\n";
    echo "Credentials updated successfully!\n";
    echo "==============================================\n\n";
    echo "You can now access WhatsApp Settings at:\n";
    echo "http://localhost:8000/admin/whatsapp-settings\n\n";
    echo "Or send messages via:\n";
    echo "http://localhost:8000/admin/whatsapp-send\n\n";
    
} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}




