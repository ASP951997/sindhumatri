<?php
// check_missing_tables.php - Check which tables are missing after partial import

$servername = "localhost";
$username = "your_live_db_username";  // Replace with your actual database username
$password = "your_live_db_password";  // Replace with your actual database password
$dbname = "u105084344_matrimony";

// Expected tables from your backup
$expectedTables = [
    'admins', 'users', 'affection_fors', 'affection_for_details', 'blogs',
    'castes', 'cities', 'complexions', 'complexion_details', 'communities',
    'community_value_details', 'configures', 'content_details', 'content_media',
    'contents', 'countries', 'education_infos', 'email_templates', 'ethnicities',
    'ethnicity_details', 'failed_jobs', 'family_values', 'family_value_details',
    'funds', 'galleries', 'hair_colors', 'hair_color_details', 'hobbies',
    'hobby_details', 'horoscopes', 'horoscope_details', 'humors', 'humor_details',
    'interests', 'interest_details', 'jobs', 'languages', 'language_details',
    'marital_statuses', 'marital_status_details', 'member_types', 'messages',
    'migrations', 'mother_tongues', 'notify_templates', 'occupations', 'on_behalfs',
    'on_behalf_details', 'packages', 'partner_educations', 'payments', 'physical_attributes',
    'plans', 'political_views', 'political_view_details', 'professions', 'profile_checks',
    'reference_users', 'reference_user_details', 'religions', 'religious_services',
    'reports', 'sms_templates', 'states', 'stories', 'sub_castes', 'subscribers',
    'successful_stories', 'user_fund_logs', 'user_multiple_photos', 'user_photos',
    'user_transactions', 'user_withdrawals', 'wallet_histories', 'whatsapps'
];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

echo "🔌 Connected to database: $dbname<br><br>";

// Get existing tables
$existingTables = [];
$result = $conn->query("SHOW TABLES");
if ($result) {
    while ($row = $result->fetch_array()) {
        $existingTables[] = $row[0];
    }
}

echo "📊 Existing tables: " . count($existingTables) . "<br>";
echo "🎯 Expected tables: " . count($expectedTables) . "<br><br>";

// Find missing tables
$missingTables = array_diff($expectedTables, $existingTables);

if (empty($missingTables)) {
    echo "✅ ALL TABLES EXIST - Import was successful!<br><br>";
    echo "👥 User count: ";
    $userResult = $conn->query("SELECT COUNT(*) as count FROM users");
    if ($userResult) {
        echo $userResult->fetch_assoc()['count'] . "<br>";
    }

    echo "👨‍💼 Admin count: ";
    $adminResult = $conn->query("SELECT COUNT(*) as count FROM admins");
    if ($adminResult) {
        echo $adminResult->fetch_assoc()['count'] . "<br>";
    }

} else {
    echo "❌ MISSING TABLES: " . count($missingTables) . "<br><br>";
    foreach ($missingTables as $table) {
        echo "  - $table<br>";
    }
    echo "<br>🚨 SOLUTION: Re-run the import with proper settings<br>";
}

echo "<br>🔧 RECOMMENDED ACTION:<br>";
if (!empty($missingTables)) {
    echo "1. Drop all existing tables<br>";
    echo "2. Re-import the SQL file with foreign key checks disabled<br>";
    echo "3. Or create missing tables manually<br>";
} else {
    echo "✅ Database import appears successful!<br>";
    echo "🌐 Test login: https://sindhumatri.com/admin/login<br>";
    echo "   Username: SPMO<br>";
    echo "   Password: admin123<br>";
}

$conn->close();
?>




