<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $item = Auth::user();

        return view('admin.pages.profil.edit', compact('item'));
    }

    public function update(Request $request)
    {
        $data = [
            'name' => $request->post('name'),
            'surname' => $request->post('surname'),
        ];

        if ($request->file('image')) {

            $dPath = 'profile/';
            $img = $request->file('image');
            $originalName = pathinfo($img->getClientOriginalName(), PATHINFO_FILENAME);
            $exten = $img->getClientOriginalExtension();
            $fName = \Illuminate\Support\Str::slug($originalName) . '-' . uniqid() . '.' . $exten;
            $request->file('image')->storeAs($dPath, $fName);
            $path = $dPath . $fName;
            Storage::disk('public')->put($path, file_get_contents($request->file('image')));

            $data['image'] = $path;
        }

        User::where('id', Auth::user()->id)->update($data);

        return redirect()->back();
    }
}
