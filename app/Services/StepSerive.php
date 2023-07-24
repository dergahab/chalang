<?php

namespace App\Services;

use App\Models\Lang;
use App\Models\Step;
use App\Models\StepTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StepSerive implements BaseService
{
    public $langs;

    public function __construct()
    {
        $this->langs = Lang::all();
    }

    public function store($data)
    {
        // return $data;
        // if(in_array('image', $data)){
        $filename = uniqid().'.'.$data['image']->getClientOriginalExtension();
        $data['image']->storeAs('uploads', $filename);
        Storage::disk('public')->putFileAs('portfolio', $data['image'], $filename);
        $image = 'portfolio/'.$filename;
        // }

        $step = Step::create([
            'image' => $image,
        ]);


        $this->saveTranslatable($data, $step->id);

        return redirect()->route('admin.step.index');
    }

    public function update($data, $model)
    {
        $model = Step::find($model);
        if ($data['image']) {
            $filename = uniqid().'.'.$data['image']->getClientOriginalExtension();
            $data['image']->storeAs('uploads', $filename);
            Storage::disk('public')->putFileAs('portfolio', $data['image'], $filename);
            $model->image = 'portfolio/'.$filename;
        }

        $model->save();
        $this->saveTranslatable($data, $model->id);
        return back();
    }

    public function saveTranslatable($data, $id)
    {
        DB::beginTransaction();
        try {
            foreach ($this->langs as $l) {
                if ($data['name'][$l->lang]) {
                    StepTranslation::updateOrCreate(

                        ['step_id' => $id, 'locale' => $l->lang],
                        [
                            'title' => $data['name'][$l->lang],
                            'description' => $data['content'][$l->lang],
                            'step' => $data['step'][$l->lang],
                            'locale' => $l->lang,
                            'step_id' => $id,
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
