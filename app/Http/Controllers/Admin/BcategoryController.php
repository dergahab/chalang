<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bcategory;
use App\Models\BcategoryTranslation;
use App\Models\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BcategoryController extends Controller
{
    protected $langs;

    public function __construct()
    {
        // Defer language loading to avoid blocking route gathering during artisan commands
        // Use getter method instead
    }

    protected function getLangs()
    {
        if (!$this->langs) {
            $this->langs = Lang::all();
        }
        return $this->langs;
    }

    public function index()
    {
        $this->canOrAbort('bcategory.index');
        return view('admin.pages.bcategory.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->canOrAbort('bcategory.create');
        DB::beginTransaction();
        try {
            $bcategory = Bcategory::create();

            foreach ($this->getLangs() as $lang) {
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
        $this->canOrAbort('bcategory.edit');
        $item = Bcategory::find($id);

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
        $this->canOrAbort('bcategory.edit');
        foreach ($this->getLangs() as $lang) {
            if ($request->post('name')[$lang->lang]) {
                BcategoryTranslation::where('bcategory_id', $id)->where('locale', $lang->lang)->update([
                    'name' => $request->post('name')[$lang->lang],
                    'slug' => Str::slug($request->post('name')[$lang->lang]),
                ]);
            }
        }

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
        $this->canOrAbort('bcategory.delete');
        Bcategory::where('id', $id)->delete();

        return response()->json([
            'code' => 200,
        ]);
    }
}
