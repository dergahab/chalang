<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string'],
            'type' => ['nullable', 'string', 'max:50'],
            // Honeypot: should remain empty; bots filling it will fail.
            'hp' => ['nullable', 'prohibited'],
        ];
    }
}
