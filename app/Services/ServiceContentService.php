<?php

namespace App\Services;

use App\Models\Lang;
use App\Models\ServiceContentOption;
use App\Models\ServisContent;
use App\Models\ServisContentTranslation;
use Illuminate\Support\Facades\DB;

class ServiceContentService implements BaseService {

    public $langs;
    public $servicecontentoption;
    public function __construct()
    {
        $this->langs = Lang::all();
        $this->servicecontentoption = new ServiceContentOptionService();
    }
    public function store($data){
            $item = ServisContent::create([
                'service_id' => $data['service_id']
            ]);
            $this->saveTranslatable($data, $item->id);

            $this->servicecontentoption->store($data, $item->id);
    }

    public function update(array $data , $model ){
     $item = ServisContent::where('id', $model)->update([
        'service_id' => $data['service_id']
      ]);
      $this->saveTranslatable($data, $model);
     }

    public function saveTranslatable($data, $id ){
        DB::beginTransaction();
        try {
            foreach ($this->langs as $l) {
                if ($data['name'][$l->lang]) {
                    ServisContentTranslation::updateOrCreate(
                        ['servis_content_id' => $id, 'locale' => $l->lang],
                        [
                            'title' => $data['name'][$l->lang],
                            'content' => $data['description'][$l->lang],
                            'locale' => $l->lang,
                            'servis_content_id' => $id,
                        ]
                    );
                }
            }
            // dd($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            dd( $e->getMessage());
        }
    }
}