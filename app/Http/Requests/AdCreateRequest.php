<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:80',
            'description' => 'required|string|max:500',
            'place_type' => [
                'required',
                'string',
                Rule::in(['house', 'apartment', 'land', 'farm'])
            ],
            'business_type' => [
                'required',
                'string',
                Rule::in(['purchase', 'rent'])
            ],
            'active' => 'boolean'
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->has('active')) {
            $this->merge(['active' => false]);
        }
    }

    public function messages()
    {
        return [
            'place_type.in' => 'The place type must be one of: house, apartment, land, farm',
            'business_type.in' => 'The business type must be either purchase or rent',
        ];
    }
}
