<?php

namespace App\Services\Service;

use App\Models\Lang;
use App\Models\ServiceContentOption;
use App\Models\ServisContent;
use App\Models\ServisContentTranslation;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ServiceContent\StoreRequest;
use App\Http\Requests\ServiceContent\UpdateRequest;

class ServiceContentService 
{

    public $langs;
    public $servicecontentoption;

    public function __construct()
    {
        $this->langs = Lang::all();

    }
    public function store(StoreRequest $request)
    {      
        $item = ServisContent::create([
            'service_id' => $request->service_id
        ]);
        $this->saveTranslatable($request->getLocalizedData(), $item->id);

    }


    public function saveTranslatable($data, $id)
    {
        foreach ($data as $item) {
            ServisContentTranslation::updateOrCreate(
                ['servis_content_id' => $id, 'locale' => $item['lang']],
                [
                    'title' => $item['title'],
                    'content' => $item['description'],
                    'locale' => $item['lang'],
                    'servis_content_id' => $id,
                ]
            );
        }
    }

public function update(UpdateRequest $request, $id)
{
    $item = ServisContent::where('id', $id)->update([
        'service_id' => $request->service_id
    ]);
    $this->saveTranslatable($request->getLocalizedData(), $id);
}
}