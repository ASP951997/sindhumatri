<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\EducationInfo;
use App\Models\CareerInfo;
use App\Models\ProfileInfo;
use App\Models\PurchasedPlanItem;
use App\Models\Shortlist;
use App\Models\ProfileView;
use App\Models\Interest;
use App\Models\Ignore;
use App\Models\Report;
use App\Models\Gallery;
use App\Models\Messenger;
use App\Models\MessengerFile;

echo "Starting deletion of specified users...\n\n";

// List of users to delete (by their IDs found in the search)
$userIdsToDelete = [15, 14, 13, 12, 11, 10, 8];

echo "Users to delete (IDs: " . implode(', ', $userIdsToDelete) . ")\n\n";

$deletedCount = 0;
$totalUsers = count($userIdsToDelete);

foreach ($userIdsToDelete as $userId) {
    $user = User::find($userId);

    if (!$user) {
        echo "User ID {$userId} not found, skipping...\n\n";
        continue;
    }

    echo "Deleting user: {$user->firstname} {$user->lastname} (ID: {$user->id}, Username: {$user->username})\n";

    try {
        // Delete education info
        $educationCount = EducationInfo::where('user_id', $user->id)->delete();
        echo "  ✓ Deleted {$educationCount} education records\n";

        // Delete career info
        $careerCount = CareerInfo::where('user_id', $user->id)->delete();
        echo "  ✓ Deleted {$careerCount} career records\n";

        // Delete profile info
        $profileCount = ProfileInfo::where('user_id', $user->id)->delete();
        echo "  ✓ Deleted {$profileCount} profile records\n";

        // Delete purchased plan items
        $planCount = PurchasedPlanItem::where('user_id', $user->id)->delete();
        echo "  ✓ Deleted {$planCount} purchased plan records\n";

        // Delete shortlists (both as user and member)
        $shortlistCount1 = Shortlist::where('user_id', $user->id)->delete();
        $shortlistCount2 = Shortlist::where('member_id', $user->id)->delete();
        echo "  ✓ Deleted " . ($shortlistCount1 + $shortlistCount2) . " shortlist records\n";

        // Delete profile views (both as user and member)
        $profileViewCount1 = ProfileView::where('user_id', $user->id)->delete();
        $profileViewCount2 = ProfileView::where('member_id', $user->id)->delete();
        echo "  ✓ Deleted " . ($profileViewCount1 + $profileViewCount2) . " profile view records\n";

        // Delete interests
        $interestCount1 = Interest::where('user_id', $user->id)->delete();
        $interestCount2 = Interest::where('member_id', $user->id)->delete();
        echo "  ✓ Deleted " . ($interestCount1 + $interestCount2) . " interest records\n";

        // Delete ignores (both as user and member)
        $ignoreCount1 = Ignore::where('user_id', $user->id)->delete();
        $ignoreCount2 = Ignore::where('member_id', $user->id)->delete();
        echo "  ✓ Deleted " . ($ignoreCount1 + $ignoreCount2) . " ignore records\n";

        // Delete reports
        $reportCount = Report::where('member_id', $user->id)->delete();
        echo "  ✓ Deleted {$reportCount} report records\n";

        // Delete galleries
        $galleryCount = Gallery::where('user_id', $user->id)->delete();
        echo "  ✓ Deleted {$galleryCount} gallery records\n";

        // Delete messengers (both as sender and receiver)
        $messengerCount1 = Messenger::where('sender_id', $user->id)->delete();
        $messengerCount2 = Messenger::where('receiver_id', $user->id)->delete();
        echo "  ✓ Deleted " . ($messengerCount1 + $messengerCount2) . " messenger records\n";

        // Delete messenger files (through messenger relationships)
        $messengerIds = Messenger::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->pluck('id');
        $messengerFileCount = MessengerFile::whereIn('messenger_id', $messengerIds)->delete();
        echo "  ✓ Deleted {$messengerFileCount} messenger file records\n";

        // Finally delete the user
        $user->delete();
        echo "  ✅ Successfully deleted user: {$user->firstname} {$user->lastname} (ID: {$user->id})\n\n";

        $deletedCount++;

    } catch (Exception $e) {
        echo "  ❌ Error deleting user {$user->firstname} {$user->lastname} (ID: {$user->id}): " . $e->getMessage() . "\n\n";
    }
}

echo "Deletion Summary:\n";
echo "================\n";
echo "Total users processed: {$totalUsers}\n";
echo "Successfully deleted: {$deletedCount}\n";
echo "Failed deletions: " . ($totalUsers - $deletedCount) . "\n\n";

echo "All specified user deletions completed.\n";










