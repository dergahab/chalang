<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Lang;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|array',
            'content' => 'nullable|array',
            'description' => 'nullable|array',
        ];

        $langs = Lang::all();

        foreach ($langs as $lang) {
            $rules['name.' . $lang->lang] = 'required|string|max:255';
            $rules['content.' . $lang->lang] = 'nullable|string';
            $rules['description.' . $lang->lang] = 'nullable|string';
        }

        return $rules;
    }
}
