# How to Send WhatsApp Message to Hrishikesh Jadhav

## Configuration Complete ✓

The WhatsApp API has been configured with the following credentials:
- **UID**: `c2f569933ab342aaa02139a75d0b26a2`
- **Device Name**: `Mototrola`
- **API URL**: `https://messagesapi.co.in/chat/sendMessageFile`
- **Simulation Mode**: DISABLED (Real API mode active)

## Method 1: Web Browser (Easiest)

Simply visit this URL in your browser after starting the Laravel application:

```
http://your-domain.com/send-whatsapp-hrishikesh
```

Or if running locally:
```
http://localhost/send-whatsapp-hrishikesh
```

The route will:
1. Search for "Hrishikesh Jadhav" in the database
2. Send them a WhatsApp message using the Message API
3. Return a JSON response with the result

### Response Example (Success):
```json
{
  "status": "success",
  "message": "WhatsApp message sent successfully to Hrishikesh Jadhav!",
  "user": "Hrishikesh Jadhav",
  "phone": "+919876543210",
  "api_response": "...",
  "http_code": 200
}
```

### Response Example (Error):
```json
{
  "status": "error",
  "message": "User 'Hrishikesh Jadhav' not found in the database!",
  "http_code": 404
}
```

---

## Method 2: Standalone PHP Script

Run the standalone PHP script from the command line:

### If PHP is in PATH:
```powershell
php send_whatsapp_hrishikesh.php
```

### Using Full PHP Path:
```powershell
C:\path\to\php.exe send_whatsapp_hrishikesh.php
```

### What the script does:
1. Searches for "Hrishikesh Jadhav" in the users table
2. Displays user information (name, phone, email)
3. Formats the phone number correctly
4. Sends WhatsApp message via Message API
5. Shows detailed output with API response

### Example Output:
```
==============================================
WhatsApp Message Sender
==============================================
UID: c2f569933ab342aaa02139a75d0b26a2
Device: Mototrola
==============================================

Searching for user 'Hrishikesh Jadhav'...
✓ Found user: Hrishikesh Jadhav
  - ID: 123
  - Email: hrishikesh@example.com
  - Phone: 9876543210

Message: Hello Hrishikesh, this is a test WhatsApp message from the Matrimony platform!

Formatted Phone: +919876543210
API URL: https://messagesapi.co.in/chat/sendMessageFile/c2f569933ab342aaa02139a75d0b26a2/Mototrola?phone=%2B919876543210&message=...

Sending WhatsApp message via Message API...

==============================================
API RESPONSE
==============================================
HTTP Code: 200
Response: {"status":"success","message_id":"..."}
==============================================

✓ SUCCESS: WhatsApp message sent successfully to Hrishikesh Jadhav!
```

---

## Method 3: Laravel Artisan Command

Run the custom artisan command:

```powershell
php artisan whatsapp:send "Hrishikesh Jadhav" "Your custom message here"
```

### Example:
```powershell
php artisan whatsapp:send "Hrishikesh Jadhav" "Hello [[name]], welcome to our platform!"
```

Note: Use `[[name]]` as a placeholder that will be replaced with the user's first name.

---

## Troubleshooting

### User Not Found
If the user "Hrishikesh Jadhav" is not found:

1. Check the users table in the database
2. The script searches for:
   - First name containing "Hrishikesh"
   - Last name containing "Jadhav"
   - Full name containing "Hrishikesh Jadhav"

3. You can modify the search in any of the scripts/routes

### PHP Not Found in PATH
If you get "php is not recognized" error:

1. Find your PHP installation (e.g., `C:\xampp\php\php.exe`)
2. Use the full path:
   ```powershell
   C:\xampp\php\php.exe send_whatsapp_hrishikesh.php
   ```

### API Error
If the Message API returns an error:

1. Check the logs in `storage/logs/laravel.log`
2. Verify the API credentials are correct
3. Ensure your Message API account is active
4. Check that the device "Mototrola" is properly configured in your Message API dashboard

---

## Files Created/Modified

### New Files:
1. `send_whatsapp_hrishikesh.php` - Standalone PHP script
2. `app/Console/Commands/SendWhatsAppMessage.php` - Artisan command
3. `SEND_WHATSAPP_INSTRUCTIONS.md` - This file

### Modified Files:
1. `routes/web.php` - Added `/send-whatsapp-hrishikesh` route
2. `config/whatsapp.php` - Disabled simulation mode

---

## Testing the Configuration

You can test if the configuration is working by visiting:
```
http://your-domain.com/send-whatsapp-hrishikesh
```

The response will tell you:
- If the user was found
- If the phone number is available
- The API response status
- Any errors that occurred

---

## Checking Logs

All WhatsApp messages are logged in:
```
storage/logs/laravel.log
```

Search for:
- "WhatsApp API Request to Hrishikesh Jadhav"
- "WhatsApp Message Send Error"

---

## Need Help?

If you encounter any issues:

1. Check `storage/logs/laravel.log` for detailed error messages
2. Verify the user exists in the database
3. Ensure the Message API credentials are correct
4. Test the API endpoint directly using the URL shown in the logs

---

## API URL Format

The Message API expects requests in this format:
```
GET https://messagesapi.co.in/chat/sendMessageFile/{uid}/{device}?phone={phone}&message={message}
```

Example:
```
https://messagesapi.co.in/chat/sendMessageFile/c2f569933ab342aaa02139a75d0b26a2/Mototrola?phone=%2B919876543210&message=Hello%20Hrishikesh
```

---

**Status**: ✅ Ready to Send
**Date**: October 7, 2025
**API**: Message API (messagesapi.co.in)
**Credentials**: c2f569933ab342aaa02139a75d0b26a2 / Mototrola

