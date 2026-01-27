<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "Checking user and partner expectation data...\n\n";

try {
    // Get user 461's partner expectations
    $user = User::find(461);
    echo "User 461 Partner Expectations:\n";
    echo "- partner_gender: {$user->partner_gender}\n";
    echo "- partner_religion: {$user->partner_religion}\n";
    echo "- partner_caste: {$user->partner_caste}\n";
    echo "- partner_education: {$user->partner_education}\n";
    echo "- partner_preferred_country: {$user->partner_preferred_country}\n";
    echo "- partner_preferred_state: {$user->partner_preferred_state}\n";
    echo "- partner_preferred_city: {$user->partner_preferred_city}\n\n";

    // Check what values exist in the users table
    echo "Sample data from users table:\n";
    $sampleUsers = User::where('id', '!=', 461)
                      ->whereNotNull('gender')
                      ->take(3)
                      ->get(['id', 'firstname', 'lastname', 'gender', 'religion', 'caste', 'education_level', 'permanent_country']);

    foreach ($sampleUsers as $sample) {
        echo "- {$sample->firstname} {$sample->lastname} (ID: {$sample->id})\n";
        echo "  Gender: {$sample->gender}, Religion: {$sample->religion}, Caste: {$sample->caste}\n";
        echo "  Education: {$sample->education_level}, Country: {$sample->permanent_country}\n\n";
    }

    // Check distinct values
    echo "Distinct values in users table:\n";
    $genders = User::distinct()->pluck('gender')->filter()->values();
    $religions = User::distinct()->pluck('religion')->filter()->values();
    $castes = User::distinct()->pluck('caste')->filter()->values();
    $educations = User::distinct()->pluck('education_level')->filter()->values();
    $countries = User::distinct()->pluck('permanent_country')->filter()->values();

    echo "- Genders: " . implode(', ', $genders->toArray()) . "\n";
    echo "- Religions: " . implode(', ', $religions->toArray()) . "\n";
    echo "- Castes: " . implode(', ', $castes->toArray()) . "\n";
    echo "- Education Levels: " . implode(', ', $educations->toArray()) . "\n";
    echo "- Countries: " . implode(', ', $countries->toArray()) . "\n\n";

    // Check if there are any profiles with status = 1
    $activeProfiles = DB::table('profile_infos')->where('status', 1)->count();
    echo "Active profiles (status = 1): {$activeProfiles}\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}









