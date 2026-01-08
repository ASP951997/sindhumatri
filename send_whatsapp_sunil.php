<?php

/**
 * Send WhatsApp Message to Sunil Advani
 * API ID: 47fb9881b9f64841b37345dda1c6eadd
 * Device Name: OnePlus
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Services\WhatsAppService;
use App\Models\WhatsAppMessage;

try {
    echo "==============================================\n";
    echo "WhatsApp Message to Sunil Advani\n";
    echo "==============================================\n\n";
    
    // Find user Sunil Advani - try exact match first, then partial
    $user = User::where('id', 461)->first(); // Known ID from logs
    
    if (!$user) {
        // Fallback to name search
        $user = User::where(function($query) {
            $query->where('firstname', 'LIKE', '%Sunil%')
                  ->where('lastname', 'LIKE', '%Advani%');
        })->orWhere(function($query) {
            $query->whereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ['%Sunil%Advani%']);
        })->first();
    }

    if (!$user) {
        echo "❌ ERROR: User 'Sunil Advani' not found in the database!\n";
        echo "\nSearching for any users with similar names...\n";
        
        $similarUsers = User::where('firstname', 'LIKE', '%Sunil%')
            ->orWhere('lastname', 'LIKE', '%Advani%')
            ->limit(10)
            ->get(['id', 'firstname', 'lastname', 'phone']);
        
        if ($similarUsers->count() > 0) {
            echo "Found {$similarUsers->count()} similar user(s):\n";
            foreach ($similarUsers as $u) {
                echo "  - ID: {$u->id}, Name: {$u->firstname} {$u->lastname}, Phone: {$u->phone}\n";
            }
        } else {
            echo "No similar users found.\n";
        }
        
        exit(1);
    }

    echo "✓ Found user: {$user->fullname}\n";
    echo "  - ID: {$user->id}\n";
    echo "  - Phone: {$user->phone}\n\n";

    if (!$user->phone) {
        echo "❌ ERROR: User '{$user->fullname}' does not have a phone number!\n";
        exit(1);
    }

    // Update WhatsApp credentials in database
    $basicControl = \App\Models\Configure::first();
    if ($basicControl) {
        $basicControl->whatsapp_api_id = '47fb9881b9f64841b37345dda1c6eadd';
        $basicControl->whatsapp_device_name = 'OnePlus';
        $basicControl->save();
        echo "✓ Updated WhatsApp credentials:\n";
        echo "  - API ID: 47fb9881b9f64841b37345dda1c6eadd\n";
        echo "  - Device Name: OnePlus\n\n";
    }

    // Prepare message
    $message = "Hi";
    
    echo "Message: {$message}\n";
    echo "Sending WhatsApp message...\n\n";

    // Use WhatsAppService to send message
    $whatsappService = new WhatsAppService();
    $result = $whatsappService->sendMessage(
        $user->phone,
        $message,
        $user->firstname
    );

    // Save message to database for admin panel history
    $whatsappMessage = WhatsAppMessage::create([
        'user_id' => $user->id,
        'phone' => $user->phone,
        'recipient_name' => $user->firstname . ' ' . $user->lastname,
        'message' => $message,
        'status' => !empty($result['success']) ? 'sent' : 'failed',
        'api_response' => isset($result['response']) ? (is_string($result['response']) ? substr($result['response'], 0, 500) : json_encode($result['response'])) : null,
        'http_code' => $result['http_code'] ?? null,
        'error_message' => $result['error'] ?? ($result['message'] ?? null),
        'attachment_path' => null,
        'api_id' => $basicControl->whatsapp_api_id ?? null,
        'device_name' => $basicControl->whatsapp_device_name ?? null,
    ]);

    if ($result['success']) {
        echo "✅ SUCCESS: WhatsApp message sent successfully to {$user->fullname}!\n";
        echo "   Phone: {$user->phone}\n";
        echo "   Message: {$message}\n";
        echo "   Response: " . ($result['message'] ?? 'Message sent') . "\n";
        echo "   ✓ Message saved to database (ID: {$whatsappMessage->id})\n";
        echo "   📋 View in admin panel: http://localhost:8000/admin/whatsapp-history\n";
        exit(0);
    } else {
        echo "❌ ERROR: Failed to send WhatsApp message!\n";
        echo "   Error: " . ($result['message'] ?? 'Unknown error') . "\n";
        if (isset($result['http_code'])) {
            echo "   HTTP Code: {$result['http_code']}\n";
        }
        if (isset($result['response'])) {
            echo "   API Response: " . substr($result['response'], 0, 200) . "\n";
        }
        echo "   ⚠ Message saved to database with failed status (ID: {$whatsappMessage->id})\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "   Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}

