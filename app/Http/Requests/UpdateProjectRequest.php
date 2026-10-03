<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'category' => ['sometimes', 'required', \Illuminate\Validation\Rule::enum(\App\Enums\ProjectCategory::class)],
            'budget' => 'sometimes|required|numeric|min:0',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'sometimes|in:planned,active,completed',
        ];
    }
}
