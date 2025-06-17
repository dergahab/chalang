<?php

namespace App\Http\Requests\Banner;

use Faker\Provider\Base;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends Base
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name.az' => 'required',
            'content.az' => 'required',
            'image' => 'required|file',
        ];
    }

}
