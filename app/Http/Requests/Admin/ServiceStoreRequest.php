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
            'duration.*' => 'required|string|min:2|max:720',
            'price_type' => 'required|array',
            'price_type.*' => 'required|string',
            'price' => 'required|array',
            'price.*' => 'required|numeric|min:0',
            // Include these if your table has these columns
            'variant_name' => 'nullable|array',
            'variant_name.*' => 'nullable|string|max:255',
            'variant_description' => 'nullable|array',
            'variant_description.*' => 'nullable|string',
            // Service validation rules
            // 'name' => ['required', 'string', 'max:255'],
            // 'status' => ['required', 'boolean'],
            // 'service_type' => ['required', 'string', 'max:255'],
            // 'category' => ['required', 'string', 'max:255'],
            // 'description' => ['nullable', 'max:255'],

            // Variant validation rules
            // 'duration' => 'required|array',
            // 'duration.*' => ['required', Rule::in(['1h', '2h', '3h'])],
            // 'price_type' => 'required|array',
            // 'price_type.*' => ['required', Rule::in(['Fixed', 'Variable'])],
            // 'price' => 'required|array',
            // 'price.*' => 'required|numeric|min:0',
            // 'variant_name' => 'nullable|array',
            // 'variant_name.*' => 'nullable|string|max:255',
            // 'variant_description' => 'nullable|array',
            // 'variant_description.*' => 'nullable|string',
        ];
    }
}
