<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ListingStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:30000'],
            'thumbnail_image' => ['required', 'image', 'max:30000'],
            'title' => ['required', 'string', 'max:255', 'unique:listings,title'],
            'category' => ['required', 'integer'],
            'location' => ['required', 'integer'],
            'address' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'website' => ['nullable'],
            'facebook_link' => ['nullable'],
            'instagram_link' => ['nullable'],
            'tiktok_link' => ['nullable'],
            'youtube_link' => ['nullable'],
            'attachment' => ['nullable', 'mimes:png,jpg,csv,pdf,jpeg', 'max:10000'],
            'tag.*' => ['nullable', 'integer'],
            'description' => ['required'],
            'google_map_embed_code' => ['nullable'],
            'seo_title' => ['nullable', 'string', 'max:255'],
            'seo_description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'is_featured' => ['required', 'boolean'],
            'is_verified' => ['required', 'boolean'],

        ];
    }
}