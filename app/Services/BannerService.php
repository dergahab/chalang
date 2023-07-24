<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\BannerTranslation;
use App\Models\Lang;
use App\Models\Step;
use App\Models\StepTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerService implements BaseService
{
    public $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function store($data)
    {
        $this->saveTranslatable($data);
        return redirect()->route('admin.banner.index');
    }

    public function update($data, $id)
    {
      return  $this->saveTranslatable($data, $id);
    }

    public function saveTranslatable($request, $id = null)
    {
       

        $data = [];
        DB::beginTransaction();
        try {
            if ($request['image']) {
                $filename = uniqid().'.'.$request['image']->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('banner', $request['image'], $filename);
                $data['image'] = 'banner/'.$filename;
            }

            if($request['url']){
                $data['url'] =$request['url'];
            }

            $banner = Banner::updateOrCreate(['id' => $id],$data);
            foreach ($this->langs as $l) {
                if ($request['name'][$l->lang]) {
                    BannerTranslation::updateOrCreate(
                        ['banner_id' => $banner->id, 'locale' => $l->lang],
                        [
                            'title' => $request['name'][$l->lang],
                            'content' => $request['content'][$l->lang],
                            'locale' => $l->lang,
                            'banner_id' =>  $banner->id,
                        ]
                    );
                }
            }
            DB::commit();
           
            return response()->json([
                'code' => 200
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code' =>  $e->getMessage()
            ]);
            return $e->getMessage();
        }
    }
}
