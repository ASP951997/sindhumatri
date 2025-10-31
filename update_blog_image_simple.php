<?php
// Simple blog image updater
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Blog;

$blog = Blog::find(1);
if ($blog) {
    echo "Current image: " . $blog->image . "\n";
    
    // Update to new wedding couple image
    $blog->image = 'wedding_couple_anjali_karan.jpg';
    $blog->save();
    
    echo "Updated image: " . $blog->image . "\n";
    echo "SUCCESS! Please refresh the blog page.\n";
} else {
    echo "Blog not found\n";
}

