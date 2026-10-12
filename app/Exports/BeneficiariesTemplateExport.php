<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BeneficiariesTemplateExport implements FromArray, ShouldAutoSize, WithHeadings, WithStyles
{
    public function headings(): array
    {
        return [
            'رقم الهوية',
            'الاسم الأول',
            'اسم الأب',
            'اسم الجد',
            'اسم العائلة',
            'رقم الجوال',
            'تاريخ الميلاد (هجري)',
            'الجنس',
            'الحالة الاجتماعية',
            'المدينة',
            'الحي',
            'عدد أفراد الأسرة',
            'الدخل الشهري',
            'الفئة',
            'الحالة',
            'ملاحظات',
        ];
    }

    public function array(): array
    {
        return [
            [
                '1098765432',
                'محمد',
                'خالد',
                'عبدالله',
                'العتيبي',
                '0551234567',
                '1415-05-12',
                'ذكر',
                'متزوج',
                'الرياض',
                'النرجس',
                5,
                3500,
                'أسر محدودة الدخل',
                'نشط',
                'صف تجريبي توضيحي (يمكن تعديله أو حذفه)',
            ],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '006C35'],
                ],
            ],
        ];
    }
}
