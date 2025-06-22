<?php

namespace App\Http\Requests\ServiceContent;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lang;
use Illuminate\Support\Str;

class UpdateRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'service_id' => 'required|integer|exists:services,id',
        ];
    
        $langs = Lang::pluck('lang')->toArray();
    
        foreach ($langs as $lang) {
            // 'az' is required, others are optional (adjust as needed)
            $rules["name.$lang"] = $lang === 'az' ? 'required|string|max:255' : 'nullable|string|max:255';
            $rules["description.$lang"] = $lang === 'az' ? 'required|string' : 'nullable|string';
        }
    
        return $rules;
    }


    public function passedValidation(): void
    {
        $langs = Lang::pluck('lang')->toArray();
        $names = $this->input('name', []);
        $descriptions = $this->input('description', []);
        $serviceId = $this->input('service_id');

        $localized = [];

        foreach ($langs as $lang) {
            if (!empty($names[$lang])) {
                $localized[] = [
                    'service_id' => $serviceId,
                    'title' => $names[$lang],
                    'slug' => Str::slug($names[$lang]),
                    'lang' => $lang,
                    'description' => $descriptions[$lang] ?? null,
                ];
            }
        }

        $this->merge([
            'localizedData' => $localized
        ]);
    }

    public function getLocalizedData(): array
    {
        return $this->input('localizedData', []);
    }
}
