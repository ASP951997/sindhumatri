<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    echo "=== CREATING SINGLE ADMIN ACCOUNT ===\n\n";

    // Show current accounts before cleanup
    $currentCount = DB::table('admins')->count();
    echo "📊 Current admin accounts: $currentCount\n\n";

    // Delete all existing admin accounts
    echo "🗑️  Deleting all existing admin accounts...\n";
    DB::table('admins')->delete();

    // Verify deletion
    $afterDelete = DB::table('admins')->count();
    echo "✅ Deleted. Remaining accounts: $afterDelete\n\n";

    // Create single admin account
    echo "👤 Creating new admin account...\n";

    $adminData = [
        'id' => 1,
        'name' => 'SPMO',
        'username' => 'SPMO',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin123'),
        'image' => '636b2d4c95edf1667968332.jpg',
        'phone' => '8669819924',
        'address' => 'OFF NO: 11, UPPER FLOOR, SAI PLAZA, SAI CHOWK, PIMPRI-PUNE-411017.',
        'admin_access' => '["admin.dashboard","admin.staff","admin.storeStaff","admin.updateStaff","admin.planList","admin.planCreate","admin.planEdit","admin.planDelete","admin.sold.planList","admin.soldPlan.search","admin.storyList","admin.story.search","admin.storyApprove","admin.storyPending","admin.storyDelete","admin.reportList","admin.reportList.search","admin.report.delete","admin.transaction","admin.transaction.search","admin.users","admin.users.search","admin.email-send","admin.user.transaction","admin.user.fundLog","admin.user.withdrawal","admin.user-edit","admin.onBehalfList","admin.maritalStatusList","admin.familyValueList","admin.religionList","admin.casteList","admin.subCasteList","admin.countryList","admin.stateList","admin.cityList","admin.onBehalfCreate","admin.maritalStatusCreate","admin.familyValueCreate","admin.religionCreate","admin.casteCreate","admin.subCasteCreate","admin.countryCreate","admin.stateCreate","admin.cityCreate","admin.user-multiple-active","admin.user-multiple-inactive","admin.send-email","admin.user-balance-update","admin.onBehalfEdit","admin.maritalStatusEdit","admin.familyValueEdit","admin.religionEdit","admin.casteEdit","admin.subCasteEdit","admin.countryEdit","admin.stateEdit","admin.cityEdit","admin.onBehalfDelete","admin.maritalStatusDelete","admin.familyValueDelete","admin.religionDelete","admin.casteDelete","admin.subCasteDelete","admin.countryDelete","admin.stateDelete","admin.cityDelete","admin.payment.methods","admin.deposit.manual.index","admin.deposit.manual.create","admin.edit.payment.methods","admin.deposit.manual.edit","admin.payment.pending","admin.payment.log","admin.payment.search","admin.payment.action","admin.ticket","admin.ticket.view","admin.ticket.reply","admin.ticket.delete","admin.subscriber.index","admin.subscriber.sendEmail","admin.subscriber.remove","admin.basic-controls","admin.email-controls","admin.email-template.show","admin.sms.config","admin.sms-template","admin.notify-config","admin.notify-template.show","admin.notify-template.edit","admin.basic-controls.update","admin.email-controls.update","admin.email-template.edit","admin.sms-template.edit","admin.notify-config.update","admin.notify-template.update","admin.language.index","admin.language.create","admin.language.edit","admin.language.keywordEdit","admin.language.delete","admin.manage.theme","admin.logo-seo","admin.breadcrumb","admin.template.show","admin.content.index","admin.blogCategory","admin.blogList","admin.content.create","admin.blogCategoryCreate","admin.blogCreate","admin.logoUpdate","admin.seoUpdate","admin.breadcrumbUpdate","admin.content.show","admin.blogCategoryEdit","admin.blogEdit","admin.content.delete","admin.blogCategoryDelete","admin.blogDelete"]',
        'last_login' => now(),
        'status' => 1,
        'remember_token' => null,
        'created_at' => now(),
        'updated_at' => now()
    ];

    $newAdminId = DB::table('admins')->insertGetId($adminData);

    echo "✅ New admin account created with ID: $newAdminId\n\n";

    // Final verification
    echo "📋 FINAL ADMIN ACCOUNT:\n";
    $finalAdmin = DB::table('admins')->first();

    if ($finalAdmin) {
        echo "  👤 Username: {$finalAdmin->username}\n";
        echo "  📧 Email: {$finalAdmin->email}\n";
        echo "  🔒 Password: admin123\n";
        echo "  📞 Phone: {$finalAdmin->phone}\n";
        echo "  📍 Address: " . substr($finalAdmin->address, 0, 50) . "...\n";
        echo "  📊 Status: " . ($finalAdmin->status == 1 ? 'Active' : 'Inactive') . "\n";
        echo "  🆔 ID: {$finalAdmin->id}\n\n";

        echo "🎉 SUCCESS! Single admin account created and ready!\n\n";

        echo "🔐 LOGIN CREDENTIALS:\n";
        echo "   Username: SPMO\n";
        echo "   Password: admin123\n\n";

        echo "🌐 LOGIN URLs:\n";
        echo "   Local:  http://127.0.0.1:8000/admin/login\n";
        echo "   Live:   https://sindhumatri.com/admin/login\n\n";

        echo "📝 REMEMBER:\n";
        echo "- After uploading database to live, use these same credentials\n";
        echo "- Only one admin account exists now\n";
        echo "- All duplicates have been removed\n";

    } else {
        echo "❌ ERROR: Failed to create admin account!\n";
    }

} catch (Exception $e) {
    echo '❌ Error: ' . $e->getMessage() . "\n";
}

?>




