# WhatsApp API - Quick Reference Card

## 🔑 API Credentials

```
API ID:       7e78b0f48d5c4428b3d0cdf70406db2f
Device Name:  Motorola
Base URL:     https://messagesapi.co.in/chat
```

---

## 🚀 Quick Start

### Send Text Message (PHP)

```php
// Using helper function
$result = sendWhatsApp('919999999999', 'Hello [[name]]!', 'John');

// Using service class
use App\Services\WhatsAppService;
$whatsapp = new WhatsAppService();
$result = $whatsapp->sendMessage('919999999999', 'Hello!');
```

### Send Message with File (PHP)

```php
$result = sendWhatsApp(
    '919999999999',
    'Check this file',
    'John',
    '/full/path/to/file.pdf'
);
```

### Send via cURL

```bash
# Text only
curl -X POST https://messagesapi.co.in/chat/sendMessage \
-H "Content-Type: application/json" \
-d '{
  "id": "7e78b0f48d5c4428b3d0cdf70406db2f",
  "name": "Motorola",
  "phone": "919999999999",
  "message": "Hello!"
}'

# With file
curl --location 'https://messagesapi.co.in/chat/sendMessageFile/7e78b0f48d5c4428b3d0cdf70406db2f/Motorola' \
--form 'file=@"/path/to/file.pdf"' \
--form 'phone="919999999999"' \
--form 'message="Check this file"'
```

---

## 📁 Key Files

| File | Purpose |
|------|---------|
| `app/Services/WhatsAppService.php` | Main WhatsApp service class |
| `app/Helper/helpers.php` | Helper function `sendWhatsApp()` |
| `config/whatsapp.php` | Configuration file |
| `app/Http/Controllers/Admin/UsersController.php` | Admin bulk send functionality |
| `test_whatsapp_with_file.php` | Test script |

---

## 🎯 Common Tasks

### 1. Send to Single User

```php
use App\Models\User;

$user = User::find(1);
$result = sendWhatsApp(
    $user->phone,
    'Hello [[name]], your profile is approved!',
    $user->firstname
);
```

### 2. Send to Multiple Users (Bulk)

```php
$whatsapp = new WhatsAppService();
$users = User::where('status', 1)
    ->get()
    ->map(fn($u) => ['phone' => $u->phone, 'name' => $u->firstname])
    ->toArray();

$stats = $whatsapp->sendBulkMessages($users, 'Hello [[name]]!');
// Returns: ['success' => 5, 'failed' => 1, 'no_phone' => 2, 'total' => 8]
```

### 3. Send with PDF Attachment

```php
$pdfPath = storage_path('app/public/invoice.pdf');
sendWhatsApp($user->phone, 'Your invoice', $user->firstname, $pdfPath);
```

### 4. Send with Image

```php
$imagePath = storage_path('app/public/photo.jpg');
sendWhatsApp($user->phone, 'Check this photo!', $user->firstname, $imagePath);
```

---

## 🔧 Configuration

### Enable/Disable Simulation Mode

Edit `config/whatsapp.php`:

```php
'simulation_mode' => [
    'enabled' => false,  // Set to true for testing
],
```

### Change Country Code

```php
'default_country_code' => '+91',  // Change to your country
```

---

## 📋 Response Structure

### Success

```php
[
    'success' => true,
    'message' => 'Message sent successfully',
    'http_code' => 200,
    'response' => '...',
]
```

### Failure

```php
[
    'success' => false,
    'message' => 'Error message',
    'http_code' => 400,
    'response' => '...',
]
```

---

## 🧪 Testing

### Run Test Script

```bash
php test_whatsapp_with_file.php
```

### Test from Admin Panel

1. Go to: Admin Panel → Users → Send WhatsApp
2. Select users
3. Enter message
4. Upload file (optional)
5. Click "Send"

---

## ✅ Phone Number Format

- **Input**: `9999999999` or `+919999999999`
- **Output**: `919999999999` (auto-formatted)
- **Country Code**: Automatically adds `+91` if missing

---

## 📦 Supported File Types

- PDF: `.pdf`
- Images: `.png`, `.jpg`, `.jpeg`
- Max Size: 10 MB

---

## 🔍 Debugging

### Check Logs

```bash
tail -f storage/logs/laravel.log
```

### Clear Config Cache

```bash
php artisan config:clear
```

### Test API Manually

```bash
curl -X POST https://messagesapi.co.in/chat/sendMessage \
-H "Content-Type: application/json" \
-d '{"id":"7e78b0f48d5c4428b3d0cdf70406db2f","name":"Motorola","phone":"919999999999","message":"Test"}'
```

---

## 📌 Message Personalization

Use `[[name]]` placeholder in your messages:

```php
$message = "Hello [[name]], welcome!";
// Becomes: "Hello John, welcome!"
```

---

## 🚨 Common Errors

| Error | Solution |
|-------|----------|
| "WhatsApp API not configured" | Check `config/whatsapp.php` and run `php artisan config:clear` |
| "File not found" | Verify file path is absolute and exists |
| "Invalid phone number" | Ensure format is correct (919999999999) |
| HTTP 400/500 errors | Check API credentials and logs |

---

## 🎓 Method Reference

### WhatsAppService Methods

```php
// Send single message
sendMessage($phone, $message, $userName = null, $filePath = null)

// Send bulk messages
sendBulkMessages($users, $message, $filePath = null)

// Format phone number
formatPhoneNumber($phone)

// Personalize message
personalizeMessage($message, $userName)
```

---

## 📞 Support

- **Full Guide**: See `WHATSAPP_API_GUIDE.md`
- **Config**: `config/whatsapp.php`
- **Logs**: `storage/logs/laravel.log`
- **API Provider**: https://messagesapi.co.in

---

## ⚡ Pro Tips

1. **Use simulation mode** for testing without sending real messages
2. **Check logs** for debugging (storage/logs/laravel.log)
3. **Use [[name]] placeholder** for personalized messages
4. **Store files first** before sending (use full path)
5. **Add rate limiting** to prevent API abuse
6. **Validate phone numbers** before sending

---

## 🎉 Quick Test

```php
// Test in tinker: php artisan tinker
$result = sendWhatsApp('919999999999', 'Test message', 'Test');
dd($result);
```

---

**Last Updated**: October 2025  
**API Version**: Message API v1  
**Laravel Version**: 8.x+

