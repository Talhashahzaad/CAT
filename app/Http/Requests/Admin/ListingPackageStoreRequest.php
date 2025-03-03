<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ListingPackageStoreRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'in:free,paid'],
            'name' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric'],
            'number_of_days' => ['required', 'numeric'],
            'num_of_listing' => ['required', 'numeric'],
            'cat_ecommarce' => ['required', 'boolean'],
            'cat_pro_social_media' => ['required', 'boolean'],
            'social_media_post' => ['required', 'boolean'],
            'featured_listing' => ['required', 'boolean'],
            'multiple_locations' => ['required', 'boolean'],
            'live_chat' => ['required', 'boolean'],
            'status' => ['required', 'boolean'],
        ];
    }
}