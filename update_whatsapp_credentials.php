<?php

/**
 * Update WhatsApp API Credentials
 * New credentials: API ID and Device Name
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
    $config->whatsapp_api_id = '908b93018a534bc79e52dc344a0ab85b';
    $config->whatsapp_device_name = 'SPMO';
    $config->save();
    
    echo "✓ WhatsApp API ID: 908b93018a534bc79e52dc344a0ab85b\n";
    echo "✓ WhatsApp Device Name: SPMO\n\n";
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














