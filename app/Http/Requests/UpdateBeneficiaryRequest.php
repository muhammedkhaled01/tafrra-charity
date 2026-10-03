<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'national_id' => [
                'sometimes',
                'string',
                'size:10',
                'regex:/^[12]\d{9}$/',
                Rule::unique('beneficiaries', 'national_id')
                    ->ignore($this->beneficiary)
                    ->where(function ($query) {
                        return $query->where('tenant_id', auth()->user()->tenant_id);
                    }),
            ],
            'name' => 'sometimes|string|max:255',
            'phone' => [
                'sometimes',
                'string',
                'regex:/^(05|9665|\+9665)\d{8}$/',
            ],
            'dob' => 'sometimes|date|before:today',
            'city' => 'sometimes|string|max:255',
            'gender' => ['sometimes', 'string', Rule::in(array_column(\App\Enums\Gender::cases(), 'value'))],
            'category' => ['sometimes', 'string', Rule::in(array_column(\App\Enums\BeneficiaryCategory::cases(), 'value'))],
            'family_members' => 'sometimes|integer|min:1',
            'monthly_income' => 'sometimes|numeric|min:0',
            'status' => ['sometimes', 'string', Rule::in(array_column(\App\Enums\BeneficiaryStatus::cases(), 'value'))],
        ];
    }

    public function messages(): array
    {
        return [
            'national_id.regex' => 'The national ID must start with 1 (Citizen) or 2 (Resident) and contain exactly 10 digits.',
            'national_id.unique' => 'This national ID is already registered in your charity.',
            'phone.regex' => 'The phone number must be a valid Saudi number (e.g., 05..., 9665..., +9665...).',
        ];
    }
}
