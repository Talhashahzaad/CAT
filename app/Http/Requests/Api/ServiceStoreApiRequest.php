<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceStoreApiRequest extends FormRequest
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
            'category' => 'required|integer|exists:categories,id', // Ensure category exists
            'service_type' => 'required|string|max:255', // Service type should be required
            'description' => 'nullable|string',

            // Validate durations
            'duration' => 'required|array',
            'duration.*' => 'required|string|min:1|max:720',

            // Validate price type
            'price_type' => 'required|array',
            'price_type.*' => ['required', Rule::in(['Free', 'From', 'Fixed'])],

            'price' => 'required|array',
            'price.*' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) {
                    $index = explode('.', $attribute)[1];
                    $priceType = $this->input("price_type.$index");

                    if ($priceType !== 'Free' && is_null($value)) {
                        $fail("The price is required when the price type is not Free.");
                    }

                    if ($priceType === 'Free' && !is_null($value)) {
                        $fail("The price should not be provided when the price type is Free.");
                    }
                },
            ],
            // Validate variant names
            'variant_name' => 'required|array',
            'variant_name.*' => 'required|string|max:255',

            // Validate variant descriptions
            'variant_description' => 'nullable|array',
            'variant_description.*' => 'nullable|string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}