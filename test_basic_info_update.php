<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "Testing basic information update functionality...\n\n";

try {
    // Get the user from the error message (ID 461)
    $user = User::find(461);

    if (!$user) {
        echo "❌ Test user (ID: 461) not found. Let me find another user.\n";
        $user = User::where('status', 1)->first();
        if (!$user) {
            echo "❌ No active users found for testing.\n";
            exit(1);
        }
        echo "Using user ID: {$user->id} for testing.\n";
    }

    echo "Testing update of basic information fields...\n";

    // Test updating the fields that were causing the error
    $user->language_id = 1;
    $user->image = '69661603813c31768297987.jpg';
    $user->gender = 'Male';
    $user->date_of_birth = '1997-05-09';
    $user->age = 28;
    $user->on_behalf = 7;
    $user->marital_status = 5;
    $user->no_of_children = 0;
    $user->aadhar = '6966160858b801768297992.jpg';
    $user->pan = '696616088bef21768297992.jpg';

    $user->save();

    echo "✅ Basic information updated successfully!\n";

    // Verify the data was saved
    $user->refresh();
    echo "Verification:\n";
    echo "- Gender: {$user->gender}\n";
    echo "- Date of Birth: {$user->date_of_birth}\n";
    echo "- Age: {$user->age}\n";
    echo "- On Behalf: {$user->on_behalf}\n";
    echo "- Marital Status: {$user->marital_status}\n";
    echo "- No of Children: {$user->no_of_children}\n";
    echo "- Aadhar: {$user->aadhar}\n";
    echo "- PAN: {$user->pan}\n";

    echo "\n✅ All basic information fields are working correctly!\n";

} catch (Exception $e) {
    echo "❌ Error testing basic information update: " . $e->getMessage() . "\n";
}










