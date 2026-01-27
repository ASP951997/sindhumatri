<?php

/**
 * Send WhatsApp Message to Shivani Pandey
 * Message: "Hi"
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Services\WhatsAppService;

echo "==============================================\n";
echo "WhatsApp Message Sender - Shivani Pandey\n";
echo "==============================================\n\n";

try {
    // Find Shivani Pandey
    $user = User::where(function($query) {
        $query->where('firstname', 'LIKE', '%Shivani%')
              ->where('lastname', 'LIKE', '%Pandey%');
    })->orWhere(function($query) {
        $query->where('firstname', 'LIKE', '%Shivani%')
              ->where('lastname', 'LIKE', '%Pandey%');
    })->first();

    if (!$user) {
        // Try broader search
        $user = User::where('firstname', 'LIKE', '%Shivani%')
            ->orWhere('lastname', 'LIKE', '%Pandey%')
            ->first();
    }

    if (!$user) {
        echo "❌ ERROR: User 'Shivani Pandey' not found in the database!\n\n";
        echo "Searching for similar users...\n";
        
        $similarUsers = User::where('firstname', 'LIKE', '%Shiv%')
            ->orWhere('lastname', 'LIKE', '%Pand%')
            ->limit(10)
            ->get(['id', 'firstname', 'lastname', 'phone', 'email']);
        
        if ($similarUsers->count() > 0) {
            echo "Found {$similarUsers->count()} similar user(s):\n";
            foreach ($similarUsers as $u) {
                echo "  - ID: {$u->id}, Name: {$u->firstname} {$u->lastname}, Phone: {$u->phone}, Email: {$u->email}\n";
            }
        } else {
            echo "No similar users found.\n";
        }
        
        exit(1);
    }

    echo "✓ Found user: {$user->firstname} {$user->lastname}\n";
    echo "  - ID: {$user->id}\n";
    echo "  - Email: {$user->email}\n";
    echo "  - Phone: {$user->phone}\n\n";

    if (!$user->phone) {
        echo "❌ ERROR: User '{$user->firstname} {$user->lastname}' does not have a phone number!\n";
        exit(1);
    }

    // Prepare message
    $message = "Hi";
    
    echo "Message: {$message}\n\n";
    echo "Sending WhatsApp message...\n\n";

    // Use WhatsAppService to send message
    $whatsappService = new WhatsAppService();
    $result = $whatsappService->sendMessage($user->phone, $message, $user->firstname);

    if ($result['success']) {
        echo "✅ SUCCESS: Message sent successfully!\n";
        if (isset($result['message_id'])) {
            echo "   Message ID: {$result['message_id']}\n";
        }
    } else {
        echo "❌ ERROR: Failed to send message\n";
        if (isset($result['message'])) {
            echo "   Error: {$result['message']}\n";
        }
        if (isset($result['response'])) {
            echo "   API Response: {$result['response']}\n";
        }
        exit(1);
    }

    echo "\n==============================================\n";
    echo "Message sent successfully!\n";
    echo "==============================================\n";

} catch (\Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}






















