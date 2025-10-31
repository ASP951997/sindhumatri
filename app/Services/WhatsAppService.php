<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

/**
 * WhatsApp Service for sending messages via Message API (messagesapi.co.in)
 * 
 * Supports:
 * - Text messages
 * - File attachments (PDF, images)
 * - Direct file upload via multipart/form-data
 */
class WhatsAppService
{
    protected $apiId;
    protected $deviceName;
    protected $baseUrl;
    protected $defaultCountryCode;
    protected $simulationMode;

    public function __construct()
    {
        // Read from database settings (admin configured)
        $basicControl = \App\Models\Configure::first();
        
        // Use database settings if available, otherwise fall back to config
        $this->apiId = $basicControl->whatsapp_api_id ?? config('whatsapp.api_id', config('whatsapp.uid'));
        $this->deviceName = $basicControl->whatsapp_device_name ?? config('whatsapp.device_name');
        
        // Other settings remain in config (hidden from admin)
        $this->baseUrl = 'https://messagesapi.co.in/chat';
        $this->defaultCountryCode = config('whatsapp.default_country_code', '+91');
        $this->simulationMode = config('whatsapp.simulation_mode.enabled', false);
    }

    /**
     * Send WhatsApp message with optional file attachment
     *
     * @param string $phone Phone number (with or without country code)
     * @param string $message Message text
     * @param string|null $userName User's name for personalization
     * @param string|null $filePath Path to file to attach (optional)
     * @return array Response with 'success' boolean and 'message' string
     */
    public function sendMessage($phone, $message, $userName = null, $filePath = null)
    {
        try {
            // Personalize message
            $personalizedMessage = $this->personalizeMessage($message, $userName);
            
            // Check simulation mode
            if ($this->simulationMode) {
                return $this->simulateMessage($phone, $personalizedMessage, $userName, $filePath);
            }
            
            // Validate configuration
            if (!$this->validateConfig()) {
                return [
                    'success' => false,
                    'message' => 'WhatsApp API not configured properly'
                ];
            }
            
            // Format phone number
            $formattedPhone = $this->formatPhoneNumber($phone);
            
            // Send with or without file
            if ($filePath && file_exists($filePath)) {
                return $this->sendMessageWithFile($formattedPhone, $personalizedMessage, $filePath);
            } else {
                return $this->sendTextMessage($formattedPhone, $personalizedMessage);
            }
            
        } catch (\Exception $e) {
            Log::error('WhatsApp Service Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Send text message only (no file)
     *
     * @param string $phone Formatted phone number
     * @param string $message Message text
     * @return array Response array
     */
    protected function sendTextMessage($phone, $message)
    {
        $endpoint = "{$this->baseUrl}/sendMessage";
        
        $postData = [
            'id' => $this->apiId,
            'name' => $this->deviceName,
            'phone' => $phone,
            'message' => $message,
        ];
        
        Log::info('WhatsApp Text Message Request', [
            'endpoint' => $endpoint,
            'phone' => $phone,
            'message_preview' => substr($message, 0, 100)
        ]);
        
        $response = $this->sendCurlRequest($endpoint, $postData);
        
        return $this->processResponse($response, 'text message');
    }

    /**
     * Send message with file attachment using multipart/form-data
     * Uses the sendMessageFile endpoint with direct file upload
     *
     * @param string $phone Formatted phone number
     * @param string $message Message text
     * @param string $filePath Full path to file
     * @return array Response array
     */
    protected function sendMessageWithFile($phone, $message, $filePath)
    {
        // Build endpoint URL with API ID and device name
        $endpoint = "{$this->baseUrl}/sendMessageFile/{$this->apiId}/{$this->deviceName}";
        
        Log::info('WhatsApp File Message Request', [
            'endpoint' => $endpoint,
            'phone' => $phone,
            'file' => basename($filePath),
            'file_size' => filesize($filePath),
            'message_preview' => substr($message, 0, 100)
        ]);
        
        // Prepare multipart form data
        $postData = [
            'phone' => $phone,
            'message' => $message,
            'file' => new \CURLFile($filePath, mime_content_type($filePath), basename($filePath))
        ];
        
        $response = $this->sendMultipartRequest($endpoint, $postData);
        
        return $this->processResponse($response, 'file message');
    }

    /**
     * Send CURL request with JSON data
     *
     * @param string $url API endpoint
     * @param array $data Request data
     * @return array Response with http_code, response, and error
     */
    protected function sendCurlRequest($url, $data)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        return [
            'http_code' => $httpCode,
            'response' => $response,
            'error' => $curlError
        ];
    }

    /**
     * Send CURL request with multipart/form-data (for file uploads)
     *
     * @param string $url API endpoint
     * @param array $data Request data with CURLFile
     * @return array Response with http_code, response, and error
     */
    protected function sendMultipartRequest($url, $data)
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Multipart form data
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // Longer timeout for file uploads
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 3);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        
        return [
            'http_code' => $httpCode,
            'response' => $response,
            'error' => $curlError
        ];
    }

    /**
     * Process API response
     *
     * @param array $response Response from CURL
     * @param string $type Message type for logging
     * @return array Processed response
     */
    protected function processResponse($response, $type = 'message')
    {
        $httpCode = $response['http_code'];
        $responseBody = $response['response'];
        $curlError = $response['error'];
        
        Log::info('WhatsApp API Response', [
            'type' => $type,
            'http_code' => $httpCode,
            'response' => $responseBody,
            'curl_error' => $curlError
        ]);
        
        // Check for CURL errors
        if ($curlError) {
            return [
                'success' => false,
                'message' => "Connection error: {$curlError}",
                'http_code' => $httpCode,
                'response' => $responseBody
            ];
        }
        
        // Check HTTP status code
        if ($httpCode >= 200 && $httpCode < 300) {
            // Try to parse JSON response
            $responseData = json_decode($responseBody, true);
            
            // Check for explicit success in response
            if ($responseData && isset($responseData['result'])) {
                if ($responseData['result'] === 'success' || $responseData['result'] === true) {
                    return [
                        'success' => true,
                        'message' => 'Message sent successfully',
                        'http_code' => $httpCode,
                        'response' => $responseBody,
                        'data' => $responseData
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => $responseData['message'] ?? 'API returned non-success result',
                        'http_code' => $httpCode,
                        'response' => $responseBody
                    ];
                }
            }
            
            // If no explicit result field, consider 2xx as success
            return [
                'success' => true,
                'message' => 'Message sent successfully',
                'http_code' => $httpCode,
                'response' => $responseBody
            ];
        } else {
            return [
                'success' => false,
                'message' => "HTTP Error {$httpCode}",
                'http_code' => $httpCode,
                'response' => $responseBody
            ];
        }
    }

    /**
     * Check device connection status with Message API.
     * Tries a lightweight status endpoint; falls back to probing sendMessageFile response text.
     * @return array{connected:bool,status:string,http_code?:int,response?:string}
     */
    public function checkConnection()
    {
        // Robust connection probe using sendMessageFile with a dummy request
        $probeUrl = "{$this->baseUrl}/sendMessageFile/{$this->apiId}/{$this->deviceName}?phone=910000000000&message=ping";
        $resp = $this->sendGetRequest($probeUrl);

        $connected = false;
        $label = 'disconnected';

        if ($resp['http_code'] >= 200 && $resp['http_code'] < 300) {
            $data = json_decode($resp['response'], true);
            if (is_array($data)) {
                $status = strtolower((string)($data['status'] ?? ''));
                // Explicit error means disconnected
                if ($status === 'error') {
                    $connected = false;
                    $label = 'disconnected';
                }
                // Success indicates connected
                elseif ($status === 'success') {
                    $connected = true;
                    $label = 'connected';
                }
                // Inspect results array if present
                if (isset($data['results']) && is_array($data['results'])) {
                    foreach ($data['results'] as $r) {
                        $rs = strtolower((string)($r['status'] ?? ''));
                        $err = strtolower((string)($r['error'] ?? ''));
                        if ($rs === 'error' || str_contains($err, 'not connected') || str_contains($err, 'offline')) {
                            $connected = false;
                            $label = 'disconnected';
                            break;
                        }
                    }
                }
            }

            // If JSON didn't clarify, check plain response text
            if (!$connected) {
                $text = strtolower((string)$resp['response']);
                if (str_contains($text, 'not connected') || str_contains($text, 'offline')) {
                    $connected = false;
                    $label = 'disconnected';
                } elseif (str_contains($text, 'success')) {
                    $connected = true;
                    $label = 'connected';
                }
            }
        }

        return [
            'connected' => $connected,
            'status' => $label,
            'http_code' => $resp['http_code'] ?? null,
            'response' => $resp['response'] ?? null,
        ];
    }

    /**
     * Simple GET request helper.
     * @param string $url
     * @return array{http_code:int,response:string,error:string}
     */
    protected function sendGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        return ['http_code' => $httpCode, 'response' => $response, 'error' => $curlError];
    }

    /**
     * Personalize message by replacing placeholders
     *
     * @param string $message Original message
     * @param string|null $userName User name
     * @return string Personalized message
     */
    protected function personalizeMessage($message, $userName = null)
    {
        return str_replace('[[name]]', $userName ?? 'User', $message);
    }

    /**
     * Format phone number with country code
     *
     * @param string $phone Phone number
     * @return string Formatted phone (without + sign)
     */
    protected function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters except +
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Add country code if not present
        if (!str_starts_with($phone, '+')) {
            $phone = $this->defaultCountryCode . $phone;
        }
        
        // Remove + sign as API expects plain number
        $phone = str_replace('+', '', $phone);
        
        return $phone;
    }

    /**
     * Validate WhatsApp configuration
     *
     * @return bool True if valid
     */
    protected function validateConfig()
    {
        return !empty($this->apiId) && !empty($this->deviceName);
    }

    /**
     * Simulate message sending (for testing)
     *
     * @param string $phone Phone number
     * @param string $message Message text
     * @param string|null $userName User name
     * @param string|null $filePath File path
     * @return array Simulated response
     */
    protected function simulateMessage($phone, $message, $userName = null, $filePath = null)
    {
        $successRate = config('whatsapp.simulation_mode.success_rate', 100);
        $delaySeconds = config('whatsapp.simulation_mode.delay_seconds', 1);
        
        // Simulate API delay
        if ($delaySeconds > 0) {
            sleep($delaySeconds);
        }
        
        // Simulate success/failure based on success rate
        $isSuccess = (rand(1, 100) <= $successRate);
        
        Log::info('WhatsApp Message Simulation', [
            'phone' => $phone,
            'user_name' => $userName,
            'has_file' => $filePath ? 'Yes' : 'No',
            'message_preview' => substr($message, 0, 100),
            'success' => $isSuccess,
            'simulation_mode' => true
        ]);
        
        if ($isSuccess) {
            return [
                'success' => true,
                'message' => 'Message sent successfully (SIMULATED)',
                'simulation' => true
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Simulated API failure for testing',
                'simulation' => true
            ];
        }
    }

    /**
     * Send bulk messages to multiple users
     *
     * @param array $users Array of users with phone and name
     * @param string $message Message to send
     * @param string|null $filePath Optional file attachment
     * @return array Statistics with success/failed/noPhone counts
     */
    public function sendBulkMessages($users, $message, $filePath = null)
    {
        $stats = [
            'success' => 0,
            'failed' => 0,
            'no_phone' => 0,
            'total' => count($users)
        ];
        
        foreach ($users as $user) {
            if (empty($user['phone'])) {
                $stats['no_phone']++;
                continue;
            }
            
            $userName = $user['name'] ?? $user['firstname'] ?? null;
            $result = $this->sendMessage($user['phone'], $message, $userName, $filePath);
            
            if ($result['success']) {
                $stats['success']++;
            } else {
                $stats['failed']++;
            }
            
            // Rate limiting - small delay between messages
            usleep(500000); // 0.5 seconds
        }
        
        return $stats;
    }
}


                        'message' => 'Message sent successfully',

                        'http_code' => $httpCode,

                        'response' => $responseBody,

                        'data' => $responseData

                    ];

                } else {

                    return [

                        'success' => false,

                        'message' => $responseData['message'] ?? 'API returned non-success result',

                        'http_code' => $httpCode,

                        'response' => $responseBody

                    ];

                }

            }

            

            // If no explicit result field, consider 2xx as success

            return [

                'success' => true,

                'message' => 'Message sent successfully',

                'http_code' => $httpCode,

                'response' => $responseBody

            ];

        } else {

            return [

                'success' => false,

                'message' => "HTTP Error {$httpCode}",

                'http_code' => $httpCode,

                'response' => $responseBody

            ];

        }

    }


    /**
     * Check device connection status with Message API.
     * Tries a lightweight status endpoint; falls back to probing sendMessageFile response text.
     * @return array{connected:bool,status:string,http_code?:int,response?:string}
     */
    public function checkConnection()
    {
        // Robust connection probe using sendMessageFile with a dummy request
        $probeUrl = "{$this->baseUrl}/sendMessageFile/{$this->apiId}/{$this->deviceName}?phone=910000000000&message=ping";
        $resp = $this->sendGetRequest($probeUrl);

        $connected = false;
        $label = 'disconnected';

        if ($resp['http_code'] >= 200 && $resp['http_code'] < 300) {
            $data = json_decode($resp['response'], true);
            if (is_array($data)) {
                $status = strtolower((string)($data['status'] ?? ''));
                // Explicit error means disconnected
                if ($status === 'error') {
                    $connected = false;
                    $label = 'disconnected';
                }
                // Success indicates connected
                elseif ($status === 'success') {
                    $connected = true;
                    $label = 'connected';
                }
                // Inspect results array if present
                if (isset($data['results']) && is_array($data['results'])) {
                    foreach ($data['results'] as $r) {
                        $rs = strtolower((string)($r['status'] ?? ''));
                        $err = strtolower((string)($r['error'] ?? ''));
                        if ($rs === 'error' || str_contains($err, 'not connected') || str_contains($err, 'offline')) {
                            $connected = false;
                            $label = 'disconnected';
                            break;
                        }
                    }
                }
            }

            // If JSON didn't clarify, check plain response text
            if (!$connected) {
                $text = strtolower((string)$resp['response']);
                if (str_contains($text, 'not connected') || str_contains($text, 'offline')) {
                    $connected = false;
                    $label = 'disconnected';
                } elseif (str_contains($text, 'success')) {
                    $connected = true;
                    $label = 'connected';
                }
            }
        }

        // Extract message from response
        $message = 'Status unknown';
        if (!empty($resp['response'])) {
            $data = json_decode($resp['response'], true);
            if (isset($data['message'])) {
                $message = $data['message'];
            } elseif ($connected) {
                $message = 'Device is connected and online';
            } else {
                $message = 'Device is not connected';
            }
        }

        return [
            'connected' => $connected,
            'status' => $label,
            'message' => $message,
            'http_code' => $resp['http_code'] ?? null,
            'response' => $resp['response'] ?? null,
        ];
    }

    /**
     * Simple GET request helper.
     * @param string $url
     * @return array{http_code:int,response:string,error:string}
     */
    protected function sendGetRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 8);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);
        return ['http_code' => $httpCode, 'response' => $response, 'error' => $curlError];
    }


    /**

     * Personalize message by replacing placeholders

     *

     * @param string $message Original message

     * @param string|null $userName User name

     * @return string Personalized message

     */

    protected function personalizeMessage($message, $userName = null)

    {

        return str_replace('[[name]]', $userName ?? 'User', $message);

    }



    /**

     * Format phone number with country code

     *

     * @param string $phone Phone number

     * @return string Formatted phone (without + sign)

     */

    protected function formatPhoneNumber($phone)

    {

        // Remove all non-numeric characters except +

        $phone = preg_replace('/[^0-9+]/', '', $phone);

        

        // Add country code if not present

        if (!str_starts_with($phone, '+')) {

            $phone = $this->defaultCountryCode . $phone;

        }

        

        // Remove + sign as API expects plain number

        $phone = str_replace('+', '', $phone);

        

        return $phone;

    }



    /**

     * Validate WhatsApp configuration

     *

     * @return bool True if valid

     */

    protected function validateConfig()

    {

        return !empty($this->apiId) && !empty($this->deviceName);

    }



    /**

     * Simulate message sending (for testing)

     *

     * @param string $phone Phone number

     * @param string $message Message text

     * @param string|null $userName User name

     * @param string|null $filePath File path

     * @return array Simulated response

     */

    protected function simulateMessage($phone, $message, $userName = null, $filePath = null)

    {

        $successRate = config('whatsapp.simulation_mode.success_rate', 100);

        $delaySeconds = config('whatsapp.simulation_mode.delay_seconds', 1);

        

        // Simulate API delay

        if ($delaySeconds > 0) {

            sleep($delaySeconds);

        }

        

        // Simulate success/failure based on success rate

        $isSuccess = (rand(1, 100) <= $successRate);

        

        Log::info('WhatsApp Message Simulation', [

            'phone' => $phone,

            'user_name' => $userName,

            'has_file' => $filePath ? 'Yes' : 'No',

            'message_preview' => substr($message, 0, 100),

            'success' => $isSuccess,

            'simulation_mode' => true

        ]);

        

        if ($isSuccess) {

            return [

                'success' => true,

                'message' => 'Message sent successfully (SIMULATED)',

                'simulation' => true

            ];

        } else {

            return [

                'success' => false,

                'message' => 'Simulated API failure for testing',

                'simulation' => true

            ];

        }

    }



    /**

     * Send bulk messages to multiple users

     *

     * @param array $users Array of users with phone and name

     * @param string $message Message to send

     * @param string|null $filePath Optional file attachment

     * @return array Statistics with success/failed/noPhone counts

     */

    public function sendBulkMessages($users, $message, $filePath = null)

    {

        $stats = [

            'success' => 0,

            'failed' => 0,

            'no_phone' => 0,

            'total' => count($users)

        ];

        

        foreach ($users as $user) {

            if (empty($user['phone'])) {

                $stats['no_phone']++;

                continue;

            }

            

            $userName = $user['name'] ?? $user['firstname'] ?? null;

            $result = $this->sendMessage($user['phone'], $message, $userName, $filePath);

            

            if ($result['success']) {

                $stats['success']++;

            } else {

                $stats['failed']++;

            }

            

            // Rate limiting - small delay between messages

            usleep(500000); // 0.5 seconds

        }

        

        return $stats;

    }

}




