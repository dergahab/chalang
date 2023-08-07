<?php

namespace App\Services;

use App\Models\Lang;
use App\Models\Portfolio;
use App\Models\PortfolioTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioSerice implements BaseService
{
    public $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function store($data)
    {
        // if(in_array('image', $data)){
        $filename = uniqid().'.'.$data['image']->getClientOriginalExtension();
        $data['image']->storeAs('uploads', $filename);
        Storage::disk('public')->putFileAs('portfolio', $data['image'], $filename);
        $image = 'portfolio/'.$filename;
        // }

        $portfolio = Portfolio::create([
            'company_id' => $data['company_id'],
            'slug' => Str::slug($data['name']['az']),
            'image' => $image,
        ]);

        $portfolio->attachCategories($data['pcategory_id']);

        $this->saveTranslatable($data, $portfolio->id);
    }

    public function update($data, $model)
    {

        if (in_array('image', $data)) {
            $filename = uniqid().'.'.$data['image']->getClientOriginalExtension();
            $data['image']->storeAs('uploads', $filename);
            Storage::disk('public')->putFileAs('portfolio', $data['image'], $filename);
            $model->image = 'portfolio/'.$filename;
        }

        $model->company_id = $data['company_id'];
        $model->slug = Str::slug($data['name']['az']);
        $model->save();
        $model->syncCategories($data['pcategory_id']);

        $this->saveTranslatable($data, $model->id);
    }

    public function saveTranslatable($data, $id)
    {
        DB::beginTransaction();
        try {
            foreach ($this->langs as $l) {
                if ($data['name'][$l->lang]) {
                    PortfolioTranslation::updateOrCreate(

                        ['portfolio_id' => $id, 'locale' => $l->lang],
                        [
                            'title' => $data['name'][$l->lang],
                            'description' => $data['description'][$l->lang],
                            'slug' => Str::slug($data['name'][$l->lang]),
                            'locale' => $l->lang,
                            'portfolio_id' => $id,
                        ]
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return $e->getMessage();
        }
    }
}
