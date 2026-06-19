<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Service;
use App\Models\Lang;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
        view()->share('langs', $this->langs);
    }

    public function index()
    {
        return view('admin.pages.faq.index');
    }

    public function create()
    {
        $item = new Faq();
        $services = Service::all();
        return view('admin.pages.faq.create', compact('item', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'service_id' => 'nullable|exists:services,id',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.question' => 'required|string',
                $lang->code . '.answer' => 'required|string',
            ])[$lang->code];
        }

        Faq::create($data);

        return redirect()->route('admin.faq.index')->with('success', 'Faq created successfully');
    }

    public function edit($id)
    {
        $item = Faq::findOrFail($id);
        $services = Service::all();
        return view('admin.pages.faq.edit', compact('item', 'services'));
    }

    public function update(Request $request, $id)
    {
        $item = Faq::findOrFail($id);

        $data = $request->validate([
            'category' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
            'service_id' => 'nullable|exists:services,id',
        ]);

        foreach ($this->langs as $lang) {
            $data[$lang->code] = $request->validate([
                $lang->code . '.question' => 'required|string',
                $lang->code . '.answer' => 'required|string',
            ])[$lang->code];
        }

        $item->update($data);

        return redirect()->route('admin.faq.index')->with('success', 'Faq updated successfully');
    }

    public function destroy($id)
    {
        Faq::findOrFail($id)->delete();
        return redirect()->route('admin.faq.index')->with('success', 'Faq deleted successfully');
    }

    public function is_active(Request $request)
    {
        $item = Faq::find($request->id);
        $item->is_active = !$item->is_active;
        $item->save();
    }
}
