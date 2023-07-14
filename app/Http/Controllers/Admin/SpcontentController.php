<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceContentRequest;
use App\Models\Compound;
use App\Models\Lang;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\ServisContent;
use App\Services\ServiceContentService;
use Illuminate\Http\Request;

class SpcontentController extends Controller
{
    protected $langs;
    protected $serviscontent;
    public function __construct()
    {
        $this->langs = Lang::all();
        $this->serviscontent = new ServiceContentService();
        view()->share('services', Service::where('parent_id', 0)->get());
        view()->share('portfolios', Portfolio::all());
        
    }

    public function index()
    {
        return view('admin.pages.sp_contnet.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new Compound();

        return view('admin.pages.sp_contnet.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->serviscontent->store($request->except('_token'));
        return back();
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
      $item = ServisContent::find($id);
      return view('admin.pages.sp_contnet.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceContentRequest $request, $id)
    {
        try {
            $this->serviscontent->update($request->except('_method','_token'),$id);
        } catch (\Exception $th) {
           return  $th->getMessage();
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
