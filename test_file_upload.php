<?php

/**
 * Test WhatsApp File Upload
 * Tests sending a file with message using the exact curl format
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\WhatsAppService;
use App\Models\User;

try {
    echo "==============================================\n";
    echo "WhatsApp File Upload Test\n";
    echo "==============================================\n\n";
    
    // Update credentials
    $basicControl = \App\Models\Configure::first();
    if ($basicControl) {
        $basicControl->whatsapp_api_id = '47fb9881b9f64841b37345dda1c6eadd';
        $basicControl->whatsapp_device_name = 'OnePlus';
        $basicControl->save();
        echo "✓ Credentials updated:\n";
        echo "  - API ID: 47fb9881b9f64841b37345dda1c6eadd\n";
        echo "  - Device: OnePlus\n\n";
    }
    
    // Find a test user (Sunil Advani)
    $user = User::where('id', 461)->first();
    
    if (!$user || !$user->phone) {
        echo "❌ ERROR: Test user not found or has no phone number!\n";
        exit(1);
    }
    
    echo "✓ Test User: {$user->fullname}\n";
    echo "  - Phone: {$user->phone}\n\n";
    
    // Create a test image file if it doesn't exist
    $testImagePath = storage_path('app/test_image.jpg');
    if (!file_exists($testImagePath)) {
        // Create a simple 1x1 pixel JPG
        $image = imagecreate(1, 1);
        imagecolorallocate($image, 255, 255, 255);
        imagejpeg($image, $testImagePath, 100);
        imagedestroy($image);
        echo "✓ Created test image file\n\n";
    }
    
    echo "Test File: {$testImagePath}\n";
    echo "File Size: " . filesize($testImagePath) . " bytes\n";
    echo "File Exists: " . (file_exists($testImagePath) ? 'Yes' : 'No') . "\n\n";
    
    // Send message with file
    $whatsappService = new WhatsAppService();
    $message = "Hi, please check your file";
    
    echo "Sending message with file attachment...\n";
    echo "Message: {$message}\n\n";
    
    $result = $whatsappService->sendMessage(
        $user->phone,
        $message,
        $user->firstname,
        $testImagePath
    );
    
    if ($result['success']) {
        echo "✅ SUCCESS: File message sent successfully!\n";
        echo "   Response: " . ($result['message'] ?? 'Message sent') . "\n";
        if (isset($result['http_code'])) {
            echo "   HTTP Code: {$result['http_code']}\n";
        }
    } else {
        echo "❌ ERROR: Failed to send file message!\n";
        echo "   Error: " . ($result['message'] ?? 'Unknown error') . "\n";
        if (isset($result['http_code'])) {
            echo "   HTTP Code: {$result['http_code']}\n";
        }
        if (isset($result['response'])) {
            echo "   API Response: " . substr($result['response'], 0, 300) . "\n";
        }
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . "\n";
    echo "   Line: " . $e->getLine() . "\n";
    exit(1);
}






























