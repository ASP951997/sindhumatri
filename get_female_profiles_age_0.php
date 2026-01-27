<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Get all female profiles with age 0
    $femaleProfiles = DB::table('users')
        ->where('gender', 'female')
        ->where('age', 0)
        ->select('id', 'firstname', 'lastname', 'username', 'email', 'phone')
        ->orderBy('id')
        ->get();

    echo "=== FEMALE PROFILES WITH AGE 0 ===\n\n";
    echo "Total female profiles with age 0: " . $femaleProfiles->count() . "\n\n";

    if ($femaleProfiles->count() > 0) {
        echo "Profile Details:\n";
        echo str_pad("ID", 5) . str_pad("First Name", 20) . str_pad("Last Name", 20) . str_pad("Username", 15) . "Email/Phone\n";
        echo str_repeat("-", 100) . "\n";

        foreach ($femaleProfiles as $profile) {
            $fullName = trim($profile->firstname . ' ' . $profile->lastname);
            if (empty($fullName) || $fullName === ' ') {
                $fullName = 'N/A';
            }

            $contact = $profile->email ?: $profile->phone ?: 'N/A';

            echo str_pad($profile->id, 5) .
                 str_pad(substr($profile->firstname ?: 'N/A', 0, 18), 20) .
                 str_pad(substr($profile->lastname ?: 'N/A', 0, 18), 20) .
                 str_pad(substr($profile->username ?: 'N/A', 0, 13), 15) .
                 $contact . "\n";
        }
    } else {
        echo "No female profiles found with age 0.\n";
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
