<?php

namespace App\Services;

use App\Models\Contenttext;
use App\Models\ContenttextTranslation;
use App\Models\Lang;
use Illuminate\Support\Facades\DB;

class ContentTextService
{
    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function create($request)
    {
      return  $this->translate($request);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
           Contenttext::updateOrCreate(['id'=> $id],[
                'key' => $request->key,
            ]);

            foreach ($this->langs as $lang) {
                if ($request->post('title')[$lang->lang]) {
                    ContenttextTranslation::where('contenttext_id', $id)->where('locale', $lang->lang)->update([
                        'title' => $request->post('title')[$lang->lang],
                        'content' => $request->post('content')[$lang->lang],
                        'locale' => $lang->lang,
                        'contenttext_id' => $id,
                    ]);
                }
            }
            DB::commit();
            return response()->json([
                'success' => true
            ],201);
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }

        return 'success';
    }

    public function saveEdit($request, $id)
    {
        return $id;
    }

    public function translate($request , $id = null)
    {
        DB::beginTransaction();
        try {
          $text = Contenttext::updateOrCreate(['id'=> $id],[
                'key' => $request->key,
            ]);
          
            foreach ($this->langs as $lang) {
                if ($request->post('name')[$lang->lang]) {
                    ContenttextTranslation::updateOrCreate(['contenttext_id' =>  $text->id, 'locale' => $lang->lang],[
                        'title' => $request->post('name')[$lang->lang],
                        'content' => $request->post('content')[$lang->lang],
                        'locale' => $lang->lang,
                        'contenttext_id' => $text->id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }
}
