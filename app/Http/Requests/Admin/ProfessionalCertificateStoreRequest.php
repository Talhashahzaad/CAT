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
                Rule::unique('professional_certificates', 'name')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($this->route('id'))
            ],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}