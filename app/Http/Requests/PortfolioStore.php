<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PortfolioStore extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpg,png',
            'pcategory_id' => 'required|array',
            'company_id' => 'required',
            'in_main' => 'required',
        ];
    }
}
