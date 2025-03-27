<?php

namespace App\Http\Requests\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ListingStoreApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     // return false;

    //     return Auth::check() && Auth::user()->hasRole('agent');
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:3000'],
            'thumbnail_image' => ['required', 'image', 'max:3000'],
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('listings', 'title')
            ],
            'category' => ['required', 'integer'],
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
            'attachment' => ['nullable', 'mimes:png,jpg,csv,pdf'],
            'amenities.*' => [
                'integer',
                Rule::exists('amenities', 'id')
            ],
            'tag.*' => [
                'integer',
                Rule::exists('tags', 'id')
            ],
            'description' => ['required'],
            'google_map_embed_code' => ['nullable'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'is_verified' => ['required', 'boolean'],

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