<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:projects,title,'.$this->route('id'),
            ],
            'slug' => [
                'sometimes',
                'string',
                'max:255',
                'unique:projects,slug,'.$this->route('id'),
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ],
            'description' => [
                'sometimes',
                'string',
                'min:10',
            ],
            'status' => [
                'sometimes',
                'in:draft,published,archived',
            ],
            'github_url' => [
                'sometimes',
                'nullable',
                'url',
                'starts_with:https://',
            ],
            'demo_url' => [
                'sometimes',
                'nullable',
                'url',
                'starts_with:https://',
            ],
            'date_realisation' => [
                'sometimes',
                'date',
                'before_or_equal:today',
            ],
            'is_featured' => [
                'sometimes',
                'nullable',
                'boolean',
            ],
            'order' => [
                'sometimes',
                'integer',
                'min:1',
            ],
            'type' => [
                'sometimes',
                'in:frontend,fullstack,backend',
            ],
            'technologies' => [
                'nullable',
                'array',
            ],
            'technologies.*' => [
                'integer',
                'exists:technologies,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est obligatoire',
            'title.unique' => 'Un projet avec ce titre existe déjà',
            'description.min' => 'La description doit contenir au moins 10 caractères',
            'github_url.starts_with' => 'L\'URL Github doit commencer par https://',
            'date_realisation.before_or_equal' => 'La date de réalisation ne peut pas être dans le futur',
            'type.in' => 'Le type doit être frontend, fullstack ou backend',
        ];
    }
}
