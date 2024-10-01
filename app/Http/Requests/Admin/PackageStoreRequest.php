<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PackageStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('packages', 'name'),
            ],
            'status' => 'required|in:0,1',
            'category' => 'required',
            'description' => 'nullable|string',
            'services' => 'required|array',
            'services.*' => 'required|string',
            'variants' => 'required|array|min:1',
            'variants.*' => 'required|string',
            'service_prices' => 'required|array',
            'service_prices.*' => 'required|string',
            'service_durations' => 'required|array|min:1',
            'service_durations.*' => 'required|string',
            'price_type' => 'required ',
            'retail_price' => 'required|string',
            'total_duration' => 'required|string',
            'discount_percentage' => 'nullable|string',
            'available_for' => 'required',
        ];
    }
}