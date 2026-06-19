<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CaseStudy;
use App\Models\Lang;
use App\Traits\FileUploader;
use Illuminate\Http\Request;

class CaseStudyController extends Controller
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
        return view('admin.pages.case-study.index');
    }

    public function create()
    {
        $item = new CaseStudy();
        $services = \App\Models\Service::all();
        return view('admin.pages.case-study.create', compact('item', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cover_image' => 'required|image',
            'kpi_data' => 'nullable|array',
            'gallery_images' => 'nullable|array',
            'in_main' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.title' => 'required|string',
                $lang->code . '.slug' => 'required|string|unique:case_study_translations,slug',
                $lang->code . '.problem' => 'nullable|string',
                $lang->code . '.solution' => 'nullable|string',
                $lang->code . '.result' => 'nullable|string',
                $lang->code . '.category' => 'nullable|string',
            ])[$lang->code];
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->uploadFile($request->file('cover_image'), 'case-studies');
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $this->uploadFile($image, 'case-studies/gallery');
            }
            $data['gallery_images'] = $gallery;
        }

        $item = CaseStudy::create($data);
        
        if ($request->has('services')) {
            $item->services()->sync($request->services);
        }

        return redirect()->route('admin.case-study.index')->with('success', 'Case Study created successfully');
    }

    public function edit($id)
    {
        $item = CaseStudy::findOrFail($id);
        $services = \App\Models\Service::all();
        return view('admin.pages.case-study.edit', compact('item', 'services'));
    }

    public function update(Request $request, $id)
    {
        $item = CaseStudy::findOrFail($id);

        $data = $request->validate([
            'cover_image' => 'nullable|image',
            'kpi_data' => 'nullable|array',
            'gallery_images' => 'nullable|array',
            'in_main' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.title' => 'required|string',
                $lang->code . '.slug' => 'required|string|unique:case_study_translations,slug,' . $item->id . ',case_study_id',
                $lang->code . '.problem' => 'nullable|string',
                $lang->code . '.solution' => 'nullable|string',
                $lang->code . '.result' => 'nullable|string',
                $lang->code . '.category' => 'nullable|string',
            ])[$lang->code];
        }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->uploadFile($request->file('cover_image'), 'case-studies');
        }

        // Handle gallery images (append or replace? usually replace or add logic, keeping simple for now)
        if ($request->hasFile('gallery_images')) {
            $gallery = $item->gallery_images ?? [];
            foreach ($request->file('gallery_images') as $image) {
                $gallery[] = $this->uploadFile($image, 'case-studies/gallery');
            }
            $data['gallery_images'] = $gallery;
        }

        $item->update($data);

        if ($request->has('services')) {
            $item->services()->sync($request->services);
        }

        return redirect()->route('admin.case-study.index')->with('success', 'Case Study updated successfully');
    }

    public function destroy($id)
    {
        CaseStudy::findOrFail($id)->delete();
        return redirect()->route('admin.case-study.index')->with('success', 'Case Study deleted successfully');
    }

    public function in_main(Request $request)
    {
        $item = CaseStudy::find($request->id);
        $item->in_main = !$item->in_main;
        $item->save();
    }
}
