<?php

namespace App\Exports;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BeneficiariesExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(protected array $filters = [])
    {
    }

    public function query(): Builder
    {
        $query = Beneficiary::query();

        // Apply filters dynamically
        if (isset($this->filters['project_id'])) {
            $query->whereHas('projects', function ($q) {
                $q->where('projects.id', $this->filters['project_id']);
                if (isset($this->filters['status'])) {
                    $q->where('project_beneficiary.status', $this->filters['status']);
                }
            });
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'National ID',
            'Name',
            'Phone',
            'Age',
        ];
    }

    public function map($beneficiary): array
    {
        return [
            $beneficiary->national_id,
            $beneficiary->name,
            $beneficiary->phone,
            $beneficiary->age,
        ];
    }
}
