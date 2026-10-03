<?php

namespace App\Services;

use App\Exports\BeneficiariesExport;
use Maatwebsite\Excel\Facades\Excel;
use Meneses\LaravelMpdf\Facades\LaravelMpdf as PDF;

class ExportService
{
    /**
     * Export beneficiaries to Excel
     */
    public function exportToExcel(array $filters)
    {
        return Excel::download(new BeneficiariesExport($filters), 'beneficiaries.xlsx');
    }

    /**
     * Export beneficiaries to PDF (Supports RTL & Arabic using mPDF)
     */
    public function exportToPdf(array $filters)
    {
        $tenant = auth()->user()->tenant;
        
        // Use the same query logic as Excel for consistency
        $export = new BeneficiariesExport($filters);
        $beneficiaries = $export->query()->get();

        // Load the view and pass data to mPDF
        $pdf = PDF::loadView('exports.pdf.beneficiaries', [
            'beneficiaries' => $beneficiaries,
            'tenant' => $tenant,
            'date' => now()->format('Y-m-d')
        ], [], [
            'mode' => 'utf-8',
            'format' => 'A4',
            'autoArabic' => true,
        ]);

        return $pdf->download('beneficiaries.pdf');
    }
}
