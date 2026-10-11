<?php

namespace App\Exports;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BeneficiariesExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(protected array $filters = []) {}

    public function query(): Builder
    {
        $query = Beneficiary::query();

        // Specific IDs selected
        if (! empty($this->filters['ids'])) {
            $ids = is_array($this->filters['ids']) ? $this->filters['ids'] : explode(',', $this->filters['ids']);

            // When explicit IDs are provided, we just return them
            return $query->whereIn('id', $ids);
        }

        // Apply filters dynamically
        if (! empty($this->filters['project_id'])) {
            $query->whereHas('projects', function ($q) {
                $q->where('projects.id', $this->filters['project_id']);
                if (isset($this->filters['status'])) {
                    $q->where('project_beneficiary.status', $this->filters['status']);
                }
            });
        } else {
            // General status filter
            if (! empty($this->filters['status'])) {
                $query->where('status', $this->filters['status']);
            }
        }

        if (! empty($this->filters['search'])) {
            $query->search($this->filters['search']);
        }

        if (! empty($this->filters['city'])) {
            $query->where('city', $this->filters['city']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'رقم الهوية',
            'الاسم',
            'الجوال',
            'تاريخ الميلاد (هجري)',
            'العمر',
            'الجنس',
            'المدينة',
            'نوع الحالة',
            'الحالة',
            'الدخل الشهري',
            'أفراد الأسرة',
        ];
    }

    public function map($beneficiary): array
    {
        return [
            $beneficiary->national_id,
            $beneficiary->name,
            $beneficiary->phone,
            $beneficiary->dob ?? 'غير محدد',
            $beneficiary->age,
            $beneficiary->gender?->value === 'male' ? 'ذكر' : ($beneficiary->gender?->value === 'female' ? 'أنثى' : 'غير محدد'),
            $beneficiary->city,
            $beneficiary->category?->label() ?? '---',
            $beneficiary->status?->label() ?? '---',
            $beneficiary->monthly_income ?? 0,
            $beneficiary->family_members ?? 0,
        ];
    }
}
