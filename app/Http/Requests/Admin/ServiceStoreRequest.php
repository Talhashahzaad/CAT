<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'category' => 'nullable|string|max:255',
            'service_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|array',
            'duration.*' => 'required|string|min:1|max:720',
            'price_type.*' => ['required', Rule::in(['Free', 'From', 'Fixed'])],
            'price.*' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $priceType = $this->input("price_type.$index");

                    if ($priceType !== 'Free' && ($value === null || $value === '')) {
                        $fail('The price is required when the price type is not Free.');
                    }

                    if ($priceType === 'Free' && $value !== null && $value !== '') {
                        $fail('The price should not be provided when the price type is Free.');
                    }
                },
                'numeric',
                'min:0',
            ],
            // Include these if your table has these columns
            'variant_name' => 'nullable|array',
            'variant_name.*' => 'nullable|string|max:255',
            'variant_description' => 'nullable|array',
            'variant_description.*' => 'nullable|string',
        ];
    }
}
