<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compound;
use App\Models\Lang;
use App\Models\Portfolio;
use App\Models\Service;
use App\Services\PsService;
use Illuminate\Http\Request;

class SpcontentController extends Controller
{
    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
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
        return  PsService::save($request);

        return redirect()->route('admin.sp-content.index');
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
        return Compound::with('subcompund')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
