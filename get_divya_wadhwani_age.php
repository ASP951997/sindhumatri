<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "=== SEARCHING FOR DIVYA WADHWANI ===\n\n";

    // Search for Divya Wadhwani
    $user = DB::table('users')
        ->where('gender', 'Female')
        ->where(function($query) {
            $query->where(function($q) {
                $q->where('firstname', 'like', '%Divya%')
                  ->where('lastname', 'like', '%Wadhwani%');
            })
            ->orWhere(function($q) {
                $q->where('firstname', 'like', '%Wadhwani%')
                  ->where('lastname', 'like', '%Divya%');
            });
        })
        ->select('id', 'firstname', 'lastname', 'username', 'email', 'age', 'date_of_birth', 'gender')
        ->first();

    if ($user) {
        $fullName = trim($user->firstname . ' ' . $user->lastname);
        echo "✅ Found: {$fullName}\n";
        echo "   User ID: {$user->id}\n";
        echo "   Age: {$user->age} years\n";
        echo "   Date of Birth: {$user->date_of_birth}\n";
        echo "   Username: {$user->username}\n";
        echo "   Email: {$user->email}\n";
        echo "   Gender: {$user->gender}\n\n";

        // Calculate current age based on DOB if needed
        if (!empty($user->date_of_birth) && $user->date_of_birth != '0000-00-00') {
            $birthDate = new DateTime($user->date_of_birth);
            $today = new DateTime();
            $calculatedAge = $today->diff($birthDate)->y;
            echo "   Calculated Age (from DOB): {$calculatedAge} years\n";
            echo "   Age matches: " . ($calculatedAge == $user->age ? 'Yes' : 'No') . "\n";
        }
    } else {
        echo "❌ No user found with name 'Divya Wadhwani'\n";

        // Try broader search
        echo "\nTrying broader search for 'Divya'...\n";
        $divyaUsers = DB::table('users')
            ->where('gender', 'Female')
            ->where('firstname', 'like', '%Divya%')
            ->select('id', 'firstname', 'lastname', 'age', 'date_of_birth')
            ->get();

        if ($divyaUsers->count() > 0) {
            echo "Found " . $divyaUsers->count() . " females named Divya:\n";
            foreach ($divyaUsers as $divya) {
                $name = trim($divya->firstname . ' ' . $divya->lastname);
                echo "  - {$name} (ID: {$divya->id}) - Age: {$divya->age}\n";
            }
        } else {
            echo "No females named Divya found.\n";
        }
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
    echo 'File: ' . $e->getFile() . ' Line: ' . $e->getLine() . "\n";
}

?>
