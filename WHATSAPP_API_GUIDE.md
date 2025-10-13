# WhatsApp API Integration Guide

## Overview

This matrimony application uses **Message API (messagesapi.co.in)** for sending WhatsApp messages with support for:
- Text messages
- File attachments (PDF, images)
- Direct file upload via multipart/form-data
- Bulk messaging
- Message personalization

---

## API Credentials

### Current Configuration

```
API ID (UID):    7e78b0f48d5c4428b3d0cdf70406db2f
Device Name:     Motorola
Base URL:        https://messagesapi.co.in/chat
```

These credentials are configured in:
- **Config file**: `config/whatsapp.php`
- **Environment**: `.env` file (optional)

---

## Configuration

### 1. Config File (`config/whatsapp.php`)

```php
'api_id' => env('WHATSAPP_API_ID', '7e78b0f48d5c4428b3d0cdf70406db2f'),
'device_name' => env('WHATSAPP_DEVICE_NAME', 'Motorola'),
'api_url' => env('WHATSAPP_API_URL', 'https://messagesapi.co.in/chat'),
'default_country_code' => env('WHATSAPP_DEFAULT_COUNTRY_CODE', '+91'),
'simulation_mode' => [
    'enabled' => false, // Set to true for testing without sending real messages
],
```

### 2. Environment Variables (Optional)

Add to your `.env` file:

```env
WHATSAPP_API_ID=7e78b0f48d5c4428b3d0cdf70406db2f
WHATSAPP_DEVICE_NAME=Motorola
WHATSAPP_API_URL=https://messagesapi.co.in/chat
WHATSAPP_DEFAULT_COUNTRY_CODE=+91
```

---

## API Endpoints

### 1. Text Message Only

**Endpoint**: `https://messagesapi.co.in/chat/sendMessage`

**Method**: POST (JSON)

**Request Body**:
```json
{
  "id": "7e78b0f48d5c4428b3d0cdf70406db2f",
  "name": "Motorola",
  "phone": "919999999999",
  "message": "Hello, this is a test message"
}
```

### 2. Message with File Attachment

**Endpoint**: `https://messagesapi.co.in/chat/sendMessageFile/{api_id}/{device_name}`

**Full URL**: `https://messagesapi.co.in/chat/sendMessageFile/7e78b0f48d5c4428b3d0cdf70406db2f/Motorola`

**Method**: POST (multipart/form-data)

**Form Data**:
```
phone: "919999999999"
message: "Please check your file"
file: [binary file data]
```

**cURL Example**:
```bash
curl --location 'https://messagesapi.co.in/chat/sendMessageFile/7e78b0f48d5c4428b3d0cdf70406db2f/Motorola' \
--form 'file=@"/path/to/your/file.pdf"' \
--form 'phone="919999999999"' \
--form 'message="Please check your file"'
```

---

## Using the WhatsApp Service

### 1. WhatsAppService Class

Located at: `app/Services/WhatsAppService.php`

#### Basic Usage

```php
use App\Services\WhatsAppService;

$whatsappService = new WhatsAppService();

// Send text message
$result = $whatsappService->sendMessage(
    '919999999999',           // Phone number
    'Hello [[name]]!',        // Message (supports [[name]] placeholder)
    'John'                    // User name (optional)
);

// Send message with file
$result = $whatsappService->sendMessage(
    '919999999999',           // Phone number
    'Please check this file', // Message
    'John',                   // User name (optional)
    '/path/to/file.pdf'       // File path (optional)
);

// Check result
if ($result['success']) {
    echo "Message sent successfully!";
} else {
    echo "Failed: " . $result['message'];
}
```

#### Bulk Messaging

```php
$users = [
    ['phone' => '919999999999', 'name' => 'John'],
    ['phone' => '918888888888', 'name' => 'Jane'],
];

$stats = $whatsappService->sendBulkMessages(
    $users,
    'Hello [[name]], welcome to our platform!',
    '/path/to/attachment.pdf' // Optional
);

echo "Success: {$stats['success']}, Failed: {$stats['failed']}";
```

---

### 2. Helper Function

Located at: `app/Helper/helpers.php`

#### Quick Usage

```php
// Send text message
$result = sendWhatsApp('919999999999', 'Hello [[name]]!', 'John');

// Send with file
$result = sendWhatsApp(
    '919999999999', 
    'Check this file', 
    'John',
    '/path/to/file.pdf'
);
```

---

## Using in Controllers

### Example: Admin Users Controller

Located at: `app/Http/Controllers/Admin/UsersController.php`

The `sendWhatsAppToSelectedUsers` method has been updated to use the new service:

```php
use App\Services\WhatsAppService;

public function sendWhatsAppToSelectedUsers(Request $request)
{
    $whatsappService = new WhatsAppService();
    
    foreach ($selectedUsers as $user) {
        if ($user->phone) {
            $result = $whatsappService->sendMessage(
                $user->phone,
                $message,
                $user->firstname,
                $attachmentPath // File path from uploaded file
            );
        }
    }
}
```

---

## File Attachments

### Supported File Types

- **PDF**: `.pdf`
- **Images**: `.png`, `.jpg`, `.jpeg`

### Maximum File Size

- **Default**: 10 MB (10240 KB)
- Configurable in `config/whatsapp.php`

### How File Upload Works

1. **Admin uploads file** through the WhatsApp form
2. **File is stored** in `storage/app/public/whatsapp/attachments/`
3. **Full file path** is passed to WhatsAppService
4. **WhatsAppService** uploads file directly to Message API using `CURLFile` with multipart/form-data
5. **Message API** sends the file to WhatsApp recipient

### File Storage Path

```php
// Stored at:
storage/app/public/whatsapp/attachments/{timestamp}_{filename}

// Full system path:
storage_path('app/public/whatsapp/attachments/{filename}')
```

---

## Phone Number Format

The service automatically formats phone numbers:

- **Input**: `9999999999` or `+919999999999` or `919999999999`
- **Output**: `919999999999` (without +)
- **Default Country Code**: `+91` (India) - configurable

---

## Testing

### 1. Test Script

Run the test script to verify the integration:

```bash
php test_whatsapp_with_file.php
```

This script tests:
- Text message sending
- File attachment sending
- Sending to database users
- Bulk messaging

### 2. Simulation Mode

For testing without sending real messages, enable simulation mode in `config/whatsapp.php`:

```php
'simulation_mode' => [
    'enabled' => true,  // Enable simulation
    'success_rate' => 100,  // Percentage of successful sends
    'delay_seconds' => 1,   // Simulate API delay
],
```

---

## Admin Panel Usage

### Send WhatsApp to Users

1. Navigate to: **Admin Panel > Users > Send WhatsApp**
2. Select users from the list
3. Enter your message (use `[[name]]` for personalization)
4. **Optional**: Upload a file attachment
5. Click "Send WhatsApp Message"

The system will:
- Send messages to all selected users
- Show success/failure statistics
- Skip users without phone numbers
- Log all requests and responses

---

## Message Personalization

Use the `[[name]]` placeholder in your messages:

```php
$message = "Hello [[name]], welcome to our platform!";
// Will be replaced with user's first name
// Output: "Hello John, welcome to our platform!"
```

---

## Logging

All WhatsApp messages are logged in Laravel's log files:

**Location**: `storage/logs/laravel.log`

**Log Entries**:
```
[timestamp] INFO: WhatsApp Text Message Request
[timestamp] INFO: WhatsApp File Message Request  
[timestamp] INFO: WhatsApp API Response
[timestamp] ERROR: WhatsApp Service Exception
```

---

## API Response Structure

### Success Response

```php
[
    'success' => true,
    'message' => 'Message sent successfully',
    'http_code' => 200,
    'response' => '{"result":"success","message":"Message sent"}',
    'data' => ['result' => 'success', 'message' => 'Message sent']
]
```

### Error Response

```php
[
    'success' => false,
    'message' => 'HTTP Error 400',
    'http_code' => 400,
    'response' => '{"result":"error","message":"Invalid phone number"}'
]
```

---

## Troubleshooting

### Common Issues

#### 1. Message not sent

**Check**:
- API credentials are correct in `config/whatsapp.php`
- Phone number is valid and includes country code
- Internet connection is working
- Check Laravel logs for error details

#### 2. File attachment not working

**Check**:
- File exists at the specified path
- File size is under 10 MB
- File type is supported (PDF, PNG, JPG, JPEG)
- Storage directory has write permissions

#### 3. "WhatsApp API not configured properly"

**Solution**:
- Verify `api_id` and `device_name` are set in `config/whatsapp.php`
- Clear config cache: `php artisan config:clear`

#### 4. Phone number format issues

**Solution**:
- Ensure phone numbers include country code (e.g., `919999999999`)
- Default country code `+91` is added automatically if missing

---

## Code Examples

### Example 1: Simple Text Message

```php
use App\Services\WhatsAppService;

$whatsapp = new WhatsAppService();
$result = $whatsapp->sendMessage('919999999999', 'Hello!');

if ($result['success']) {
    echo "Sent!";
}
```

### Example 2: Message with Personalization

```php
$result = sendWhatsApp(
    $user->phone,
    'Dear [[name]], your profile has been approved!',
    $user->firstname
);
```

### Example 3: Message with PDF Attachment

```php
$pdfPath = storage_path('app/public/documents/invoice.pdf');

$result = sendWhatsApp(
    $user->phone,
    'Please find your invoice attached.',
    $user->firstname,
    $pdfPath
);
```

### Example 4: Bulk Messaging with File

```php
$users = User::where('status', 1)
    ->whereNotNull('phone')
    ->get()
    ->map(fn($u) => ['phone' => $u->phone, 'name' => $u->firstname])
    ->toArray();

$whatsapp = new WhatsAppService();
$stats = $whatsapp->sendBulkMessages(
    $users,
    'Hello [[name]], check out our new features!',
    storage_path('app/public/brochure.pdf')
);

echo "Sent to {$stats['success']} users";
```

---

## Advanced Features

### Rate Limiting

Configure in `config/whatsapp.php`:

```php
'rate_limit' => [
    'enabled' => true,
    'max_messages_per_minute' => 60,
    'max_messages_per_hour' => 1000,
],
```

### Custom Timeout

Modify in `WhatsAppService.php`:

```php
curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 60 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15); // 15 seconds
```

---

## Security Best Practices

1. **Never commit credentials** to version control
2. **Use environment variables** for API credentials
3. **Validate phone numbers** before sending
4. **Limit file types** to prevent abuse
5. **Implement rate limiting** to prevent spam
6. **Log all activities** for audit trails

---

## Support

For issues with the Message API service, contact:
- **Website**: https://messagesapi.co.in
- **Documentation**: Check their dashboard for API docs

For Laravel integration issues, check:
- **Laravel Logs**: `storage/logs/laravel.log`
- **Config**: `config/whatsapp.php`
- **Service**: `app/Services/WhatsAppService.php`

---

## Summary

✅ **WhatsApp API is configured** with Message API credentials  
✅ **Service class created** at `app/Services/WhatsAppService.php`  
✅ **Helper function added** for quick usage  
✅ **Admin controller updated** to use new service  
✅ **File attachments supported** via direct upload  
✅ **Bulk messaging supported**  
✅ **Message personalization** with `[[name]]` placeholder  
✅ **Comprehensive logging** for debugging  
✅ **Test script provided** for verification  

Your WhatsApp integration is ready to use! 🎉

