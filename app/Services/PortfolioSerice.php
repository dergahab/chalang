<?php

namespace App\Services;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\PortfolioTranslation;
use App\Models\Lang;
use Illuminate\Support\Facades\Storage;

Class PortfolioSerice  implements  BaseService{
    
    public $langs;
    public function __construct(){
        $this->langs = Lang::all();
    }
    public function store(){}
    public function update($data, $model){

        if($data['image']){
            $filename = uniqid() . '.' . $data['image']->getClientOriginalExtension();
            $data['image']->storeAs('uploads', $filename);
            Storage::disk('public')->putFileAs('portfolio', $data['image'], $filename);
            $model->image = 'portfolio/' . $filename;
        }

        $model->company_id = $data['company_id'];
        $model->slug = Str::slug($data['name']['az']);
        $model->save();
        $model->attachCategories($data['pcategory_id']);

        $this->saveTranslatable($data, $model->id);
    }
    public function saveTranslatable($data, $id){
        DB::beginTransaction();
        try {
            foreach($this->langs as $l){
                if($data['name'][$l->lang]){
                    PortfolioTranslation::updateOrCreate(
                        ['portfolio_id' => $id, 'locale' => $l->lang],
                        [
                            'title' => $data['name'][$l->lang],
                            'description' => $data['description'][$l->lang],
                            'slug' => Str::slug($data['name'][$l->lang]),
                        ]
                    );
                    
                }
            }
            DB::commit();
        } catch (\Exception $e) {
           DB::rollback();
        //    throw  $e;
           return  $e->getMessage();
        }
    }
}