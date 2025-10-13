<?php

/**
 * Send WhatsApp Event Invitation to Jayshree Nawale
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Configuration
$apiId = '7e78b0f48d5c4428b3d0cdf70406db2f';
$deviceName = 'Motorola';
$apiUrl = 'https://messagesapi.co.in/chat/sendMessageFile/7e78b0f48d5c4428b3d0cdf70406db2f/Motorola';

echo "==============================================\n";
echo "WhatsApp Event Invitation Sender\n";
echo "==============================================\n";
echo "API ID: {$apiId}\n";
echo "Device: {$deviceName}\n";
echo "==============================================\n\n";

try {
    // Find Jayshree Nawale
    $user = \App\Models\User::where('firstname', 'LIKE', '%Jayshree%')
        ->where('lastname', 'LIKE', '%Nawale%')
        ->first();

    if (!$user) {
        echo "❌ ERROR: User 'Jayshree Nawale' not found in the database!\n";
        exit(1);
    }

    echo "✓ Found user: {$user->fullname}\n";
    echo "  - ID: {$user->id}\n";
    echo "  - Phone: {$user->phone}\n\n";

    if (!$user->phone) {
        echo "❌ ERROR: User '{$user->fullname}' does not have a phone number!\n";
        exit(1);
    }

    // Prepare the event invitation message
    $message = "Subject: 💬 Join Our 30-Minute Live Talk with Your Perfect Match!

Dear {$user->firstname},
We're excited to invite you to our 30-Minute Live Talk Event — a chance to interact directly with your matching profiles on SindhuMatri.com.

🕒 Duration: 30 Minutes
💞 Meet: Verified matches based on your preferences
🎥 Mode: Secure live chat/video call through SindhuMatri.com

Don't miss this opportunity to connect meaningfully and take the next step toward finding your life partner.

👉 Click here to Join the Event Now!
Best regards,
SindhuMatri.com Team";

    echo "Message Preview:\n";
    echo "----------------\n";
    echo substr($message, 0, 200) . "...\n\n";
    
    // Format phone number (remove + and ensure it's in correct format)
    $phone = preg_replace('/[^0-9+]/', '', $user->phone);
    if (substr($phone, 0, 1) === '+') {
        $phone = substr($phone, 1);
    }
    // Always ensure country code 91 is present
    if (substr($phone, 0, 2) !== '91') {
        $phone = '91' . $phone;
    }
    
    echo "Formatted Phone: {$phone}\n";
    
    // Prepare JSON body for Message API
    $postData = [
        'id' => $apiId,
        'name' => $deviceName,
        'phone' => $phone,
        'message' => $message,
    ];
    
    $jsonData = json_encode($postData);

    echo "\nSending WhatsApp message via Message API...\n";

    // Prepare headers
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
    ];

    // Send WhatsApp message via Message API using POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    echo "\n==============================================\n";
    echo "API RESPONSE\n";
    echo "==============================================\n";
    echo "HTTP Code: {$httpCode}\n";
    echo "Response: {$response}\n";
    if ($curlError) {
        echo "cURL Error: {$curlError}\n";
    }
    echo "==============================================\n\n";

    // Log the request and response
    \Log::info('WhatsApp Event Invitation Sent to Jayshree Nawale', [
        'user' => $user->fullname,
        'api_url' => $apiUrl,
        'api_id' => $apiId,
        'device_name' => $deviceName,
        'phone' => $phone,
        'message_preview' => substr($message, 0, 100) . '...',
        'post_data' => $postData,
        'response' => $response,
        'http_code' => $httpCode,
        'curl_error' => $curlError
    ]);

    // Check if request was successful
    if ($httpCode === 200 || $httpCode === 201) {
        $responseData = json_decode($response, true);
        if (isset($responseData['status']) && $responseData['status'] === 'success') {
            echo "✓ SUCCESS: WhatsApp event invitation sent successfully to {$user->fullname}!\n";
            echo "✓ Phone: {$phone}\n";
            exit(0);
        } else {
            echo "⚠️ WARNING: Request completed but status unclear\n";
            echo "Response: {$response}\n";
            exit(0);
        }
    } else {
        echo "❌ FAILED: Could not send WhatsApp message (HTTP {$httpCode})\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: Exception occurred\n";
    echo "Message: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n\n";
    
    \Log::error('WhatsApp Event Invitation Error', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    exit(1);
}

