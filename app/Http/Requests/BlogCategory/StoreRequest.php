<?php

namespace App\Http\Requests\BlogCategory;

use App\Http\Requests\BaseRequest;
use App\Models\BcategoryTranslation;
use App\Models\BlogTranslation;
use Illuminate\Foundation\Http\FormRequest;

 final class StoreRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get all language keys from the BcategoryTranslation model
        $langKeys = \App\Models\Lang::query()
            ->distinct()
            ->pluck('lang')
            ->toArray();

        $rules = [
            'name' => 'required|array',
        ];

        foreach ($langKeys as $lang) {
            $rules["name.$lang"] = 'required|string|max:255|unique:' . (new BcategoryTranslation())->getTable() . ',name';
        }

        return $rules;
    }
}
