<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "=== WhatsApp API Error Investigation ===\n\n";

    // Check current configuration
    $config = DB::table('configures')->first();
    echo "Current WhatsApp Config:\n";
    echo "- API ID: " . ($config->whatsapp_api_id ?? 'NOT SET') . "\n";
    echo "- Device: " . ($config->whatsapp_device_name ?? 'NOT SET') . "\n\n";

    // Check recent WhatsApp messages with errors
    echo "Recent WhatsApp Messages:\n";
    $messages = DB::table('whatsapp_messages')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    if ($messages->count() > 0) {
        foreach ($messages as $msg) {
            echo "ID: {$msg->id} | Phone: {$msg->phone} | Status: {$msg->status} | HTTP: {$msg->http_code} | Created: {$msg->created_at}\n";
            if (!empty($msg->error_message)) {
                echo "  ❌ Error: {$msg->error_message}\n";
            }
            if (!empty($msg->api_response)) {
                echo "  📡 API Response: {$msg->api_response}\n";
            }
            echo "  📝 Message: " . substr($msg->message, 0, 50) . "...\n";
            echo "  🔗 API ID: {$msg->api_id} | Device: {$msg->device_name}\n\n";
        }
    } else {
        echo "No WhatsApp messages found in database\n\n";
    }

    // Test the API directly
    echo "=== Testing API Connection ===\n";

    $apiUrl = "https://messagesapi.co.in/chat/sendMessage";
    $testData = [
        'id' => $config->whatsapp_api_id,
        'name' => $config->whatsapp_device_name,
        'phone' => '919999999999', // Test number
        'message' => 'Test message from Matrimony API check'
    ];

    $jsonData = json_encode($testData);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    echo "Test API Call Results:\n";
    echo "- HTTP Code: {$httpCode}\n";
    echo "- Response: {$response}\n";
    if (!empty($curlError)) {
        echo "- cURL Error: {$curlError}\n";
    }

    // Decode response if JSON
    $decoded = json_decode($response, true);
    if ($decoded) {
        echo "- Decoded Response: " . json_encode($decoded, JSON_PRETTY_PRINT) . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}








