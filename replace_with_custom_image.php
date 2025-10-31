<?php

require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Custom Image Blog Replacement Tool\n";
echo "=================================\n\n";

try {
    // Get image filename from command line argument
    $imageFilename = $argv[1] ?? null;
    
    if (!$imageFilename) {
        echo "USAGE: php replace_with_custom_image.php [image_filename]\n\n";
        echo "EXAMPLES:\n";
        echo "php replace_with_custom_image.php wedding_photo.jpg\n";
        echo "php replace_with_custom_image.php my_image.png\n";
        echo "php replace_with_custom_image.php ../photos/couple.jpg\n\n";
        exit;
    }
    
    // Configuration
    $blogPath = 'assets/uploads/blog/';
    $currentImageName = 'wedding_blog_1760510603.jpg'; // Current image name
    $newImageName = 'custom_blog_' . time() . '.' . pathinfo($imageFilename, PATHINFO_EXTENSION);
    
    // Check if image exists
    if (!file_exists($imageFilename)) {
        echo "ERROR: Image file not found: {$imageFilename}\n";
        echo "Please check the file path and try again.\n";
        exit;
    }
    
    echo "Found image: {$imageFilename}\n";
    
    // Get image dimensions
    $imageInfo = getimagesize($imageFilename);
    if ($imageInfo === false) {
        echo "ERROR: Invalid image file\n";
        exit;
    }
    
    echo "Image dimensions: {$imageInfo[0]}x{$imageInfo[1]}\n";
    echo "Target dimensions: 768x513 (main), 360x240 (thumbnail)\n\n";
    
    // Copy and rename the image
    if (copy($imageFilename, $blogPath . $newImageName)) {
        echo "✓ Image copied to: {$blogPath}{$newImageName}\n";
    } else {
        echo "✗ Failed to copy image\n";
        exit;
    }
    
    // Create thumbnail
    if (copy($imageFilename, $blogPath . 'thumb_' . $newImageName)) {
        echo "✓ Thumbnail created: {$blogPath}thumb_{$newImageName}\n";
    } else {
        echo "✗ Failed to create thumbnail\n";
    }
    
    // Update database
    $blog = \App\Models\Blog::where('image', $currentImageName)->first();
    if ($blog) {
        $blog->image = $newImageName;
        $blog->save();
        echo "✓ Database updated successfully\n";
        
        // Remove old files
        if (file_exists($blogPath . $currentImageName)) {
            unlink($blogPath . $currentImageName);
            echo "✓ Old main image removed\n";
        }
        
        if (file_exists($blogPath . 'thumb_' . $currentImageName)) {
            unlink($blogPath . 'thumb_' . $currentImageName);
            echo "✓ Old thumbnail removed\n";
        }
        
        echo "\n🎉 SUCCESS! Custom image has been uploaded and set as blog image!\n\n";
        echo "Blog Details:\n";
        echo "- New Image: {$newImageName}\n";
        
        $details = $blog->details()->first();
        if ($details) {
            echo "- Title: {$details->title}\n";
            echo "- Author: {$details->author}\n";
        }
        
        echo "\nYou can now view the updated blog at: http://127.0.0.1:8000\n";
        
    } else {
        echo "✗ Blog record not found in database\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
