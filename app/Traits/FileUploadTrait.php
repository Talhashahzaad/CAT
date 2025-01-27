<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;


trait  FileUploadTrait
{
    // function uploadImage(Request $request, string $inputName, ?string $oldPath = null, $path = '/uploads'): ?string
    // {
    //     if ($request->hasFile($inputName)) {
    //         $image = $request->{$inputName};
    //         $ext = $image->getClientOriginalExtension();
    //         $imageName = 'media_' . uniqid() . '.' . $ext;

    //         $image->move(public_path($path), $imageName);

    //         // Delete previous image from storage
    //         $exculudedFolder = '/default';

    //         if ($oldPath && File::exists(public_path($oldPath)) && strpos($oldPath, $exculudedFolder) !== 0) {
    //             File::delete(public_path($oldPath));
    //         }

    //         return $path . '/' . $imageName;
    //     }

    //     return null;
    // }

    // function uploadMultipleImage(Request $request, string $inputName,  $path = '/uploads'): ?array
    // {
    //     if ($request->hasFile($inputName)) {

    //         if (count($request->{$inputName}) > 15) {
    //             // Return an error message as an array
    //             return ['error' => 'You can upload a maximum of 15 images.'];
    //         }

    //         $images = $request->{$inputName};

    //         $paths = [];

    //         foreach ($images as $image) {

    //             $ext = $image->getClientOriginalExtension();
    //             $imageName = 'media_' . uniqid() . '.' . $ext;
    //             $image->move(public_path($path), $imageName);
    //             $paths[] = $path . '/' . $imageName;
    //         }

    //         return $paths;
    //     }

    //     return null;
    // }
    function uploadImage(Request $request, string $inputName, ?string $oldPath = null, $path = '/uploads'): ?string
    {
        if ($request->hasFile($inputName)) {
            $image = $request->{$inputName};
            $imageName = 'media_' . uniqid() . '.webp';

            // Load, optimize, and save the image as WebP
            Image::load($image->path())
                ->optimize() // Optimize the image
                ->save(public_path($path . '/' . $imageName));

            // Delete previous image from storage
            $exculudedFolder = '/default';

            if ($oldPath && File::exists(public_path($oldPath)) && strpos($oldPath, $exculudedFolder) !== 0) {
                File::delete(public_path($oldPath));
            }

            return $path . '/' . $imageName;
        }

        return null;
    }

    function uploadMultipleImage(Request $request, string $inputName,  $path = '/uploads'): ?array
    {
        if ($request->hasFile($inputName)) {

            if (count($request->{$inputName}) > 15) {
                // Return an error message as an array
                return ['error' => 'You can upload a maximum of 15 images.'];
            }

            $images = $request->{$inputName};

            $paths = [];
            foreach ($images as $image) {
                $imageName = 'media_' . uniqid() . '.webp'; // Set the extension to webp
                Image::load($image->path()) // Use the path method
                    ->optimize() // Optimize the image
                    ->save(public_path($path . '/' . $imageName));

                $paths[] = $path . '/' . $imageName;
            }

            return $paths;
        }

        return null;
    }

    function deleteFile($path): void
    {
        // Delete previous image from storage
        $exculudedFolder = '/default';

        if ($path && File::exists(public_path($path)) && strpos($path, $exculudedFolder) !== 0) {
            File::delete(public_path($path));
        }
    }
}
