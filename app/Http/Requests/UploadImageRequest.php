<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
            ],
            'path' => [
                'required',
                'string',
                'max:255',
            ],
            'alt_text' => [
                'nullable',
                'string',
            ],
            'is_primary' => [
                'boolean',
            ],
            'order' => [
                'required',
                'integer',
                'min:0',
            ],
            'project_id' => [
                'required',
                'exists:projects,id',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est obligatoire',
            'path.required' => 'Le chemin est obligatoire',
            'order.required' => 'L\'index est obligatoire',
            'project_id.required' => 'L\'id du projet est obligatoire',
        ];
    }
}
