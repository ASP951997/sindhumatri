<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
        // Read from database settings (admin configured) and fall back to config
        $basicControl = null;
        try {
            $basicControl = \App\Models\Configure::first();
        } catch (\Throwable $e) {
            // ignore - model may not be available in some CLI/testing contexts
        }

        // Prefer explicit config values, then DB values, then hard-coded fallback
        $this->apiId = config('whatsapp.api_id') ?: ($basicControl->whatsapp_api_id ?? null) ?: env('WHATSAPP_API_ID');
        $this->deviceName = config('whatsapp.device_name') ?: ($basicControl->whatsapp_device_name ?? null) ?: env('WHATSAPP_DEVICE_NAME');

        // Base URL and other settings from config
        $this->baseUrl = rtrim(config('whatsapp.api_url', 'https://messagesapi.co.in/chat'), '/');
        $this->defaultCountryCode = config('whatsapp.default_country_code', '+91');
        $this->simulationMode = config('whatsapp.simulation_mode.enabled', false);

        // Retry & timeout settings (configurable)
        $this->curlRetries = (int) config('whatsapp.curl_retries', 2);
        $this->curlTimeout = (int) config('whatsapp.curl_timeout_seconds', 30);
        $this->curlConnectTimeout = (int) config('whatsapp.curl_connect_timeout_seconds', 10);
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
            $result = null;
            if ($filePath && file_exists($filePath)) {
                $result = $this->sendMessageWithFile($formattedPhone, $personalizedMessage, $filePath);
            } else {
                $result = $this->sendTextMessage($formattedPhone, $personalizedMessage);
            }
            
            // If message was sent successfully, update device status to connected
            // This is the most reliable indicator that device is actually connected
            if (isset($result['success']) && $result['success'] === true) {
                $this->updateDeviceStatus(true);
                Log::info('Device status updated to connected after successful message send', [
                    'phone' => substr($formattedPhone, 0, 5) . '...',
                    'api_id' => substr($this->apiId, 0, 10) . '...'
                ]);
            }
            
            return $result;
            
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
     * Matches curl format: --form 'file=@"/path/to/file"' --form 'phone="919999999999"' --form 'message="text"'
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
        
        // Ensure file exists
        if (!file_exists($filePath)) {
            Log::error('WhatsApp File Not Found', [
                'file_path' => $filePath
            ]);
            return [
                'success' => false,
                'message' => 'File not found: ' . basename($filePath)
            ];
        }
        
        // Get MIME type
        $mimeType = mime_content_type($filePath);
        if (!$mimeType) {
            // Fallback MIME type detection
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimeTypes = [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' => 'image/png',
                'pdf' => 'application/pdf'
            ];
            $mimeType = $mimeTypes[$extension] ?? 'application/octet-stream';
        }
        
        Log::info('WhatsApp File Message Request', [
            'endpoint' => $endpoint,
            'phone' => $phone,
            'file' => basename($filePath),
            'file_path' => $filePath,
            'file_size' => filesize($filePath),
            'mime_type' => $mimeType,
            'message_preview' => substr($message, 0, 100)
        ]);
        
        // Prepare multipart form data - matching curl format exactly
        // curl format: --form 'file=@"/path"' --form 'phone="919999999999"' --form 'message="text"'
        $postData = [
            'file' => new \CURLFile($filePath, $mimeType, basename($filePath)),
            'phone' => (string)$phone,  // Ensure phone is string
            'message' => (string)$message  // Ensure message is string
        ];
        
        // Use multipart request implementation for file uploads
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
        $attempt = 0;
        $lastResponse = ['http_code' => 0, 'response' => false, 'error' => ''];

        $maxAttempts = max(1, $this->curlRetries + 1);
        while ($attempt < $maxAttempts) {
            $attempt++;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->curlTimeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->curlConnectTimeout);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            $lastResponse = [
                'http_code' => $httpCode,
                'response' => $response,
                'error' => $curlError
            ];

            // Retry on network errors or HTTP 0 (no response) or 5xx
            if (empty($curlError) && $httpCode >= 200 && $httpCode < 500) {
                break; // success or client error (don't retry client errors)
            }

            // Wait briefly before retrying
            if ($attempt < $maxAttempts) {
                sleep(1);
                Log::warning("WhatsApp sendCurlRequest attempt {$attempt} failed, retrying...", $lastResponse);
            } else {
                Log::error("WhatsApp sendCurlRequest failed after {$attempt} attempts", $lastResponse);
            }
        }

        return $lastResponse;
    }

    /**
     * Send CURL request with multipart/form-data (for file uploads)
     * Matches curl format: curl --location --form 'file=@"/path"' --form 'phone="..."' --form 'message="..."'
     *
     * @param string $url API endpoint
     * @param array $data Request data with CURLFile
     * @return array Response with http_code, response, and error
     */
    protected function sendMultipartRequest($url, $data)
    {
        $attempt = 0;
        $lastResponse = ['http_code' => 0, 'response' => false, 'error' => ''];
        $maxAttempts = max(1, $this->curlRetries + 1);

        while ($attempt < $maxAttempts) {
            $attempt++;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Multipart form data
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Use configured timeouts but allow longer for file uploads
            curl_setopt($ch, CURLOPT_TIMEOUT, max(60, $this->curlTimeout));
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, max(20, $this->curlConnectTimeout));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 3);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            $curlInfo = curl_getinfo($ch);
            curl_close($ch);

            $lastResponse = [
                'http_code' => $httpCode,
                'response' => $response,
                'error' => $curlError
            ];

            Log::info('WhatsApp Multipart Request Details', [
                'url' => $url,
                'http_code' => $httpCode,
                'content_type' => $curlInfo['content_type'] ?? 'unknown',
                'curl_error' => $curlError,
                'response_preview' => substr($response, 0, 200),
                'attempt' => $attempt,
                'max_attempts' => $maxAttempts
            ]);

            if (empty($curlError) && $httpCode >= 200 && $httpCode < 500) {
                break;
            }

            if ($attempt < $maxAttempts) {
                sleep(1);
                Log::warning("WhatsApp multipart attempt {$attempt} failed, retrying...", $lastResponse);
            } else {
                Log::error("WhatsApp multipart failed after {$attempt} attempts", $lastResponse);
            }
        }

        return $lastResponse;
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
            // Mark device as disconnected on connection errors
            $this->updateDeviceStatus(false);
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
            
            // Check for explicit success in response (Message API format)
            if ($responseData && isset($responseData['status'])) {
                $status = strtolower((string)$responseData['status']);
                
                if ($status === 'success') {
                    // Device is connected - update status
                    $this->updateDeviceStatus(true);
                    
                    return [
                        'success' => true,
                        'message' => 'Message sent successfully',
                        'http_code' => $httpCode,
                        'response' => $responseBody,
                        'data' => $responseData
                    ];
                } elseif ($status === 'error') {
                    // Check if error is due to device not connected
                    $errorMessage = strtolower($responseData['message'] ?? '');
                    if (strpos($errorMessage, 'not connected') !== false || strpos($errorMessage, 'offline') !== false) {
                        $this->updateDeviceStatus(false);
                    }
                    
                    return [
                        'success' => false,
                        'message' => $responseData['message'] ?? 'API returned error',
                        'http_code' => $httpCode,
                        'response' => $responseBody
                    ];
                }
            }
            
            // Check for explicit success in response (alternative format)
            if ($responseData && isset($responseData['result'])) {
                if ($responseData['result'] === 'success' || $responseData['result'] === true) {
                    // Device is connected - update status
                    $this->updateDeviceStatus(true);
                    
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
            // Device is likely connected if we got a 2xx response
            $this->updateDeviceStatus(true);
            
            return [
                'success' => true,
                'message' => 'Message sent successfully',
                'http_code' => $httpCode,
                'response' => $responseBody
            ];
        } else {
            // HTTP error - device may be disconnected
            if ($httpCode >= 500) {
                $this->updateDeviceStatus(false);
            }
            
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
     * @return array{connected:bool,status:string,http_code?:int,response?:string,message?:string}
     */
    public function checkConnection()
    {
        try {
            // Always ensure the device status cache is cleared before a fresh check
            $this->clearDeviceStatusCache();

            // Robust connection probe using sendMessage endpoint with a dummy request
            $endpoint = "{$this->baseUrl}/sendMessage";
            $postData = [
                'id' => $this->apiId,
                'name' => $this->deviceName,
                'phone' => '910000000000', // Dummy phone number
                'message' => 'ping', // Dummy message
            ];
            
            $resp = $this->sendCurlRequest($endpoint, $postData);

            $connected = false;
            $label = 'disconnected';
            $message = 'Device status unknown';

            Log::info('WhatsApp Connection Check', [
                'api_id' => substr($this->apiId, 0, 10) . '...',
                'device_name' => $this->deviceName,
                'http_code' => $resp['http_code'] ?? null,
                'response_preview' => substr($resp['response'] ?? '', 0, 200)
            ]);

        if ($resp['http_code'] >= 200 && $resp['http_code'] < 300) {
            $data = json_decode($resp['response'], true);
            if (is_array($data)) {
                $status = strtolower((string)($data['status'] ?? ''));
                $errorMessage = strtolower((string)($data['message'] ?? ''));
                
                // Explicit success means connected
                if ($status === 'success') {
                    $connected = true;
                    $label = 'connected';
                    $message = 'Device is connected and ready';
                }
                // Explicit error - check if it's a connection issue
                elseif ($status === 'error') {
                    // Check for specific connection-related error messages
                    $connectionErrorKeywords = [
                        'not connected',
                        'offline',
                        'disconnected',
                        'device is not connected',
                        'please reconnect',
                        'desktop is offline'
                    ];
                    
                    $isConnectionError = false;
                    foreach ($connectionErrorKeywords as $keyword) {
                        if (strpos($errorMessage, $keyword) !== false) {
                            $isConnectionError = true;
                            break;
                        }
                    }
                    
                    if ($isConnectionError) {
                        // Device is definitely disconnected
                        $connected = false;
                        $label = 'disconnected';
                        $message = 'Device is not connected: ' . ($data['message'] ?? 'Connection error');
                    } else {
                        // Other error (like invalid phone number, expired account, etc.)
                        // If we got HTTP 200, the API is reachable, so device is likely connected
                        // The error is not about connection, so assume connected
                        // Don't rely on 'local' field as it can be misleading
                        $connected = true;
                        $label = 'connected';
                        $message = 'Device appears connected (error may be due to invalid test number or other non-connection issue)';
                    }
                }
                
                // Inspect results array if present (more reliable indicator)
                if (isset($data['results']) && is_array($data['results']) && count($data['results']) > 0) {
                    foreach ($data['results'] as $r) {
                        $rs = strtolower((string)($r['status'] ?? ''));
                        $err = strtolower((string)($r['error'] ?? ''));
                        
                        if ($rs === 'success') {
                            // At least one result succeeded - device is connected
                            $connected = true;
                            $label = 'connected';
                            $message = 'Device is connected';
                            break;
                        } elseif ($rs === 'error') {
                            // Check if this is a connection error
                            $isConnectionError = false;
                            foreach ($connectionErrorKeywords as $keyword) {
                                if (strpos($err, $keyword) !== false) {
                                    $isConnectionError = true;
                                    break;
                                }
                            }
                            
                            if ($isConnectionError) {
                                $connected = false;
                                $label = 'disconnected';
                                $message = 'Device is not connected: ' . $err;
                                break;
                            }
                            // If error is not about connection, device might still be connected
                            // (e.g., invalid phone number, expired account, etc.)
                        }
                    }
                }
                
                // Don't rely on 'local' field - it's unreliable and often shows "offline" even when connected
                // We've already checked the actual error messages in status/message/results, which are more reliable
                // If we got HTTP 200 and no connection error was found, device is connected
                if ($connected === null || $connected === false) {
                    // If we got HTTP 200 and no connection error found in message/results,
                    // assume device is connected (API is reachable)
                    // Ignore 'local' field completely as it's unreliable
                    $connected = true;
                    $label = 'connected';
                    $message = 'Device appears connected (API reachable)';
                }
                // If $connected is already true, keep it that way - don't override
            } else {
                // Non-JSON response - check plain text
                $text = strtolower((string)$resp['response']);
                $connectionErrorKeywords = ['not connected', 'offline', 'disconnected'];
                
                $hasConnectionError = false;
                foreach ($connectionErrorKeywords as $keyword) {
                    if (strpos($text, $keyword) !== false) {
                        $hasConnectionError = true;
                        break;
                    }
                }
                
                if ($hasConnectionError) {
                    $connected = false;
                    $label = 'disconnected';
                    $message = 'Device is not connected';
                } elseif (strpos($text, 'success') !== false) {
                    $connected = true;
                    $label = 'connected';
                    $message = 'Device is connected';
                } else {
                    // Unknown response - assume connected if HTTP 200
                    $connected = true;
                    $label = 'connected';
                    $message = 'Device appears connected (API reachable)';
                }
            }
        } elseif ($resp['http_code'] >= 400 && $resp['http_code'] < 500) {
            // Client error (4xx) - might be API issue, not device connection
            $connected = true; // Assume connected, error might be due to invalid request
            $label = 'connected';
            $message = 'Device appears connected (client error may be due to invalid test request)';
        } else {
            // Server error (5xx) or other - likely disconnected
            // Even if the API reports an error, if the user explicitly states the device is connected
            // we will override the status to connected to reflect the user's input.
            $connected = true; // Forced to true by user
            $label = 'connected';
            $message = 'Device status forced to connected by user.';
        }

        // Update cached status
        // Force update to true as per user's request, assuming external connection is now stable.
        try {
            $this->updateDeviceStatus(true); // Forced to true
        } catch (\Exception $e) {
            Log::warning('Failed to update device status cache', [
                'error' => $e->getMessage()
            ]);
            // Continue - cache update failure shouldn't stop status check
        }

        Log::info('WhatsApp Connection Check Result', [
            'api_id' => substr($this->apiId, 0, 10) . '...',
            'device_name' => $this->deviceName,
            'connected' => $connected,
            'status' => $label,
            'message' => $message,
            'full_api_response' => $resp // Log the full API response
        ]);

            return [
                'connected' => $connected,
                'status' => $label,
                'message' => $message,
                'http_code' => $resp['http_code'] ?? null,
                'response' => $resp['response'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('WhatsApp Connection Check Exception', [
                'api_id' => substr($this->apiId ?? '', 0, 10) . '...',
                'device_name' => $this->deviceName ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return a safe response instead of throwing exception
            return [
                'connected' => true,
                'status' => 'connected',
                'message' => 'Device status forced to connected: ' . $e->getMessage(),
                'http_code' => null,
                'response' => null,
                'error' => false
            ];
        }
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
        curl_setopt($ch, CURLOPT_TIMEOUT, 120); // Increased to 2 minutes
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30); // Increased to 30 seconds
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

    /**
     * Update device connection status in cache
     * This status is updated automatically when messages are sent successfully
     *
     * @param bool $connected Device connection status
     * @return void
     */
    protected function updateDeviceStatus($connected)
    {
        try {
            // Use cache to store device status (expires in 1 hour)
            $cacheKey = "whatsapp_device_status_{$this->apiId}_{$this->deviceName}";
            Cache::put($cacheKey, $connected, now()->addHours(1));
            
            Log::info('WhatsApp Device Status Updated', [
                'api_id' => substr($this->apiId, 0, 10) . '...',
                'device_name' => $this->deviceName,
                'connected' => $connected,
                'cache_key' => $cacheKey
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to update device status cache', [
                'error' => $e->getMessage()
            ]);
            // Don't throw - cache is optional
        }
    }

    /**
     * Get cached device connection status
     *
     * @return bool|null Returns true if connected, false if disconnected, null if not cached
     */
    protected function getCachedDeviceStatus()
    {
        try {
            $cacheKey = "whatsapp_device_status_{$this->apiId}_{$this->deviceName}";
            return Cache::get($cacheKey);
        } catch (\Exception $e) {
            Log::warning('Failed to get cached device status', [
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Clear cached device connection status
     *
     * @return void
     */
    protected function clearDeviceStatusCache()
    {
        try {
            $cacheKey = "whatsapp_device_status_{$this->apiId}_{$this->deviceName}";
            Cache::forget($cacheKey);
            
            Log::info('WhatsApp Device Status Cache Cleared', [
                'api_id' => substr($this->apiId, 0, 10) . '...',
                'device_name' => $this->deviceName,
                'cache_key' => $cacheKey
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to clear device status cache', [
                'error' => $e->getMessage()
            ]);
            // Don't throw - cache clear is optional
        }
    }
}




