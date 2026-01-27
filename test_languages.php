<?php
// test_languages.php - Test languages table connection

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Testing languages table...\n";

try {
    $count = DB::table('languages')->count();
    echo "✅ Languages table has $count records\n";

    $languages = DB::table('languages')->get();
    foreach ($languages as $lang) {
        echo "  - {$lang->name} ({$lang->short_name})\n";
    }

    echo "\n✅ Database connection successful!\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>


