<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

Trait  FileUploadTrait
{
    function uploadImage(Request $request ,string $inputName, ?string $oldPath = null , $path= '/uploads') : ?string
    {
        if($request->hasFile($inputName))
        {
            $image = $request->{$inputName};
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'. uniqid(). '.' .$ext;

            $image->move(public_path($path),$imageName);

            //Delete previous image from the storage

            $excludedFolder = '/uploads';

            if($oldPath && File::exists(public_path($path)) && strpos($oldPath,$excludedFolder) !== 0)
            {
                FIle::delete(public_path($oldPath));
            }

            return $path .'/'.$imageName;
        }

        return null;

    }

}