<?php

namespace App\Services;

use App\Models\Lang;
use App\Models\ServiceContentOptionTranslation;
use App\Models\ServisContent;
use App\Models\ServisContentTranslation;
use \App\Models\ServiceContentOption;
use Illuminate\Support\Facades\DB;


class ServiceContentOptionService {

    public $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }
    public function store($data, $id){
        for ($i=0; $i <count(            'title_az') ; $i++) { 
            # code...
        }
            $item = ServiceContentOption::create([
                'servis_content_id' => $id,
                'title_az' => $data['option_title']['az'],
                'title_en' => $data['option_title']['en'],
                'content_eaz' => $data['option_content']['az'],
                'content_en' => $data['option_content']['en'],
                'icon'       => $data['icon']
            ]); 
    }

    public function update(array $data , $model ){
        //  dd($data);
        ServiceContentOption::updateOrCreate([
            
        ]);
    }

   
}