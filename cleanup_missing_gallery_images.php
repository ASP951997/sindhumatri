<?php

/**
 * Script to cleanup gallery records that reference missing image files
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "==============================================\n";
echo "Gallery Image Cleanup Script\n";
echo "==============================================\n\n";

$galleries = \App\Models\Gallery::all();
$galleryPath = config('location.gallery.path');

echo "Total gallery records: " . $galleries->count() . "\n\n";

$missingCount = 0;
$validCount = 0;

foreach ($galleries as $gallery) {
    $imagePath = $galleryPath . $gallery->image;
    $thumbPath = $galleryPath . 'thumb_' . $gallery->image;
    
    $imageExists = file_exists($imagePath);
    $thumbExists = file_exists($thumbPath);
    
    if (!$imageExists || !$thumbExists) {
        $missingCount++;
        echo "❌ MISSING - ID: {$gallery->id}, User: {$gallery->user_id}, Image: {$gallery->image}\n";
        echo "   Full image exists: " . ($imageExists ? "YES" : "NO") . "\n";
        echo "   Thumbnail exists: " . ($thumbExists ? "YES" : "NO") . "\n";
        
        // Delete the database record
        $gallery->delete();
        echo "   ✓ Database record deleted\n\n";
    } else {
        $validCount++;
        echo "✓ OK - ID: {$gallery->id}, User: {$gallery->user_id}, Image: {$gallery->image}\n";
    }
}

echo "\n==============================================\n";
echo "SUMMARY:\n";
echo "==============================================\n";
echo "Valid images: {$validCount}\n";
echo "Missing images (cleaned): {$missingCount}\n";
echo "==============================================\n";
echo "\n✓ Cleanup completed!\n";

?>









