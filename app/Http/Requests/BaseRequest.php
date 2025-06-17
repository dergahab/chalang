<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{

    protected function failedValidation(Validator $validator)
    {
        if ($this->wantsJson() || $this->ajax()) {
            throw new HttpResponseException(response()->json([
                'code' => 422,
                'type' => 'error',
                'message'=> $validator->errors()->first(),
            ], 422));
        }
        // Flash the first error message to the session
        session()->flash('error', $validator->errors()->first());
        parent::failedValidation($validator);
    }
}
