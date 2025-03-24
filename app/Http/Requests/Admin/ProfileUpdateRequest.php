<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

class ProfileUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'avatar' => ['nullable', 'image', 'max:2000'],
            'name' => ['required', 'max:255'],
            'email' =>  [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($this->route('id'))
            ],
            'phone' => ['required', 'max:50'],
            'address' => ['required', 'max:300'],
            'about' => ['required', 'max:300'],
            'website' => ['nullable', 'url'],
            'facebook' => ['nullable', 'url'],
            'tiktok' => ['nullable', 'url'],
            'youtube' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],

        ];
    }
}