<?php

namespace App\Http\Requests;

use App\Enums\BeneficiaryCategory;
use App\Enums\BeneficiaryStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBeneficiaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'national_id' => [
                'required',
                'string',
                'size:10',
                'regex:/^[12]\d{9}$/',
                Rule::unique('beneficiaries', 'national_id')->where(function ($query) {
                    return $query->where('tenant_id', auth()->user()->tenant_id);
                }),
            ],
            'first_name' => 'required|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'grandfather_name' => 'nullable|string|max:255',
            'family_name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^(05|9665|\+9665)\d{8}$/',
            ],
            'dob' => 'required|string|regex:/^\d{4}-\d{2}-\d{2}$/',
            'gender' => ['nullable', 'string', Rule::in(['male', 'female'])],
            'monthly_income' => 'nullable|numeric|min:0',
            'city' => 'required|string|max:255',
            'neighborhood' => 'nullable|string|max:255',
            'marital_status' => 'required|string|max:255',
            'category' => ['required', 'string', Rule::in(array_column(BeneficiaryCategory::cases(), 'value'))],
            'family_members' => 'required|integer|min:1',
            'status' => ['required', 'string', Rule::in(array_column(BeneficiaryStatus::cases(), 'value'))],
            'notes' => 'nullable|string',
            'goals' => 'nullable|string',
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
