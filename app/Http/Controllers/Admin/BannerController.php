<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\UpadeRequest;
use App\Http\Requests\Banner\StoreRequest;
use App\Models\Banner;
use App\Services\BannerService;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function __construct(protected BannerService $bannerService){}

    public function index()
    {
        $items = Banner::all();
        return view('admin.pages.banner.index', compact('items'));
    }


    public function create()
    {
        $item =new Banner();
        return view('admin.pages.banner.create', compact('item'));
    }


    public function store(StoreRequest $request)
    {
         $this->bannerService->store($request);
    }


    public function edit($id)
    {
        $item = Banner::find($id);

        return view('admin.pages.banner.edit', compact('item'));
    }

    public function update(UpadeRequest $request, $id)
    {

        DB::beginTransaction();
        try {
            $this->bannerService->update($request, $id);
            DB::commit();
            session()->flash('success', 'Banner updated successfully');
            return redirect()->route('admin.banner.edit', $id);
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Failed to update banner: ' . $e->getMessage());
            return redirect()->back();
        }
    }


}
