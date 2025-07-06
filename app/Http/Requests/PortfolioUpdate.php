<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioUpdate extends BaseRequest
{

    public function rules()
    {
        return [
            'name' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,png',
            'pcategory_id' => 'nullable|array',
            'company_id' => 'nullable',
            'in_main' => 'nullable'
        ];
    }
}
