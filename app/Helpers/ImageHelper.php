<?php

namespace App\Helpers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ImageHelper
{
    public static function generateFileName($name, $prefix = 'gd-sons')
    {
        $cleanName = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', strtolower($name)));
        $cleanName = $cleanName ?: 'image';
        $timestamp = round(microtime(true) * 1000);
        return $prefix . '-' . $cleanName . '-' . $timestamp;
    }    

    public static function getImageDirectories($folder = 'category')
    {
        $basePath = storage_path("app/public/images/{$folder}/");
        return [
            'large'    => $basePath . 'large/',
            'small'    => $basePath . 'small/',
            'thumb'    => $basePath . 'thumb/',
            'icon'     => $basePath . 'icon/',
            'original' => $basePath . 'original/',
        ];
    }

    public static function createDirectories($directories)
    {
        foreach ($directories as $path) {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }
    }

    public static function uploadImage($image, $name, $folder = 'category', $oldImage = null)
    {
        $fileName = $name . '.webp';
        $directories = self::getImageDirectories($folder);
        self::createDirectories($directories);
        if ($oldImage) {
            self::deleteImage($oldImage, $folder);
        }

        $imagePath = $image->getRealPath();
        $sizes = [
            'large' => [1920, 1080],
            'small' => [800, 600],
            'thumb' => [300, 300],
            'icon'  => [100, 100],
        ];

        foreach ($sizes as $key => [$width, $height]) {
            Image::make($imagePath)
                ->fit($width, $height)
                ->encode('webp', 90)
                ->save($directories[$key] . $fileName);
        }

        Image::make($imagePath)
            ->encode('webp', 90)
            ->save($directories['original'] . $fileName);

        return $fileName;
    }

    public static function deleteImage($imageName, $folder = 'category')
    {
        if (empty($imageName)) {
            return false;
        }
        $directories = self::getImageDirectories($folder);
        $deleted = false;
        foreach ($directories as $path) {
            $file = $path . $imageName;
            if (File::exists($file)) {
                File::delete($file);
                $deleted = true;
            }
        }
        return $deleted;
    }

    public static function deleteSingleImage($imageName, $folder = 'simple')
    {
        if (empty($imageName)) {
            return false;
        }
        $path = storage_path("app/public/images/{$folder}/" . $imageName);
        if (File::exists($path)) {
            return File::delete($path);
        }
        return false;
    }

    public static function uploadSingleImageWebpOnly($image, $name, $folder = 'simple', $oldImage = null)
    {
        if (!$image || !$image->isValid()) {
            return null;
        }
        $fileName = $name . '.webp';
        $path = storage_path("app/public/images/{$folder}/");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        if (!empty($oldImage)) {
            $oldPath = $path . $oldImage;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }
        try {
            Image::make($image->getRealPath())
                ->encode('webp', 90)
                ->save($path . $fileName);
            return $fileName;

        } catch (\Exception $e) {
            Log::error('Single Image Upload Error: ' . $e->getMessage());
            return null;
        }
    }    
    
    public static function uploadPdf($file, $name, $folder, $oldFile = null)
    {
        if (!$file || !$file->isValid()) {
            return null;
        }
        $fileName = $name . '.pdf';
        $path = storage_path("app/public/pdf/{$folder}/");
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
        if (!empty($oldFile)) {
            $oldPath = $path . $oldFile;
            if (File::exists($oldPath)) {
                File::delete($oldPath);
            }
        }

        try {
            $file->move($path, $fileName);
            return $fileName;

        } catch (\Exception $e) {
            Log::error('PDF Upload Error: ' . $e->getMessage());
            return null;
        }
    }

    public static function pdfFileDelete($pdfFileName, $folder)
    {
        if (empty($pdfFileName)) {
            return false;
        }
        $path = storage_path("app/public/pdf/{$folder}/" . $pdfFileName);
        if (File::exists($path)) {
            return File::delete($path);
        }
        return false;
    }
}