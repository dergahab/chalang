<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\Controller;
use App\Http\Requests\PcategoryStore;
use App\Models\Lang;
use App\Models\Pcategory;
use App\Models\PcategoryTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PcategoryController extends Controller
{
    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.pcategory.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PcategoryStore $request)
    {

        DB::beginTransaction();
        try {
            $pcategory = Pcategory::create();

            foreach ($this->langs as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    PcategoryTranslation::insert([
                        'name' => $request->post('name')[$lang->lang],
                        'slug' => Str::slug($request->post('name')[$lang->lang]),
                        'locale' => $lang->lang,
                        'pcategory_id' => $pcategory->id,
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

        return response()->json([
            'code' => 200,
        ]);

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
        $item = Pcategory::find($id);

        return view('admin.pages.pcategory.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        foreach ($this->langs as $lang) {
            if ($request->post('name')[$lang->lang]) {
                PcategoryTranslation::where('bcategory_id', $id)->where('locale', $lang->lang)->update([
                    'name' => $request->post('name')[$lang->lang],
                    'slug' => Str::slug($request->post('name')[$lang->lang]),
                ]);
            }
        }

        return redirect()->route('admin.pcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pcategory::where('id', $id)->delete();

        return response()->json([
            'code' => 200,
        ]);
    }
}
