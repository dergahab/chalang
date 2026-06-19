<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Lang;
use App\Traits\FileUploader;
use Illuminate\Http\Request;

class PartnerController extends Controller
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
        return view('admin.pages.partner.index');
    }

    public function create()
    {
        $item = new Partner();
        return view('admin.pages.partner.create', compact('item'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'logo' => 'nullable|image',
            'link' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.description' => 'nullable|string',
            ])[$lang->code];
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadFile($request->file('logo'), 'partners');
        }

        Partner::create($data);

        return redirect()->route('admin.partner.index')->with('success', 'Partner created successfully');
    }

    public function edit($id)
    {
        $item = Partner::findOrFail($id);
        return view('admin.pages.partner.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Partner::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'logo' => 'nullable|image',
            'link' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.description' => 'nullable|string',
            ])[$lang->code];
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadFile($request->file('logo'), 'partners');
        }

        $item->update($data);

        return redirect()->route('admin.partner.index')->with('success', 'Partner updated successfully');
    }

    public function destroy($id)
    {
        Partner::findOrFail($id)->delete();
        return redirect()->route('admin.partner.index')->with('success', 'Partner deleted successfully');
    }

    public function is_active(Request $request)
    {
        $item = Partner::find($request->id);
        $item->is_active = !$item->is_active;
        $item->save();
    }
}
