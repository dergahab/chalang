<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceContent\StoreRequest;
use App\Http\Requests\ServiceContentRequest;
use App\Models\Lang;
use App\Models\Service;
use App\Models\ServisContent;
use App\Services\ServiceContentService;
use Illuminate\Http\Request;

class ServiceContentController extends Controller
{
    protected $serviscontent;
    public function __construct(protected ServisContent $servisContent, protected Lang $langs)
    {
        view()->share('services', Service::where('parent_id', '<>', 0)->get());
    }

    public function index()
    {
        return view('admin.pages.service-contnet.index');
    }


    public function create()
    {
        $item = $this->servisContent;
        return view('admin.pages.service-contnet.create', compact('item'));
    }

       public function store(StoreRequest $request)
    {
        $this->serviscontent->store($request->except('_token'));
        return back();
    }



    public function edit($id)
    {
        $item = ServisContent::find($id);
        return view('admin.pages.sp_contnet.edit', compact('item'));
    }
    public function update(ServiceContentRequest $request, $id)
    {
        try {
            $this->serviscontent->update($request->except('_method', '_token'), $id);
        } catch (\Exception $th) {
            return $th->getMessage();
        }

        return back();
    }

   
    public function destroy($id)
    {
        ServisContent::where('id', $id)->delete();
        return response()->json([
            'id' => $id
        ]);
    }
}
