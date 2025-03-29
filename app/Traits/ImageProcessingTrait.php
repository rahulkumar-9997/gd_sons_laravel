<?php
namespace App\Traits;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait ImageProcessingTrait
{
    public function saveImageStorageWebp($image, $filename)
    {
        $storagePath = 'images/storage/';
        $fullPath = public_path($storagePath);
        if (!file_exists($fullPath)) {
            mkdir($fullPath, 0755, true);
        }
        
        $img = Image::make($image);
        $img->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $img->encode('webp', 90)->save($fullPath . $filename);
    }

    public function saveProductImages($image, $image_file_name){
        $destination_path_large = public_path('images/product/large/');
        //$img_large = Image::make($image->getRealPath());
        $img_large = Image::make($image);
        $img_large->resize(1920, 1080, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_large . '/' . $image_file_name);
        // SMALL IMAGE (800x600)
        $destination_path_small = public_path('images/product/small/');
        // $img_small = Image::make($image->getRealPath());
        $img_small = Image::make($image);
        $img_small->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_small . '/' . $image_file_name);
        // THUMB IMAGE (250x250)
        $destination_path_thumb = public_path('images/product/thumb/');
        //$img_thumb = Image::make($image->getRealPath());
        $img_thumb = Image::make($image);
        $img_thumb->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_thumb . '/' . $image_file_name);
        // ICON IMAGE (150x150)
        $destination_path_icon = public_path('images/product/icon/');
        //$img_icon = Image::make($image->getRealPath());
        $img_icon = Image::make($image);
        $img_icon->resize(200, 150, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('webp', 90)->save($destination_path_icon . '/' . $image_file_name);
        // ORIGINAL IMAGE (save as WebP)
        $destinationPath = public_path('images/product/original/');
        // $img_original = Image::make($image->getRealPath());
        $img_original = Image::make($image);
        $img_original->encode('webp', 90)->save($destinationPath . '/' . $image_file_name);
    }

    public function saveProductImagesToJpg($image, $image_file_name){
        $destination_path_thumb = public_path('images/product/jpg-image/thumb/');
        File::ensureDirectoryExists($destination_path_thumb);
        // $img_thumb = Image::make($image->getRealPath());
        $img_thumb = Image::make($image);
        $img_thumb->resize(250, 250, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg', 90)->save($destination_path_thumb . '/' . $image_file_name);        
    }

}
