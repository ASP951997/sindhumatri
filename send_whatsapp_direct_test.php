<?php

/**
 * Simple WhatsApp Test - Direct API Call
 * 
 * This script directly replicates your curl command:
 * curl --location 'https://messagesapi.co.in/chat/sendMessageFile/7e78b0f48d5c4428b3d0cdf70406db2f/Motorola' \
 * --form 'file=@"/C:/Users/rakes/Pictures/Screenshots/Screenshot (416).png"' \
 * --form 'phone="919999999999"' \
 * --form 'message="Please check your file"'
 */

// Configuration
$apiId = '7e78b0f48d5c4428b3d0cdf70406db2f';
$deviceName = 'Motorola';
$baseUrl = 'https://messagesapi.co.in/chat';

// Test parameters - CHANGE THESE!
$testPhone = '919999999999';  // Change to your test number
$testMessage = 'Please check your file';
$testFile = __DIR__ . '/Data Docs/mock_id_sample.jpg';  // Change to your test file

echo "==============================================\n";
echo "WhatsApp Direct API Test\n";
echo "==============================================\n";
echo "API ID: {$apiId}\n";
echo "Device: {$deviceName}\n";
echo "Phone: {$testPhone}\n";
echo "Message: {$testMessage}\n";
echo "==============================================\n\n";

// TEST 1: Send text message only (no file)
echo "--- Test 1: Text Message (No File) ---\n";
$endpoint = "{$baseUrl}/sendMessage";

$postData = json_encode([
    'id' => $apiId,
    'name' => $deviceName,
    'phone' => $testPhone,
    'message' => $testMessage
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
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

echo "Endpoint: {$endpoint}\n";
echo "HTTP Code: {$httpCode}\n";
echo "Response: {$response}\n";
if ($curlError) {
    echo "Error: {$curlError}\n";
}
echo ($httpCode >= 200 && $httpCode < 300) ? "✓ SUCCESS\n" : "✗ FAILED\n";
echo "\n";

// TEST 2: Send message with file (YOUR CURL COMMAND)
echo "--- Test 2: Message with File (Your curl command) ---\n";

if (!file_exists($testFile)) {
    echo "⚠ WARNING: Test file not found: {$testFile}\n";
    echo "Please provide a valid file path to test file uploads.\n";
    echo "You can use any image or PDF file.\n";
    exit(1);
}

$endpoint = "{$baseUrl}/sendMessageFile/{$apiId}/{$deviceName}";

echo "File: " . basename($testFile) . "\n";
echo "File Size: " . filesize($testFile) . " bytes\n";
echo "Endpoint: {$endpoint}\n\n";

// Prepare multipart form data (exactly like your curl command)
$postData = [
    'phone' => $testPhone,
    'message' => $testMessage,
    'file' => new CURLFile($testFile, mime_content_type($testFile), basename($testFile))
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);  // multipart/form-data
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Response: {$response}\n";
if ($curlError) {
    echo "Error: {$curlError}\n";
}
echo ($httpCode >= 200 && $httpCode < 300) ? "✓ SUCCESS\n" : "✗ FAILED\n";
echo "\n";

echo "==============================================\n";
echo "Test Complete!\n";
echo "==============================================\n";
echo "\nNOTE: Update the \$testPhone and \$testFile variables\n";
echo "at the top of this script for your actual test.\n";

