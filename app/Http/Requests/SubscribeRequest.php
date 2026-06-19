<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mail' => ['required', 'email'],
            'website' => ['required', 'url', 'max:255'],
            // Honeypot: bots filling this field are blocked.
            'hp' => ['nullable', 'prohibited'],
        ];
    }
}
