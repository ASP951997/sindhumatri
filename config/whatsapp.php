<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp API Configuration - Message API Provider
    |--------------------------------------------------------------------------
    |
    | Configuration for Message API WhatsApp integration
    | Get these credentials from your Message API dashboard
    |
    */

    // Message API Base URL (messagesapi.co.in)
    // Note: The service will append /sendMessage or /sendMessageFile/{api_id}/{device_name}
    'api_url' => env('WHATSAPP_API_URL', 'https://messagesapi.co.in/chat'),
    
    // Your Message API ID (Device Identifier) - The unique ID from your messagesapi.co.in account
    'api_id' => env('WHATSAPP_API_ID', 'ee49864d6ce84458b84f82d2a55d00fb'),

    // Your Device Name - The device name registered with messagesapi.co.in
    'device_name' => env('WHATSAPP_DEVICE_NAME', 'Motorola'),
    
    // Legacy: Your Message API UID (for backward compatibility)
    'uid' => env('WHATSAPP_UID', 'ee49864d6ce84458b84f82d2a55d00fb'),
    
    // Your Message API API Key (from Message API dashboard)
    'api_key' => env('WHATSAPP_API_KEY', 'ad7838b8e5b94b978757bb5ce9b634f9'),
    
    // Your Message API Secret Key (from Message API dashboard)
    'api_secret' => env('WHATSAPP_API_SECRET', 'ad7838b8e5b94b978757bb5ce9b634f9'),
    
    // Your WhatsApp Business Phone Number (registered with Message API)
    'phone_number' => env('WHATSAPP_PHONE_NUMBER', '919999999999'),
    
    // Your Message API Account ID (if required)
    'account_id' => env('WHATSAPP_ACCOUNT_ID'),
    
    // Message API Instance ID (if required)
    'instance_id' => env('WHATSAPP_INSTANCE_ID'),
    
    // Webhook URL for receiving delivery reports (optional)
    'webhook_url' => env('WHATSAPP_WEBHOOK_URL'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for WhatsApp messages
    |
    */
    
    'default_country_code' => env('WHATSAPP_DEFAULT_COUNTRY_CODE', '+91'),
    
    'message_template' => [
        'greeting' => 'Hello [[name]],',
        'footer' => 'Best regards,<br>Your Matrimony Team'
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Rate limiting settings to prevent API abuse
    |
    */
    
    'rate_limit' => [
        'enabled' => env('WHATSAPP_RATE_LIMIT_ENABLED', true),
        'max_messages_per_minute' => env('WHATSAPP_MAX_MESSAGES_PER_MINUTE', 60),
        'max_messages_per_hour' => env('WHATSAPP_MAX_MESSAGES_PER_HOUR', 1000),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Message Settings
    |--------------------------------------------------------------------------
    |
    | Settings for message formatting and delivery
    |
    */
    
    'message_settings' => [
        'max_length' => env('WHATSAPP_MESSAGE_MAX_LENGTH', 4096),
        'enable_unicode' => env('WHATSAPP_ENABLE_UNICODE', true),
        'enable_emoji' => env('WHATSAPP_ENABLE_EMOJI', true),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | File Attachment Settings
    |--------------------------------------------------------------------------
    |
    | Settings for file attachments (images, PDFs)
    |
    */
    
    'file_attachments' => [
        'enabled' => env('WHATSAPP_FILE_ATTACHMENTS_ENABLED', true),
        'allowed_types' => ['pdf', 'png', 'jpg', 'jpeg'],
        'max_size' => env('WHATSAPP_MAX_FILE_SIZE', 10240), // 10MB in KB
        'storage_path' => 'whatsapp/attachments',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Curl / HTTP Client Settings
    |--------------------------------------------------------------------------
    |
    | Settings controlling outgoing HTTP requests to the WhatsApp provider.
    | Increase the timeout if requests between servers need more time.
    |
    */
    'curl_retries' => env('WHATSAPP_CURL_RETRIES', 2),
    'curl_timeout_seconds' => env('WHATSAPP_CURL_TIMEOUT_SECONDS', 60),
    'curl_connect_timeout_seconds' => env('WHATSAPP_CURL_CONNECT_TIMEOUT_SECONDS', 10),
    
    /*
    |--------------------------------------------------------------------------
    | Simulation Mode
    |--------------------------------------------------------------------------
    |
    | Temporary simulation mode for testing WhatsApp functionality
    | When enabled, messages are simulated instead of sent via API
    |
    */
    
    'simulation_mode' => [
        'enabled' => false, // DISABLED - Real API mode active
        'success_rate' => env('WHATSAPP_SIMULATION_SUCCESS_RATE', 100), // Percentage of successful sends
        'delay_seconds' => env('WHATSAPP_SIMULATION_DELAY', 1), // Simulate API delay
        'log_simulated' => env('WHATSAPP_SIMULATION_LOG', true),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    |
    | Logging settings for WhatsApp messages
    |
    */
    
    'logging' => [
        'enabled' => env('WHATSAPP_LOGGING_ENABLED', true),
        'log_successful' => env('WHATSAPP_LOG_SUCCESSFUL', true),
        'log_failed' => env('WHATSAPP_LOG_FAILED', true),
        'log_channel' => env('WHATSAPP_LOG_CHANNEL', 'daily'),
    ],
];
