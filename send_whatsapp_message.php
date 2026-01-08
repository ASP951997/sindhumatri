<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

// Mocking the Illuminate\Support\Facades\Log for testing purposes
if (!function_exists('Log')) {
    function Log() {
        return new class {
            public function info($message, $context = []) { echo "INFO: $message\n"; }
            public function error($message, $context = []) { echo "ERROR: $message\n"; }
            public function warning($message, $context = []) { echo "WARNING: $message\n"; }
        };
    }
}

// Mocking the Illuminate\Support\Facades\Cache for testing purposes
if (!function_exists('Cache')) {
    function Cache() {
        return new class {
            private $cache = [];
            public function put($key, $value, $ttl) { $this->cache[$key] = $value; }
            public function get($key) { return $this->cache[$key] ?? null; }
            public function forget($key) { unset($this->cache[$key]); }
        };
    }
}

// Mocking config() helper for basic WhatsApp configuration
if (!function_exists('config')) {
    function config($key, $default = null) {
        $configs = [
            'whatsapp.api_id' => 'YOUR_API_ID', // Will be overridden by hardcoded values in WhatsAppService
            'whatsapp.device_name' => 'YOUR_DEVICE_NAME', // Will be overridden by hardcoded values in WhatsAppService
            'whatsapp.default_country_code' => '+91',
            'whatsapp.simulation_mode.enabled' => false,
            'whatsapp.simulation_mode.success_rate' => 100,
            'whatsapp.simulation_mode.delay_seconds' => 1,
        ];
        return $configs[$key] ?? $default;
    }
}

// Mocking the App\Models\Configure class
if (!class_exists('App\\Models\\Configure')) {
    class Configure {
        public $whatsapp_api_id = 'MOCKED_API_ID';
        public $whatsapp_device_name = 'MOCKED_DEVICE';
        public static function first() { return new self(); }
    }
}

// Create an instance of the WhatsAppService
$whatsappService = new WhatsAppService();

// Define recipient and message
$recipientPhone = '919604253122'; // Sunil Advani's phone (updated per request)
$messageContent = 'Hi';

echo "Attempting to send WhatsApp message...\n";

// Send the message
$result = $whatsappService->sendMessage($recipientPhone, $messageContent, 'Sunil Advani');

// Output the result
if ($result['success']) {
    echo "Message sent successfully!\n";
} else {
    echo "Failed to send message: " . ($result['message'] ?? 'Unknown error') . "\n";
    if (isset($result['response'])) {
        echo "API Response: " . $result['response'] . "\n";
    }
}

?>

