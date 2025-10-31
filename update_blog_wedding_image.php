<?php
/**
 * Script to update blog image with the wedding couple photo
 * Run this after placing the wedding couple image in assets/uploads/blog/
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Blog;
use Illuminate\Support\Facades\DB;

// Blog ID from URL: /blog-details/from-profiles-to-partners-how-anjali-and-karan-found-love-on-spmo-matrimony/1
$blogId = 1;

// New image name - you need to upload the wedding couple image with this name
$newImageName = 'wedding_couple_anjali_karan.jpg';

echo "========================================\n";
echo "Blog Image Update Script\n";
echo "========================================\n\n";

// Find the blog
$blog = Blog::with('details')->find($blogId);

if (!$blog) {
    die("❌ Error: Blog with ID {$blogId} not found.\n");
}

echo "📝 Blog Details:\n";
echo "   ID: {$blog->id}\n";
echo "   Title: " . ($blog->details->title ?? 'N/A') . "\n";
echo "   Current Image: {$blog->image}\n\n";

// Image path
$blogImagePath = public_path('assets/uploads/blog/');
$newImageFullPath = $blogImagePath . $newImageName;

echo "📂 Image Directory: {$blogImagePath}\n";
echo "📸 New Image Name: {$newImageName}\n\n";

// Check if directory exists
if (!is_dir($blogImagePath)) {
    echo "❌ Error: Blog image directory does not exist: {$blogImagePath}\n";
    exit(1);
}

// Instructions
echo "========================================\n";
echo "INSTRUCTIONS:\n";
echo "========================================\n";
echo "1. Save your wedding couple image as: {$newImageName}\n";
echo "2. Upload it to: {$blogImagePath}\n";
echo "3. Press Enter to continue...\n\n";

// Wait for user input
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
fclose($handle);

// Check if new image exists
if (!file_exists($newImageFullPath)) {
    echo "❌ Error: New image not found at: {$newImageFullPath}\n";
    echo "Please upload the image first and run this script again.\n";
    exit(1);
}

echo "✅ Image file found!\n\n";

// Backup old image name
$oldImage = $blog->image;

// Update database
try {
    $blog->image = $newImageName;
    $blog->save();
    
    echo "✅ SUCCESS! Database updated.\n\n";
    echo "Updated Blog Image:\n";
    echo "   Old Image: {$oldImage}\n";
    echo "   New Image: {$newImageName}\n\n";
    echo "🌐 View the updated blog at:\n";
    echo "   http://127.0.0.1:8000/blog-details/from-profiles-to-partners-how-anjali-and-karan-found-love-on-spmo-matrimony/1\n\n";
    
    // Optional: Delete old image
    echo "Do you want to delete the old image file? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $response = trim(fgets($handle));
    fclose($handle);
    
    if (strtolower($response) === 'y') {
        $oldImagePath = $blogImagePath . $oldImage;
        if (file_exists($oldImagePath) && $oldImage !== $newImageName) {
            unlink($oldImagePath);
            echo "✅ Old image deleted: {$oldImage}\n";
        } else {
            echo "⚠️  Old image not found or same as new image.\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error updating database: " . $e->getMessage() . "\n";
    exit(1);
}

echo "\n========================================\n";
echo "Update Complete!\n";
echo "========================================\n";

