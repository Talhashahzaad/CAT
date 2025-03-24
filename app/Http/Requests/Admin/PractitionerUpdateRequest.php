<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class PractitionerUpdateRequest extends FormRequest
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
                Rule::unique('practitioners', 'name')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                })->ignore($this->route('id'))
            ],
            'qualification' => 'nullable|string',
            'certificate' => 'nullable|string',
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