<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTechnologyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:technologies,name,' . $this->route('id')
            ],
            'icon' => [
                'nullable',
                'string',
                'max:255'
            ],
            'color' => [
                'sometimes',
                'required',
                'string',
                'max:7'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de la technologie est obligatoire',
            'color.required' => 'La couleur de la technologie est obligatoire',
        ];
    }
}
