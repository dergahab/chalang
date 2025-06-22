<?php

namespace App\Http\Controllers\Admin\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceContent\StoreRequest;
use App\Http\Requests\ServiceContent\UpdateRequest;
use App\Models\Lang;
use App\Models\Service;
use App\Models\ServisContent;
use App\Services\Service\ServiceContentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ServiceContentController extends Controller
{
    protected $serviscontent;
    public function __construct(protected ServiceContentService $service, protected Lang $langs)
    {
        
    }

    public function index()
    {
        $servicecontent = ServisContent::with('service')->get();
        return view('admin.pages.service-contnet.index', compact('servicecontent'));
    }


    public function create()
    {
        $servicecontent = new ServisContent();
        $services = Service::where('parent_id', '<>', 0)
            ->whereDoesntHave('content')
            ->get();
        return view('admin.pages.service-contnet.create', compact('servicecontent', 'services'));
    }

    public function store(StoreRequest $request)
    {   
        DB::beginTransaction();
        try {
            $this->service->store($request);

            flash()->success('success', 'Service content created successfully');
            return redirect()->route('admin.service-content.index');
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            flash()->success('error', 'Service content created successfully');
            return redirect()->route('admin.service-content.index');
        
        }
    }

    public function edit($id)
    {
        $servicecontent = ServisContent::find($id);
        $services = Service::where('parent_id', '<>', 0)
            ->whereDoesntHave('content')
            ->get();
        return view('admin.pages.service-contnet.edit', compact('servicecontent', 'services'));
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
           
            flash()->success('success', 'Service content created successfully');
            return redirect()->route('admin.service-content.index');
        
            DB::commit();
        } catch (\Exception $th) {
            DB::rollback();

            flash()->success('error', 'Service content failed');
            return redirect()->route('admin.service-content.index');
        
        }

    }

   
    public function destroy($id)
    {
        ServisContent::where('id', $id)->delete();
        return response()->json([
            'id' => $id
        ]);
    }
}
