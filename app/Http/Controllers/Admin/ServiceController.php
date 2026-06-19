<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Service;
use App\Models\ServiceTranslation;
use App\Rules\NotNullIfLanguageIsEn;
use App\Traits\FileUploader;
use App\Http\Requests\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use FileUploader;

    protected $langs;

    public function __construct()
    {
        if (!app()->runningInConsole()) {
            view()->share('services', Service::where('parent_id', 0)->get());
            $this->langs = Lang::all();
        } else {
            $this->langs = collect();
        }
    }

    public function index()
    {
        $parent = request()->get('parent') ?? 0;
        $items = Service::where('parent_id', $parent)->get();

        return view('admin.pages.service.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Service();
        $parents = Service::parents()->get();

        return view('admin.pages.service.create', compact('item', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
    {
        $data = $request->only(['parent_id', 'cta_link']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload($request, 'image', 'services');
        }

        if ($request->hasFile('icon')) {
            $data['icon'] = $this->upload($request, 'icon', 'services');
        }

        foreach ($this->langs as $lang) {
            $locale = $lang->lang;
            if ($request->has("name.$locale")) {
                $data[$locale] = [
                    'name' => $request->input("name.$locale"),
                    'content' => $request->input("content.$locale"),
                    'description' => $request->input("description.$locale"),
                    'cta_text' => $request->input("cta_text.$locale"),
                    'slug' => Str::slug($request->input("name.$locale")),
                ];
            }
        }

        Service::create($data);

        return redirect()->route('admin.service.index')->with('success', 'Service created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Service::findOrFail($id);
        $parents = Service::parents()->where('id', '!=', $id)->get(); // Prevent self-parenting

        return view('admin.pages.service.edit', compact('item', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceRequest $request, $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->only(['parent_id', 'cta_link']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->upload($request, 'image', 'services');
        }

        if ($request->hasFile('icon')) {
            $data['icon'] = $this->upload($request, 'icon', 'services');
        }

        // Capture old attributes for activity log
        $oldAttributes = [
            'name' => $service->name,
            'content' => $service->content, // Raw content
            'description' => $service->description,
            'cta_text' => $service->cta_text,
            'slug' => $service->slug,
            'status' => $service->status,
            'parent_id' => $service->parent_id,
            'cta_link' => $service->cta_link,
            'icon' => $service->icon,
            'image' => $service->image,
        ];

        // Capture old translations for all locales
        foreach ($this->langs as $lang) {
            $locale = $lang->lang;
            $trans = $service->translate($locale);
            if ($trans) {
                $oldAttributes["name_{$locale}"] = $trans->name;
                $oldAttributes["content_{$locale}"] = $trans->content;
                $oldAttributes["description_{$locale}"] = $trans->description;
                $oldAttributes["cta_text_{$locale}"] = $trans->cta_text;
            }
        }

        // Update main attributes
        $service->fill($data);
        $service->save();

        // Update translations explicitly
        foreach ($this->langs as $lang) {
            $locale = $lang->lang;
            if ($request->has("name.$locale")) {
                $translation = $service->translateOrNew($locale);
                $translation->name = $request->input("name.$locale");
                $translation->content = $request->input("content.$locale");
                $translation->description = $request->input("description.$locale");
                $translation->cta_text = $request->input("cta_text.$locale");
                $translation->slug = Str::slug($request->input("name.$locale"));
                $translation->save();
            }
        }

        $service->refresh();

        // Prepare new attributes
        $newAttributes = [
            'name' => $service->name,
            'content' => $service->content,
            'description' => $service->description,
            'cta_text' => $service->cta_text,
            'slug' => $service->slug,
            'status' => $service->status,
            'parent_id' => $service->parent_id,
            'cta_link' => $service->cta_link,
            'icon' => $service->icon,
            'image' => $service->image,
        ];

        // Capture new translations
        foreach ($this->langs as $lang) {
            $locale = $lang->lang;
            $trans = $service->translate($locale);
            if ($trans) {
                $newAttributes["name_{$locale}"] = $trans->name;
                $newAttributes["content_{$locale}"] = $trans->content;
                $newAttributes["description_{$locale}"] = $trans->description;
                $newAttributes["cta_text_{$locale}"] = $trans->cta_text;
            }
        }

        // Manually log activity with full details
        activity()
           ->performedOn($service)
           ->causedBy(auth()->user())
           ->withProperties([
               'attributes' => $newAttributes,
               'old' => $oldAttributes
           ])
           ->tap(new \App\ActivityLog\IpAddressAndUserAgentTap())
           ->log('updated');

        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Service::find($id)->delete();

        return response()->json(['code' => 200]);
    }

    public function in_main(Request $request)
    {
        $item = Service::find($request->id);
        $item->in_main = !$item->in_main;
        $item->save();
    }
}