<?php

namespace App\Http\Requests\BlogCategory;

use App\Http\Requests\BaseRequest;
use App\Models\BcategoryTranslation;
use App\Models\BlogTranslation;
use Illuminate\Foundation\Http\FormRequest;

 final class UpdateRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|array',
            'name.az' => 'required|string|max:255|unique:'. (new BcategoryTranslation())->getTable() .',name',
        ];
    }
}
