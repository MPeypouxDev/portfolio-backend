<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
                'required',
                'string',
                'max:255',
                'unique:projects,title'
            ],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:projects,slug',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'
            ],
            'description' => [
                'required',
                'string',
                'min:10'
            ],
            'status' => [
                'required',
                'in:draft,published,archived'
            ],
            'github_url' => [
                'nullable',
                'url',
                'starts_with:https://'
            ],
            'demo_url' => [
                'nullable',
                'url',
                'starts_with:https://'
            ],
            'date_realisation' => [
                'required',
                'date',
                'before_or_equal:today'
            ],
            'is_featured' => [
                'nullable',
                'boolean'
            ],
            'order' => [
                'required',
                'integer',
                'min:1'
            ],
            'type' => [
                'required',
                'string',
                'in:frontend,fullstack,backend'
            ],
            'technologies' => [
                'nullable',
                'array'
            ],
            'technologies.*' => [
                'integer',
                'exists:technologies,id'
            ]
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
