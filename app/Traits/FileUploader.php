<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    public function upload($request, $name, $dir = 'images')
    {
        $dPath = $dir;
        $img = $request->file($name);
        $exten = $img->getClientOriginalExtension();
        $fName = preg_replace('/\..+$/', '', $img->getClientOriginalName()).'.'.$exten;
        $request->file($name)->storeAs($dPath, $fName);
        $path = $dPath.'/'.$fName;
        Storage::disk('public')->put($path, file_get_contents($request->file($name)));

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
