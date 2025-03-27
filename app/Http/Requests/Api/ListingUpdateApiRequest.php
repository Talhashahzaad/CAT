<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListingUpdateApiRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['sometimes', 'image', 'max:3000'], // Changed to sometimes
            'thumbnail_image' => ['sometimes', 'image', 'max:3000'], // Changed to sometimes
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('listings', 'title')->ignore($this->id),
            ],
            'category' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'location' => [
                'required',
                'integer',
                Rule::exists('locations', 'id')
            ],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'website' => ['nullable', 'url'],
            'facebook_link' => ['nullable', 'url'],
            'instagram_link' => ['nullable', 'url'],
            'tiktok_link' => ['nullable', 'url'],
            'youtube_link' => ['nullable', 'url'],
            'attachment' => ['nullable', 'mimes:png,jpg,jpeg,csv,pdf', 'max:5000'],
            'amenities' => ['nullable', 'array'],
            'amenities.*' => [
                'integer',
                Rule::exists('amenities', 'id')
            ],
            'tag' => ['nullable', 'array'],
            'tag.*' => [
                'integer',
                Rule::exists('tags', 'id')
            ],
            'description' => ['required'],
            'google_map_embed_code' => ['nullable', 'string'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'integer', 'in:0,1'],
            'is_featured' => ['required', 'boolean'],
            'is_verified' => ['required', 'boolean'],
            'professional_certificates' => ['nullable', 'array'],
            'professional_certificates.*' => [
                'integer',
                Rule::exists('professional_certificates', 'id')
            ],
            'practitioner' => ['nullable', 'array'],
            'practitioner.*' => [
                'integer',
                Rule::exists('practitioners', 'id')
            ],
            'service_capacity' => ['nullable', 'integer', 'min:1']
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