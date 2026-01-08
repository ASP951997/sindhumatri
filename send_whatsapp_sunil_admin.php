<?php

/**
 * Send WhatsApp Message to Sunil Advani via Admin Panel Controller
 * This simulates sending through the admin panel, so it will be saved to database
 */

// Load Laravel bootstrap
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Http\Request;
use App\Services\WhatsAppService;
use App\Models\WhatsAppMessage;

try {
    echo "==============================================\n";
    echo "Sending WhatsApp via Admin Panel Controller\n";
    echo "==============================================\n\n";
    
    // Find user Sunil Advani
    $user = User::where('id', 461)->first();
    
    if (!$user) {
        $user = User::where(function($query) {
            $query->where('firstname', 'LIKE', '%Sunil%')
                  ->where('lastname', 'LIKE', '%Advani%');
        })->first();
    }

    if (!$user) {
        echo "❌ ERROR: User 'Sunil Advani' not found!\n";
        exit(1);
    }

    echo "✓ Found user: {$user->firstname} {$user->lastname}\n";
    echo "  - ID: {$user->id}\n";
    echo "  - Phone: {$user->phone}\n";
    echo "  - Status: " . ($user->status ? 'Active' : 'Inactive') . "\n\n";

    if (!$user->phone) {
        echo "❌ ERROR: User does not have a phone number!\n";
        exit(1);
    }

    // Create a mock request to simulate admin panel submission
    $request = Request::create('/admin/whatsapp-send', 'POST', [
        'selected_users' => [$user->id],
        'message' => 'Hi',
        '_token' => csrf_token(),
    ]);

    $basicControl = \App\Models\Configure::first();
    if ($basicControl) {
        $basicControl->whatsapp_api_id = '47fb9881b9f64841b37345dda1c6eadd';
        $basicControl->whatsapp_device_name = 'OnePlus';
        $basicControl->save();
    }

    echo "Message: Hi\n";
    echo "Sending via WhatsAppService (same as admin panel)...\n\n";

    $whatsappService = new WhatsAppService();
    $result = $whatsappService->sendMessage(
        $user->phone,
        'Hi',
        $user->firstname
    );

    // Save to database (same as admin panel does)
    $whatsappMessage = WhatsAppMessage::create([
        'user_id' => $user->id,
        'phone' => $user->phone,
        'recipient_name' => $user->firstname . ' ' . $user->lastname,
        'message' => 'Hi',
        'status' => !empty($result['success']) ? 'sent' : 'failed',
        'api_response' => isset($result['response']) ? (is_string($result['response']) ? substr($result['response'], 0, 500) : json_encode($result['response'])) : null,
        'http_code' => $result['http_code'] ?? null,
        'error_message' => $result['error'] ?? ($result['message'] ?? null),
        'attachment_path' => null,
        'api_id' => $basicControl->whatsapp_api_id ?? null,
        'device_name' => $basicControl->whatsapp_device_name ?? null,
    ]);

    if ($result['success']) {
        echo "✅ SUCCESS: WhatsApp message sent successfully!\n";
        echo "   Recipient: {$user->firstname} {$user->lastname}\n";
        echo "   Phone: {$user->phone}\n";
        echo "   Message: Hi\n";
        echo "   Response: " . ($result['message'] ?? 'Message sent') . "\n";
        echo "   ✓ Saved to database (Message ID: {$whatsappMessage->id})\n";
        echo "\n📋 View in admin panel:\n";
        echo "   http://localhost:8000/admin/whatsapp-history\n";
        exit(0);
    } else {
        echo "❌ ERROR: Failed to send WhatsApp message!\n";
        echo "   Error: " . ($result['message'] ?? 'Unknown error') . "\n";
        if (isset($result['http_code'])) {
            echo "   HTTP Code: {$result['http_code']}\n";
        }
        echo "   ⚠ Saved to database with failed status (Message ID: {$whatsappMessage->id})\n";
        exit(1);
    }
    
} catch (\Exception $e) {
    echo "❌ EXCEPTION: " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    exit(1);
}

