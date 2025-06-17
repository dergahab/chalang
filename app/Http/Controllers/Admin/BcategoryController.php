<?php

namespace App\Http\Controllers\Admin;

use App\Models\Lang;
use App\Models\Bcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\BcategoryTranslation;
use App\Http\Requests\BlogeCategoy\Store;
use App\Http\Requests\BlogCategory\StoreRequest;
use App\Http\Requests\BlogCategory\UpdateRequest;

class BcategoryController extends Controller
{
    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function index()
    {
        $items = BcategoryTranslation::with('bcategory')->where('locale', 'az')->get();
        // dd(vars: $items->toArray());
        return view('admin.pages.bcategory.index', compact("items"));
    }

    public function create()
    {
        $item = new Bcategory();
        return view('admin.pages.bcategory.create', compact('item'));
    }

    public function store(StoreRequest $request, Lang $langModel)
    {

        DB::beginTransaction();
        try {
            $bcategory = Bcategory::create();

            foreach ($this->langs as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    BcategoryTranslation::insert([
                        'name' => $request->post('name')[$lang->lang],
                        'slug' => Str::slug($request->post('name')[$lang->lang]),
                        'locale' => $lang->lang,
                        'bcategory_id' => $bcategory->id,
                    ]);
                }
            }
            DB::commit();
                    session()->flash('success', 'Category created successfully');

            return redirect()->route("admin.bcategory.index");

        } catch (\Exception $e) {
            DB::rollback();

            session()->flash('error', 'Category creation failed: ' . $e->getMessage());
        }



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
        $item = Bcategory::find($id);

        return view('admin.pages.pcategory.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        foreach ($this->langs as $lang) {
            if ($request->post('name')[$lang->lang]) {
                BcategoryTranslation::where('bcategory_id', $id)->where('locale', $lang->lang)->update([
                    'name' => $request->post('name')[$lang->lang],
                    'slug' => Str::slug($request->post('name')[$lang->lang]),
                ]);
            }
        }
        session()->flash('success', 'Category updated successfully');

        return redirect()->route('admin.bcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Bcategory::where('id', $id)->delete();

        return response()->json([
            'code' => 200,
        ]);
    }
}
