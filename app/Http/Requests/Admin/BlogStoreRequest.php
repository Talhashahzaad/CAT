<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:4000'],
            'title' => ['required', 'max:255', 'unique:blogs,title'],
            'category' => ['required', 'integer'],
            'description' => ['required'],
            'status' => ['required', 'boolean'],
            'is_popular' => ['required', 'boolean'],
        ];
    }
}
