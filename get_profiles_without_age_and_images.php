<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Get female profiles without age and images
    $femaleProfiles = DB::table('users')
        ->where('gender', 'female')
        ->where(function($query) {
            $query->whereNull('age')
                  ->orWhere('age', 0);
        })
        ->where(function($query) {
            $query->whereNull('image')
                  ->orWhere('image', '');
        })
        ->select('id', 'firstname', 'lastname', 'username', 'email', 'phone')
        ->orderBy('id')
        ->get();

    // Get male profiles without age and images
    $maleProfiles = DB::table('users')
        ->where('gender', 'male')
        ->where(function($query) {
            $query->whereNull('age')
                  ->orWhere('age', 0);
        })
        ->where(function($query) {
            $query->whereNull('image')
                  ->orWhere('image', '');
        })
        ->select('id', 'firstname', 'lastname', 'username', 'email', 'phone')
        ->orderBy('id')
        ->get();

    echo "=== PROFILES WITHOUT AGE AND IMAGES ===\n\n";

    // Display female profiles
    echo "FEMALE PROFILES:\n";
    echo "Total: " . $femaleProfiles->count() . "\n\n";

    if ($femaleProfiles->count() > 0) {
        echo str_pad("ID", 5) . str_pad("First Name", 15) . str_pad("Last Name", 15) . str_pad("Username", 15) . "Email/Phone\n";
        echo str_repeat("-", 80) . "\n";

        foreach ($femaleProfiles as $profile) {
            $fullName = trim($profile->firstname . ' ' . $profile->lastname);
            if (empty($fullName) || $fullName === ' ') {
                $fullName = 'N/A';
            }

            $contact = $profile->email ?: $profile->phone ?: 'N/A';

            echo str_pad($profile->id, 5) .
                 str_pad(substr($profile->firstname ?: 'N/A', 0, 13), 15) .
                 str_pad(substr($profile->lastname ?: 'N/A', 0, 13), 15) .
                 str_pad(substr($profile->username ?: 'N/A', 0, 13), 15) .
                 $contact . "\n";
        }
    } else {
        echo "No female profiles found without age and images.\n";
    }

    echo "\n" . str_repeat("=", 80) . "\n\n";

    // Display male profiles
    echo "MALE PROFILES:\n";
    echo "Total: " . $maleProfiles->count() . "\n\n";

    if ($maleProfiles->count() > 0) {
        echo str_pad("ID", 5) . str_pad("First Name", 15) . str_pad("Last Name", 15) . str_pad("Username", 15) . "Email/Phone\n";
        echo str_repeat("-", 80) . "\n";

        foreach ($maleProfiles as $profile) {
            $fullName = trim($profile->firstname . ' ' . $profile->lastname);
            if (empty($fullName) || $fullName === ' ') {
                $fullName = 'N/A';
            }

            $contact = $profile->email ?: $profile->phone ?: 'N/A';

            echo str_pad($profile->id, 5) .
                 str_pad(substr($profile->firstname ?: 'N/A', 0, 13), 15) .
                 str_pad(substr($profile->lastname ?: 'N/A', 0, 13), 15) .
                 str_pad(substr($profile->username ?: 'N/A', 0, 13), 15) .
                 $contact . "\n";
        }
    } else {
        echo "No male profiles found without age and images.\n";
    }

    echo "\n=== SUMMARY ===\n";
    echo "Female profiles without age and images: " . $femaleProfiles->count() . "\n";
    echo "Male profiles without age and images: " . $maleProfiles->count() . "\n";
    echo "Total profiles without age and images: " . ($femaleProfiles->count() + $maleProfiles->count()) . "\n";

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . "\n";
}

?>
