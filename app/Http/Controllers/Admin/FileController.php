<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($id)
    {
        $portfolio = $portfolio = Portfolio::with('images')->find($id);
        $images = $portfolio->images;

        return view('admin.pages.gallery.create', compact('id', 'images'));
    }

    public function store(Request $request)
    {
        $this->upload($request);

        return back();
    }

    public function upload(Request $request)
    {
        $uploadedFiles = $request->file('files');

        foreach ($uploadedFiles as $file) {
            $filename = uniqid().'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('uploads', $filename);
            Storage::disk('public')->putFileAs('images', $file, $filename);

            // Save file details to the database
            Image::create([
                'url' => 'images/'.$filename,
                'parentable_id' => $request->id,
                'parentable_type' => Portfolio::class,
            ]);
        }

        return 'Files uploaded successfully!';
    }

    public function order(Request $request)
    {
        foreach ($request->get('order') as $id => $order) {
            Image::where('id', $id)->update(['position' => $order]);
        }

        return response()->json([
            'code' => 200,
        ]);
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Delete the image record from the database
        $filePath = 'public/'.$image->url;

        // Delete the image file from the storage disk
        Storage::disk('local')->delete($filePath);
        $image->delete();

        return response()->json([
            'code' => 200,
        ]);
    }
}
