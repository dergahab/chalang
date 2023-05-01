<?php

namespace App\Services;

use App\Models\Compound;
use App\Models\CompoundTranslation;
use App\Models\Lang;
use App\Models\Subcompound;
use App\Models\SubcompoundTranslations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Traits\FileUploader;

class PsService{
    use FileUploader;

    protected $langs;
    public function __construct(){
        
    }
    public static function save(Request $request){
        // return $request->all(); 
        $langs = Lang::all();
        $data = [];
   
        if(isset($request->service)){
            $data['type']    = 'service';
            $data['related'] = $request->service;
        }

        if(isset($request->protfolio)){
            $data['type']    = 'portfolio';
            $data['related'] = $request->portfolio;
        }

        DB::beginTransaction();
        try {
           
            $compound = Compound::create($data);
            
            foreach( $langs as $lang){
                if($request->post('name')[$lang->lang]){
                    
                    CompoundTranslation::create([
                        'title' =>$request->post('name')[$lang->lang],
                        'content' =>$request->post('description')[$lang->lang],
                        'slug'   =>  Str::slug($request->post('name')[$lang->lang]),
                        'locale' => $lang->lang,
                        'compound_id' => $compound->id,
                    ]);
                }
            }

            // return $compound->id;
            $subcompound['compound_id'] = $compound->id;
            $subcompound = Subcompound::create($subcompound);
            
            foreach ($langs as $lang) {
                if (isset($request->subname[$lang->lang])) {
                    foreach ($request->subname[$lang->lang] as $index => $name) {
                        SubcompoundTranslations::create([
                            'name' => $name,
                            'content' => $request->subdescription[$lang->lang][$index],
                            'locale' => $lang->lang,
                            'subcompound_id' => $subcompound->id,
                        ]);
                    }
                }
            }
            

            DB::commit();
        } catch (\Exception $e) {
           DB::rollback();
           return response()->json([
                'code' => 401,
                'error' => $e->getMessage()
            ]);
        }

        return true;
    }
}