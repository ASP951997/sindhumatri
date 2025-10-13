<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:send {name} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send WhatsApp message to a specific user by name';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $message = $this->argument('message');

        // Search for user by first name, last name, or full name
        $user = User::where(function($query) use ($name) {
            $query->where('firstname', 'LIKE', '%' . $name . '%')
                  ->orWhere('lastname', 'LIKE', '%' . $name . '%')
                  ->orWhereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ['%' . $name . '%']);
        })->first();

        if (!$user) {
            $this->error("User '{$name}' not found!");
            return 1;
        }

        if (!$user->phone) {
            $this->error("User '{$user->fullname}' does not have a phone number!");
            return 1;
        }

        $this->info("Found user: {$user->fullname}");
        $this->info("Phone: {$user->mobile}");
        $this->info("Sending WhatsApp message...");

        // Send WhatsApp message
        $result = $this->sendWhatsAppMessage($user->phone, $message, $user->firstname);

        if ($result) {
            $this->info("✓ WhatsApp message sent successfully to {$user->fullname}!");
            return 0;
        } else {
            $this->error("✗ Failed to send WhatsApp message to {$user->fullname}!");
            return 1;
        }
    }

    /**
     * Send WhatsApp message using Message API
     */
    private function sendWhatsAppMessage($phone, $message, $userName = null)
    {
        try {
            // Replace placeholders in message
            $personalizedMessage = str_replace('[[name]]', $userName ?? 'User', $message);
            
            // Message API configuration
            $apiUrl = config('whatsapp.api_url');
            $apiId = config('whatsapp.api_id', config('whatsapp.uid')); // Support both api_id and uid
            $deviceName = config('whatsapp.device_name');
            
            if (!$apiId || !$deviceName) {
                $this->error('WhatsApp API not configured properly - missing API ID or Device Name');
                return false;
            }

            $this->info("Using API ID: {$apiId}");
            $this->info("Using Device: {$deviceName}");

            // Format phone number (ensure it starts with country code)
            $formattedPhone = $this->formatPhoneNumber($phone);
            // Remove '+' sign as the API expects plain number
            $formattedPhone = str_replace('+', '', $formattedPhone);
            $this->info("Formatted Phone: {$formattedPhone}");
            
            // Prepare JSON body for Message API
            $postData = [
                'id' => $apiId,
                'name' => $deviceName,
                'phone' => $formattedPhone,
                'message' => $personalizedMessage,
            ];
            
            $jsonData = json_encode($postData);

            // Prepare headers
            $headers = [
                'Content-Type: application/json',
                'Accept: application/json',
            ];

            $this->info("API URL: {$apiUrl}");
            $this->info("Request Body: " . json_encode($postData, JSON_PRETTY_PRINT));

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

            // Log the request and response
            Log::info('WhatsApp API Request (Manual Command POST)', [
                'api_url' => $apiUrl,
                'api_id' => $apiId,
                'device_name' => $deviceName,
                'phone' => $formattedPhone,
                'message_preview' => substr($personalizedMessage, 0, 50) . '...',
                'post_data' => $postData,
                'response' => $response,
                'http_code' => $httpCode,
                'curl_error' => $curlError
            ]);

            $this->info("HTTP Code: {$httpCode}");
            $this->info("Response: {$response}");
            if ($curlError) {
                $this->error("cURL Error: {$curlError}");
            }

            // Check if request was successful
            if ($httpCode === 200 || $httpCode === 201) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp Message Send Error', [
                'error' => $e->getMessage(),
                'phone' => $phone
            ]);
            $this->error("Exception: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Format phone number with country code
     */
    private function formatPhoneNumber($phone)
    {
        // Remove any spaces, dashes, or special characters
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // If phone doesn't start with +, add default country code
        if (substr($phone, 0, 1) !== '+') {
            $defaultCountryCode = config('whatsapp.default_country_code', '+91');
            $phone = $defaultCountryCode . $phone;
        }
        
        return $phone;
    }
}

