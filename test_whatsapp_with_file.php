<?php

/**
 * Test script to send WhatsApp message with file attachment
 * Using the new WhatsAppService with direct file upload
 * 
 * API: https://messagesapi.co.in/chat/sendMessageFile/{api_id}/{device_name}
 * Credentials: 7e78b0f48d5c4428b3d0cdf70406db2f / Motorola
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Services\WhatsAppService;
use App\Models\User;

echo "==============================================\n";
echo "WhatsApp Message Sender with File Attachment\n";
echo "==============================================\n";
echo "API: messagesapi.co.in\n";
echo "Endpoint: sendMessageFile (multipart/form-data)\n";
echo "==============================================\n\n";

try {
    // Initialize WhatsApp service
    $whatsappService = new WhatsAppService();
    
    // Example 1: Send text message only
    echo "--- Test 1: Text Message Only ---\n";
    $testPhone = '919999999999'; // Replace with actual test number
    $testMessage = 'Hello [[name]], this is a test WhatsApp message from the Matrimony platform!';
    
    echo "Sending text message to: {$testPhone}\n";
    $result = $whatsappService->sendMessage($testPhone, $testMessage, 'Test User');
    
    if ($result['success']) {
        echo "✓ SUCCESS: Message sent successfully!\n";
        echo "Response: {$result['message']}\n";
    } else {
        echo "✗ FAILED: {$result['message']}\n";
    }
    echo "\n";
    
    // Example 2: Send message with file attachment
    echo "--- Test 2: Message with File Attachment ---\n";
    
    // You need to provide a valid file path here
    $testFilePath = __DIR__ . '/Data Docs/mock_id_sample.jpg'; // Example file
    
    if (file_exists($testFilePath)) {
        echo "File found: " . basename($testFilePath) . "\n";
        echo "File size: " . filesize($testFilePath) . " bytes\n";
        echo "Sending message with file attachment...\n";
        
        $result = $whatsappService->sendMessage(
            $testPhone,
            'Please check this file attachment. [[name]]',
            'Test User',
            $testFilePath
        );
        
        if ($result['success']) {
            echo "✓ SUCCESS: Message with file sent successfully!\n";
            echo "Response: {$result['message']}\n";
        } else {
            echo "✗ FAILED: {$result['message']}\n";
        }
    } else {
        echo "⚠ WARNING: Test file not found at: {$testFilePath}\n";
        echo "Please provide a valid file path to test file attachments.\n";
    }
    echo "\n";
    
    // Example 3: Send to actual user from database
    echo "--- Test 3: Send to Database User ---\n";
    
    // Find a user with a phone number
    $user = User::whereNotNull('phone')
        ->where('phone', '!=', '')
        ->first();
    
    if ($user) {
        echo "Found user: {$user->fullname}\n";
        echo "Phone: {$user->phone}\n";
        
        // Ask for confirmation (commented out for automated testing)
        // echo "Press Enter to send message to this user, or Ctrl+C to cancel...";
        // fgets(STDIN);
        
        echo "Sending message...\n";
        $result = $whatsappService->sendMessage(
            $user->phone,
            'Hello [[name]], this is a test message from the Matrimony platform!',
            $user->firstname
        );
        
        if ($result['success']) {
            echo "✓ SUCCESS: Message sent to {$user->fullname}!\n";
        } else {
            echo "✗ FAILED: {$result['message']}\n";
        }
    } else {
        echo "⚠ WARNING: No users with phone numbers found in database.\n";
    }
    echo "\n";
    
    // Example 4: Bulk message sending
    echo "--- Test 4: Bulk Message Sending ---\n";
    
    $users = User::whereNotNull('phone')
        ->where('phone', '!=', '')
        ->where('status', 1)
        ->limit(3) // Limit to 3 users for testing
        ->get();
    
    if ($users->count() > 0) {
        echo "Found {$users->count()} users for bulk messaging.\n";
        
        // Prepare user array for bulk sending
        $usersArray = $users->map(function($user) {
            return [
                'phone' => $user->phone,
                'name' => $user->firstname,
                'firstname' => $user->firstname
            ];
        })->toArray();
        
        $stats = $whatsappService->sendBulkMessages(
            $usersArray,
            'Hello [[name]], this is a bulk test message!'
        );
        
        echo "Bulk send statistics:\n";
        echo "  Total: {$stats['total']}\n";
        echo "  Success: {$stats['success']}\n";
        echo "  Failed: {$stats['failed']}\n";
        echo "  No Phone: {$stats['no_phone']}\n";
    } else {
        echo "⚠ WARNING: No users available for bulk testing.\n";
    }
    echo "\n";
    
    echo "==============================================\n";
    echo "Testing Complete!\n";
    echo "==============================================\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: Exception occurred\n";
    echo "Message: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n\n";
    
    \Log::error('WhatsApp Test Script Error', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    exit(1);
}

