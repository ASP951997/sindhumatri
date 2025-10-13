<?php

namespace App\Http\Traits;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;

trait Upload
{
    public function makeDirectory($path)
    {
        if (file_exists($path)) return true;
        return mkdir($path, 0755, true);
    }

    public function removeFile($path)
    {
        return file_exists($path) && is_file($path) ? @unlink($path) : false;
    }

    public function uploadImage($file, $location, $size = null, $old = null, $thumb = null, $filename = null)
    {
        $path = $this->makeDirectory($location);
        if (!$path) throw new \Exception('File could not been created.');

        if (!empty($old)) {
            $this->removeFile($location . '/' . $old);
            $this->removeFile($location . '/thumb_' . $old);
        }

        if ($filename == null) {
            $filename = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        }

        // Create ImageManager instance for Intervention Image v3
        // Try GD first, then Imagick, then fallback to simple file copy
        $hasImageExtension = false;
        $manager = null;
        $image = null;
        
        try {
            if (extension_loaded('gd')) {
                $manager = new ImageManager(new Driver());
                $hasImageExtension = true;
            } elseif (extension_loaded('imagick')) {
                $manager = new ImageManager(new ImagickDriver());
                $hasImageExtension = true;
            }
            
            if ($hasImageExtension) {
                $image = $manager->read($file);
            }
        } catch (\Exception $e) {
            $hasImageExtension = false;
        }

        // Process and save main image
        if ($hasImageExtension && $image) {
            // Use image library to resize if needed
            if (!empty($size)) {
                $size = explode('x', strtolower($size));
                $image->resize($size[0], $size[1]);
            }
            $image->save($location . '/' . $filename);
        } else {
            // Fallback: just copy the file without processing
            if (!copy($file->getRealPath(), $location . '/' . $filename)) {
                throw new \Exception('Failed to copy image file');
            }
        }

        // Create thumbnail if requested
        if (!empty($thumb)) {
            if ($hasImageExtension && $manager) {
                // Use image library to create resized thumbnail
                $thumb = explode('x', $thumb);
                try {
                    $thumbImage = $manager->read($file);
                    $thumbImage->resize($thumb[0], $thumb[1])->save($location . '/thumb_' . $filename);
                } catch (\Exception $e) {
                    // If thumbnail creation fails, just copy the original as thumbnail
                    copy($file->getRealPath(), $location . '/thumb_' . $filename);
                }
            } else {
                // Fallback: copy the original file as thumbnail
                if (!copy($file->getRealPath(), $location . '/thumb_' . $filename)) {
                    throw new \Exception('Failed to create thumbnail');
                }
            }
        }
        
        return $filename;
    }


}

