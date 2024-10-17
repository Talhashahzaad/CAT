<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionalCertificateStoreRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'icon' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255', 'unique:professional_certificates,name'],
            'status' => ['required', 'boolean'],
            'parent_certificate' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}