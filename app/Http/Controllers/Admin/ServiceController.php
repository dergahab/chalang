<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lang;
use App\Models\Service;
use App\Models\ServiceTranslation;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    use FileUploader;

    protected $langs;

    public function __construct()
    {
        view()->share('services', Service::where('parent_id', 0)->get());
        $this->langs = Lang::all();
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

        return view('admin.pages.service.create', compact('item'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [];
        $data['parent_id'] = $request->parent_id ?? 0;

        if ($request->image) {
            $image = $this->upload($request, name: 'image', dir: 'services');
            $data['image'] = $image;
        }

        if ($request->icon) {
            $image = $this->upload($request, name: 'icon', dir: 'services');
            $data['icon'] = $image;
        }
        $data['slug'] = Str::slug($request->post('name')['az']);
        DB::beginTransaction();
        try {

            $service = Service::create($data);
            foreach ($this->langs as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    ServiceTranslation::insert([
                        'name' => $request->post('name')[$lang->lang],
                        'content' => $request->post('content')[$lang->lang],
                        'description' => $request->post('description')[$lang->lang],
                        'locale' => $lang->lang,
                        'service_id' => $service->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'code' => 401,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

        return view('admin.pages.service.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = [];
        $data['parent_id'] = $request->parent_id ?? 0;

        if ($request->image) {
            $image = $this->upload($request, name: 'image', dir: 'services');
            $data['image'] = $image;
        }

        if ($request->icon) {
            $image = $this->upload($request, name: 'icon', dir: 'services');
            $data['icon'] = $image;
        }
        $data['slug'] = Str::slug($request->post('name')['az']);

        DB::beginTransaction();
        try {

            $serive = Service::find($id);
            $serive->update($data);
            foreach ($this->langs as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    $translation = ServiceTranslation::where('service_id', $id)->where('locale', $lang->lang)->first();
                    if (! $translation) {
                        $translation = new ServiceTranslation();
                        $translation->serice_id = $serive->id;
                        $translation->locale = $lang->lang;
                    }
                    $translation->name = $request->post('name')[$lang->lang] ?? $translation->name;
                    $translation->content = $request->post('content')[$lang->lang] ?? $translation->content;
                    $translation->description = $request->post('description')[$lang->lang] ?? $translation->description;
                    $translation->slug = Str::slug($request->post('name')[$lang->lang]) ?? $translation->slug;
                    $translation->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'code' => 401,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('admin.service.index');
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
        $item->in_main = ! $item->in_main;
        $item->save();
    }
}
