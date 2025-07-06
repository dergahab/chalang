<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\UpdateRequest;
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

        $this->handleImageUpload($request, $data, 'image');
        $this->handleImageUpload($request, $data, 'icon');

        DB::beginTransaction();
        try {
            $service = Service::create($data);
            foreach ($this->langs as $lang) {
                $name = $request->post('name')[$lang->lang] ?? null;
                if ($name) {
                    ServiceTranslation::updateOrCreate(
                        [
                            'service_id' => $service->id,
                            'locale' => $lang->lang,
                        ],
                        [
                            'name' => $name,
                            'content' => $request->post('content')[$lang->lang] ?? '',
                            'description' => $request->post('description')[$lang->lang] ?? '',
                            'slug' => Str::slug($name),
                        ]
                    );
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
    public function update(UpdateRequest $request, $id)
    {
        $data = [];
        $data['parent_id'] = $request->parent_id ?? 0;
        $data['in_main'] = $request->post('in_main');

        $this->handleImageUpload($request, $data, 'image');
        $this->handleImageUpload($request, $data, 'icon');
        $data['slug'] = Str::slug($request->post('name')['az']);

        DB::beginTransaction();
        try {
            $service = Service::find($id);
            $service->update($data);
            foreach ($this->langs as $lang) {
                $name = $request->post('name')[$lang->lang] ?? null;
                if ($name) {
                    ServiceTranslation::updateOrCreate(
                        [
                            'service_id' => $service->id,
                            'locale' => $lang->lang,
                        ],
                        [
                            'name' => $name,
                            'content' => $request->post('content')[$lang->lang] ?? '',
                            'description' => $request->post('description')[$lang->lang] ?? '',
                            'slug' => Str::slug($name ?? uniqid()),
                        ]
                    );
                }
            }
            DB::commit();
            session()->flash('success','Service updated succesfuly ');
            return redirect()->route('admin.pages.service.edit', $id);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error',$e->getMessage());
            return redirect()->route('admin.service.edit', $id);
        }
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

    /**
     * Helper to handle image upload and update data array.
     */
    private function handleImageUpload(Request $request, array &$data, $field)
    {
        if ($request->hasFile($field)) {
            $data[$field] = $this->upload($request, name: $field, dir: 'services');
        }
    }
}
