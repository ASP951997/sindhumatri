<?php
// Update Blog Image Script
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Blog;
use Illuminate\Support\Facades\File;

// Blog ID from URL
$blogId = 1;

// Find the blog
$blog = Blog::find($blogId);

if (!$blog) {
    die("Blog with ID {$blogId} not found.\n");
}

echo "Current blog image: {$blog->image}\n";

// Image path
$blogImagePath = public_path('assets/uploads/blog/');

// Create directory if it doesn't exist
if (!File::exists($blogImagePath)) {
    File::makeDirectory($blogImagePath, 0755, true);
}

// Generate new filename
$newImageName = 'wedding_couple_' . time() . '.jpg';

echo "Please save the wedding couple image manually to:\n";
echo "{$blogImagePath}{$newImageName}\n\n";
echo "After saving the image, we will update the database.\n\n";

// Ask for confirmation
echo "Have you saved the image? (Press Enter to continue or Ctrl+C to cancel): ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
fclose($handle);

// Check if file exists
if (!File::exists($blogImagePath . $newImageName)) {
    die("Error: Image file not found at {$blogImagePath}{$newImageName}\n");
}

// Delete old image if exists
$oldImage = $blog->image;
if ($oldImage && File::exists($blogImagePath . $oldImage)) {
    File::delete($blogImagePath . $oldImage);
    echo "Deleted old image: {$oldImage}\n";
}

// Update blog with new image
$blog->image = $newImageName;
$blog->save();

echo "\nSuccess! Blog image updated to: {$newImageName}\n";
echo "You can now view the blog at: http://127.0.0.1:8000/blog-details/from-profiles-to-partners-how-anjali-and-karan-found-love-on-spmo-matrimony/1\n";

