<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    public function upload($request, $name, $dir = 'images')
    {
        if (!$request->hasFile($name)) {
            return null;
        }

        $file = $request->file($name);

        // Basic validation (can be enhanced or moved to FormRequest)
        if (!$file->isValid()) {
            throw new \Exception('Invalid file upload.');
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('Invalid file type. Allowed: jpg, png, gif, webp, pdf');
        }

        $exten = $file->getClientOriginalExtension();
        $fName = uniqid(time().'_').'.'.$exten;
        
        // Store only on public disk
        $path = $file->storeAs($dir, $fName, 'public');

        return $path;
    }

    // delete file
    public function deleteFile($fileName = 'files')
    {
        try {
            if ($fileName) {
                Storage::delete('public/files/'.$fileName);
            }

            return true;
        } catch (\Throwable $th) {
            report($th);

            return $th->getMessage();
        }
    }
}
