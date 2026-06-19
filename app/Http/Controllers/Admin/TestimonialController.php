<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Lang;
use App\Traits\FileUploader;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    use FileUploader;

    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
        view()->share('langs', $this->langs);
    }

    public function index()
    {
        return view('admin.pages.testimonial.index');
    }

    public function create()
    {
        $item = new Testimonial();
        $services = \App\Models\Service::all();
        return view('admin.pages.testimonial.create', compact('item', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'service_id' => 'nullable|exists:services,id',
            'project_type' => 'nullable|string',
            'outcome' => 'nullable|string',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.name' => 'nullable|string',
                $lang->code . '.position' => 'nullable|string',
                $lang->code . '.content' => 'nullable|string',
            ])[$lang->code];
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'testimonials');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial created successfully');
    }

    public function edit($id)
    {
        $item = Testimonial::findOrFail($id);
        $services = \App\Models\Service::all();
        return view('admin.pages.testimonial.edit', compact('item', 'services'));
    }

    public function update(Request $request, $id)
    {
        $item = Testimonial::findOrFail($id);

        $data = $request->validate([
            'platform' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'service_id' => 'nullable|exists:services,id',
            'project_type' => 'nullable|string',
            'outcome' => 'nullable|string',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.name' => 'nullable|string',
                $lang->code . '.position' => 'nullable|string',
                $lang->code . '.content' => 'nullable|string',
            ])[$lang->code];
        }

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadFile($request->file('image'), 'testimonials');
        }

        $item->update($data);

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial updated successfully');
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial deleted successfully');
    }

    public function is_active(Request $request)
    {
        $item = Testimonial::find($request->id);
        $item->is_active = !$item->is_active;
        $item->save();
    }
}
