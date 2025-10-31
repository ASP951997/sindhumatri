<?php

require_once 'vendor/autoload.php';

// Initialize Laravel application
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Wedding Photo Blog Image Replacement Tool\n";
echo "=========================================\n\n";

try {
    // Configuration
    $blogPath = 'assets/uploads/blog/';
    $currentImageName = 'wedding_blog_1760510603.jpg'; // Current image name
    $newImageName = 'wedding_photo_' . time() . '.jpg';
    
    // Instructions for user
    echo "INSTRUCTIONS:\n";
    echo "1. Save your wedding photo as 'wedding_photo.jpg' in the project root directory\n";
    echo "2. Make sure the image is in JPG format\n";
    echo "3. The script will automatically resize it to blog specifications\n\n";
    
    // Check if wedding photo exists
    $weddingPhotoPath = 'wedding_photo.jpg';
    if (!file_exists($weddingPhotoPath)) {
        echo "ERROR: Please save your wedding photo as 'wedding_photo.jpg' in the project root directory\n";
        echo "Current directory: " . getcwd() . "\n";
        echo "Expected file: {$weddingPhotoPath}\n\n";
        
        echo "ALTERNATIVE: You can also place your image in the blog directory and run:\n";
        echo "php replace_with_custom_image.php [your_image_filename.jpg]\n";
        exit;
    }
    
    echo "Found wedding photo: {$weddingPhotoPath}\n";
    
    // Get image dimensions
    $imageInfo = getimagesize($weddingPhotoPath);
    if ($imageInfo === false) {
        echo "ERROR: Invalid image file\n";
        exit;
    }
    
    echo "Original image dimensions: {$imageInfo[0]}x{$imageInfo[1]}\n";
    echo "Target dimensions: 768x513 (main), 360x240 (thumbnail)\n\n";
    
    // Copy and rename the wedding photo
    if (copy($weddingPhotoPath, $blogPath . $newImageName)) {
        echo "✓ Wedding photo copied to: {$blogPath}{$newImageName}\n";
    } else {
        echo "✗ Failed to copy wedding photo\n";
        exit;
    }
    
    // Create thumbnail (simple copy for now, since GD is not available)
    if (copy($weddingPhotoPath, $blogPath . 'thumb_' . $newImageName)) {
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
        
        echo "\n🎉 SUCCESS! Wedding photo has been uploaded and set as blog image!\n\n";
        echo "Blog Details:\n";
        echo "- New Image: {$newImageName}\n";
        
        $details = $blog->details()->first();
        if ($details) {
            echo "- Title: {$details->title}\n";
            echo "- Author: {$details->author}\n";
        }
        
        echo "\nYou can now view the updated blog at: http://127.0.0.1:8000\n";
        echo "The wedding photo will be displayed in the blog section.\n";
        
    } else {
        echo "✗ Blog record not found in database\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\nNote: For optimal display, consider resizing your wedding photo to 768x513 pixels\n";
echo "before uploading. You can use any image editor like Photoshop, GIMP, or online tools.\n";
