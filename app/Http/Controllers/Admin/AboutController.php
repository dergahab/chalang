<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\AboutTranslation;
use App\Models\Lang;
use Cassandra\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller {
    public $langs;

    public function __construct() {
        $this->langs = Lang::all();
    }
    public function index() {
        $item = About::first() ?? new About();
        return view('admin.pages.about.edit', compact('item'));
    }

    public function update(Request $request, $id) {

        $about = About::find($id);
        if($request->image) {
            $originalName = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->image->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            Storage::disk('public')->putFileAs('portfolio', $request->image, $filename);
            $about->image = 'portfolio/'.$filename;
        }

        if($request->image) {
            $originalName = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->image->getClientOriginalExtension();
            $filename = \Illuminate\Support\Str::slug($originalName) . '-' . uniqid() . '.' . $extension;
            Storage::disk('public')->putFileAs('about', $request->image, $filename);
            $about->image = 'about/'.$filename;
        }
        $about->save();


        DB::beginTransaction();
        //    dd($request->post('title')['az']);
        try {
            foreach($this->langs as $l) {
                if($request->name[$l->lang]) {
                    AboutTranslation::updateOrCreate(

                        ['about_id' => $id, 'locale' => $l->lang],
                        [
                            'title' => $request->name[$l->lang],
                            'description' => $request->description[$l->lang],
                            'locale' => $l->lang,
                            'about_id' => $id,
                        ]
                    );
                }
            }
            DB::commit();

            return redirect()->route('admin.about.index')->with('success', 'Məlumat uğurla yeniləndi');
        } catch (\Exception $e) {
            DB::rollback();

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }
}
