<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp API Configuration - Message API Provider (BACKUP)
    |--------------------------------------------------------------------------
    |
    | This is a backup of the original API configuration for future reference
    | Original configuration that was causing timeouts and 404 errors
    |
    */

    // Original Message API Base URL (was timing out)
    'api_url' => 'https://messagesapi.co.in/chat/sendMessageFile',
    
    // Original UID (Device Identifier)
    'uid' => 'c2f569933ab342aaa02139a75d0b26a2',
    
    // Original Device Name
    'device_name' => 'Motorola',
    
    // Original API Key
    'api_key' => 'ad7838b8e5b94b978757bb5ce9b634f9',
    
    // Original API Secret
    'api_secret' => 'ad7838b8e5b94b978757bb5ce9b634f9',
    
    // Original Phone Number
    'phone_number' => '919999999999',
    
    /*
    |--------------------------------------------------------------------------
    | Issues Found with Original Configuration
    |--------------------------------------------------------------------------
    |
    | 1. API URL: https://messagesapi.co.in/chat/sendMessageFile/c2f569933ab342aaa02139a75d0b26a2/Motorola
    |    - Result: Operation timed out after 10+ seconds
    |    - Status: TIMEOUT ERROR
    |
    | 2. Alternative URLs tested:
    |    - https://messagesapi.co.in/chat/sendMessage/c2f569933ab342aaa02139a75d0b26a2
    |    - https://messagesapi.co.in/api/sendMessage
    |    - https://messagesapi.co.in/sendMessage
    |    - Result: 404 Not Found errors
    |
    | 3. Only working endpoint:
    |    - https://messagesapi.co.in/chat/sendMessage
    |    - Result: 403 "User ID is missing!" error
    |
    | 4. Recommendations:
    |    - Contact Message API support for correct documentation
    |    - Verify account status and credentials
    |    - Consider alternative WhatsApp API providers
    |
    */
    
    'backup_date' => date('Y-m-d H:i:s'),
    'backup_reason' => 'API endpoints returning timeouts and 404 errors - implementing simulation mode',
];
