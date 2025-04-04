<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Auth;

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
            'name' =>  [
                'required',
                'string',
                'max:255',
                'unique:professional_certificates,name',

            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}