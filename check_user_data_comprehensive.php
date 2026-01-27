<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== COMPREHENSIVE USER DATA ANALYSIS ===\n\n";

try {
    // Get a sample user to check all data
    $sampleUser = User::with(['getReligion', 'getCaste', 'getPresentCountry', 'maritalStatus'])
        ->whereHas('profileInfo', function ($query) {
            return $query->where('status', 1);
        })
        ->first();

    if (!$sampleUser) {
        echo "❌ No active user profiles found!\n";
        exit;
    }

    echo "=== SAMPLE USER DATA (ID: {$sampleUser->id}) ===\n";
    echo "Basic Info:\n";
    echo "- Name: {$sampleUser->firstname} {$sampleUser->lastname}\n";
    echo "- Member ID: {$sampleUser->member_id}\n";
    echo "- Email: {$sampleUser->email}\n";
    echo "- Phone: {$sampleUser->phone}\n\n";

    echo "Demographic Data:\n";
    echo "- Gender: '{$sampleUser->gender}'\n";
    echo "- Age: '{$sampleUser->age}'\n";
    echo "- Date of Birth: '{$sampleUser->date_of_birth}'\n";
    echo "- Height: '{$sampleUser->height}'\n";
    echo "- Weight: '{$sampleUser->weight}'\n\n";

    echo "Religious & Social Background:\n";
    echo "- Religion ID: '{$sampleUser->religion}'\n";
    echo "- Religion Name: '" . (optional($sampleUser->getReligion)->name ?? 'N/A') . "'\n";
    echo "- Caste ID: '{$sampleUser->caste}'\n";
    echo "- Caste Name: '" . (optional($sampleUser->getCaste)->name ?? 'N/A') . "'\n";
    echo "- Sub Caste: '{$sampleUser->sub_caste}'\n\n";

    echo "Location Data:\n";
    echo "- Present Country ID: '{$sampleUser->present_country}'\n";
    echo "- Present State ID: '{$sampleUser->present_state}'\n";
    echo "- Present City ID: '{$sampleUser->present_city}'\n";
    echo "- Present Address: '{$sampleUser->present_address}'\n";
    echo "- Permanent Country ID: '{$sampleUser->permanent_country}'\n";
    echo "- Permanent State ID: '{$sampleUser->permanent_state}'\n";
    echo "- Permanent City ID: '{$sampleUser->permanent_city}'\n";
    echo "- Permanent Address: '{$sampleUser->permanent_address}'\n";
    echo "- Present Country Name: '" . (optional($sampleUser->getPresentCountry)->name ?? 'N/A') . "'\n\n";

    echo "Education & Career:\n";
    echo "- Education Level: '{$sampleUser->education_level}'\n";
    echo "- Occupation: '{$sampleUser->occupation}'\n";
    echo "- Company Name: '{$sampleUser->company_name}'\n";
    echo "- Annual Income: '{$sampleUser->annual_income}'\n\n";

    echo "Marital & Family:\n";
    echo "- Marital Status ID: '{$sampleUser->marital_status}'\n";
    echo "- Marital Status Name: '" . (optional($sampleUser->maritalStatus)->name ?? 'N/A') . "'\n";
    echo "- No. of Children: '{$sampleUser->no_of_children}'\n\n";

    echo "Physical Attributes:\n";
    echo "- Body Type: '{$sampleUser->body_type}'\n";
    echo "- Complexion: '{$sampleUser->complexion}'\n";
    echo "- Hair Color: '{$sampleUser->hair_color}'\n";
    echo "- Body Art: '{$sampleUser->body_art}'\n";
    echo "- Ethnicity: '{$sampleUser->ethnicity}'\n\n";

    echo "Partner Expectations:\n";
    echo "- Partner Gender: '{$sampleUser->partner_gender}'\n";
    echo "- Partner Age Min: '{$sampleUser->partner_age_min}'\n";
    echo "- Partner Age Max: '{$sampleUser->partner_age_max}'\n";
    echo "- Partner Height Min: '{$sampleUser->partner_min_height}'\n";
    echo "- Partner Height Max: '{$sampleUser->partner_max_height}'\n";
    echo "- Partner Religion: '{$sampleUser->partner_religion}'\n";
    echo "- Partner Caste: '{$sampleUser->partner_caste}'\n";
    echo "- Partner Education: '{$sampleUser->partner_education}'\n";
    echo "- Partner Country: '{$sampleUser->partner_preferred_country}'\n\n";

    // Check database schema
    echo "=== DATABASE SCHEMA CHECK ===\n";

    $columns = DB::select("DESCRIBE users");
    echo "Users table columns:\n";
    foreach ($columns as $column) {
        echo "- {$column->Field}: {$column->Type} " . ($column->Null === 'YES' ? '(NULLABLE)' : '(NOT NULL)') . "\n";
    }

    echo "\n=== DATA AVAILABILITY SUMMARY ===\n";

    // Check what data is actually populated
    $totalUsers = User::count();
    $activeProfiles = DB::table('profile_infos')->where('status', 1)->count();

    $dataCounts = [
        'gender' => User::whereNotNull('gender')->where('gender', '!=', '')->count(),
        'age' => User::whereNotNull('age')->where('age', '>', 0)->count(),
        'height' => User::whereNotNull('height')->where('height', '!=', '')->count(),
        'religion' => User::whereNotNull('religion')->where('religion', '!=', '')->count(),
        'caste' => User::whereNotNull('caste')->where('caste', '!=', '')->count(),
        'marital_status' => User::whereNotNull('marital_status')->where('marital_status', '!=', '')->count(),
        'present_country' => User::whereNotNull('present_country')->where('present_country', '!=', '')->count(),
        'permanent_country' => User::whereNotNull('permanent_country')->where('permanent_country', '!=', '')->count(),
    ];

    echo "Data Population (Total Users: {$totalUsers}, Active Profiles: {$activeProfiles}):\n";
    foreach ($dataCounts as $field => $count) {
        $percentage = $totalUsers > 0 ? round(($count / $totalUsers) * 100, 1) : 0;
        echo "- {$field}: {$count} users ({$percentage}%)\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}









