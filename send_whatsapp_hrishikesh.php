<?php

/**
 * Standalone script to send WhatsApp message to Hrishikesh Jadhav
 * Using Message API credentials: c2f569933ab342aaa02139a75d0b26a2 / Mototrola
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Configuration
$apiId = '7e78b0f48d5c4428b3d0cdf70406db2f';
$deviceName = 'Mototrola';
$apiUrl = 'https://messagesapi.co.in/chat/sendMessage';
$defaultCountryCode = '+91';

echo "==============================================\n";
echo "WhatsApp Message Sender\n";
echo "==============================================\n";
echo "API ID: {$apiId}\n";
echo "Device: {$deviceName}\n";
echo "API URL: {$apiUrl}\n";
echo "==============================================\n\n";

try {
    // Find user Hrishikesh Jadhav
    echo "Searching for user 'Hrishikesh Jadhav'...\n";
    
    $user = \App\Models\User::where(function($query) {
        $query->where('firstname', 'LIKE', '%Hrishikesh%')
              ->orWhere('lastname', 'LIKE', '%Jadhav%')
              ->orWhereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ['%Hrishikesh%Jadhav%']);
    })->first();

    if (!$user) {
        echo "❌ ERROR: User 'Hrishikesh Jadhav' not found in the database!\n";
        echo "\nSearching for any users with similar names...\n";
        
        $similarUsers = \App\Models\User::where('firstname', 'LIKE', '%Hrishi%')
            ->orWhere('lastname', 'LIKE', '%Jad%')
            ->limit(10)
            ->get(['id', 'firstname', 'lastname', 'phone']);
        
        if ($similarUsers->count() > 0) {
            echo "Found {$similarUsers->count()} similar user(s):\n";
            foreach ($similarUsers as $u) {
                echo "  - ID: {$u->id}, Name: {$u->firstname} {$u->lastname}, Phone: {$u->phone}\n";
            }
        } else {
            echo "No similar users found.\n";
        }
        
        exit(1);
    }

    echo "✓ Found user: {$user->fullname}\n";
    echo "  - ID: {$user->id}\n";
    echo "  - Email: {$user->email}\n";
    echo "  - Phone: {$user->phone}\n\n";

    if (!$user->phone) {
        echo "❌ ERROR: User '{$user->fullname}' does not have a phone number!\n";
        exit(1);
    }

    // Prepare message
    $message = "Hello [[name]], this is a test WhatsApp message from the Matrimony platform!";
    $personalizedMessage = str_replace('[[name]]', $user->firstname ?? 'User', $message);
    
    echo "Message: {$personalizedMessage}\n\n";
    
    // Format phone number (remove + and ensure it's in correct format)
    $phone = preg_replace('/[^0-9+]/', '', $user->phone);
    if (substr($phone, 0, 1) !== '+') {
        $phone = $defaultCountryCode . $phone;
    }
    // Remove '+' sign as the API expects plain number
    $phone = str_replace('+', '', $phone);
    
    echo "Formatted Phone: {$phone}\n";
    
    // Prepare JSON body for Message API
    $postData = [
        'id' => $apiId,
        'name' => $deviceName,
        'phone' => $phone,
        'message' => $personalizedMessage,
    ];
    
    $jsonData = json_encode($postData);

    echo "API URL: {$apiUrl}\n";
    echo "Request Body: " . json_encode($postData, JSON_PRETTY_PRINT) . "\n\n";

    // Prepare headers
    $headers = [
        'Content-Type: application/json',
        'Accept: application/json',
    ];

    echo "Sending WhatsApp message via Message API (POST)...\n";

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
    \Log::info('WhatsApp API Request to Hrishikesh Jadhav (Standalone Script POST)', [
        'user' => $user->fullname,
        'api_url' => $apiUrl,
        'api_id' => $apiId,
        'device_name' => $deviceName,
        'phone' => $phone,
        'message' => $personalizedMessage,
        'post_data' => $postData,
        'response' => $response,
        'http_code' => $httpCode,
        'curl_error' => $curlError
    ]);

    // Check if request was successful
    if ($httpCode === 200 || $httpCode === 201) {
        echo "✓ SUCCESS: WhatsApp message sent successfully to {$user->fullname}!\n";
        exit(0);
    } else {
        echo "❌ FAILED: Could not send WhatsApp message (HTTP {$httpCode})\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "\n❌ ERROR: Exception occurred\n";
    echo "Message: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n\n";
    
    \Log::error('WhatsApp Message Send Error (Standalone Script)', [
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    exit(1);
}

