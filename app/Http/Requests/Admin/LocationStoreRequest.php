<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LocationStoreRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'location_image' => ['nullable','image','max:3000' ],
            'name' => [ 'required','string', 'max:255', 'unique:locations,name'],
            'show_at_home' => ['required','boolean'],
            'status' => ['required','boolean'],
            'parent_location' =>['required','string','max:255'],
            'description' => ['nullable', 'max:300'],
        ];
    }
}