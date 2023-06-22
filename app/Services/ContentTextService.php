<?php
namespace App\Services;
use App\Models\Contenttext;
use App\Models\ContenttextTranslation;
use App\Models\Lang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContentTextService {

    protected $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }
    public function create($request)
    {
        $contentText  = Contenttext::create([
            'key' => $request->key
       ]);

       return $contentText->id;
    }

    public function update($request, $id){
        DB::beginTransaction();
        try {
            foreach($this->langs as $lang){
                if($request->post('title')[$lang->lang]){
                    ContenttextTranslation::where('contenttext_id', $id)->where('locale', $lang->lang)->update([
                        'title'   => $request->post('title')[$lang->lang],
                        'content'   => $request->post('content')[$lang->lang],
                        'locale' => $lang->lang,
                        'contenttext_id' => $id,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
           DB::rollback();
         return $e->getMessage();
        }
 
        return 'success';
    }

    public function saveEdit($request,  $id)
    {
        return $id;
    }
    public function translate($request){
       DB::beginTransaction();
       try {
           $id =  $this->create($request);
           foreach($this->langs as $lang){
               if($request->post('title')[$lang->lang]){
                ContenttextTranslation::insert([
                       'title'   => $request->post('title')[$lang->lang],
                       'content'   => $request->post('content')[$lang->lang],
                       'locale' => $lang->lang,
                       'contenttext_id' => $id,
                   ]);
               }
           }
           DB::commit();
       } catch (\Exception $e) {
          DB::rollback();
        return $e->getMessage();
       }

       return 'success';

    }
}