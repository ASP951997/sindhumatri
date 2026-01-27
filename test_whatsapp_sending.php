<?php

/**
 * Test WhatsApp Message Sending
 * Debug script to check why messages aren't being sent
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\WhatsAppService;
use App\Models\Configure;

echo "==============================================\n";
echo "WhatsApp Sending Test & Debug\n";
echo "==============================================\n\n";

try {
    // Check database configuration
    echo "1. Checking Database Configuration:\n";
    $config = Configure::first();
    echo "   API ID: " . ($config->whatsapp_api_id ?? 'NOT SET') . "\n";
    echo "   Device Name: " . ($config->whatsapp_device_name ?? 'NOT SET') . "\n\n";
    
    if (!$config->whatsapp_api_id || !$config->whatsapp_device_name) {
        echo "❌ ERROR: WhatsApp credentials not configured in database!\n";
        echo "   Please set them via: Admin Panel → Controls → WhatsApp Settings\n";
        exit(1);
    }
    
    // Initialize service
    echo "2. Initializing WhatsAppService:\n";
    $whatsapp = new WhatsAppService();
    
    // Test phone number (replace with your test number)
    $testPhone = '919999999999'; // CHANGE THIS TO YOUR TEST NUMBER
    $testMessage = 'Test message from matrimony system - ' . date('Y-m-d H:i:s');
    
    echo "   Testing with phone: {$testPhone}\n";
    echo "   Message: {$testMessage}\n\n";
    
    // Test sending message
    echo "3. Sending Test Message:\n";
    echo "   Sending...\n";
    
    $result = $whatsapp->sendMessage(
        $testPhone,
        $testMessage,
        'Test User'
    );
    
    echo "\n4. Result:\n";
    echo "   Success: " . ($result['success'] ? 'YES ✅' : 'NO ❌') . "\n";
    echo "   Message: " . ($result['message'] ?? 'N/A') . "\n";
    echo "   HTTP Code: " . ($result['http_code'] ?? 'N/A') . "\n";
    
    if (isset($result['response'])) {
        echo "   Response: " . substr($result['response'], 0, 200) . "\n";
    }
    
    if (!$result['success']) {
        echo "\n5. Troubleshooting:\n";
        echo "   - Check if phone number is correct: {$testPhone}\n";
        echo "   - Check device connection at messagesapi.co.in dashboard\n";
        echo "   - Verify API credentials are correct\n";
        echo "   - Check internet connection\n";
        echo "   - Review logs: storage/logs/laravel.log\n";
    } else {
        echo "\n✅ SUCCESS: Message sent!\n";
        echo "   Check the phone {$testPhone} to verify receipt.\n";
    }
    
    echo "\n==============================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
    exit(1);
}
































