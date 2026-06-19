<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageInquiryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'package_name' => ['required', 'string', 'max:255'],
            'package_id' => ['nullable', 'integer'],
            'addons' => ['nullable', 'array'],
            'addons.*' => ['string', 'max:100'],
            'brief_goal' => ['nullable', 'string', 'max:500'],
            'brief_deadline' => ['nullable', 'string', 'max:100'],
            'brief_budget_range' => ['nullable', 'string', 'max:100'],
            'brief_priority_services' => ['nullable', 'string', 'max:500'],
            'brief_materials' => ['nullable', 'string', 'max:500'],
            'brief_competitors' => ['nullable', 'string', 'max:500'],
            'brief_contact_channel' => ['nullable', 'string', 'max:100'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'hp' => ['nullable', 'prohibited'],
        ];
    }
}
