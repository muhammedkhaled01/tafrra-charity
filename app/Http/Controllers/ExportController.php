<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct(protected ExportService $exportService) {}

    public function exportBeneficiaries(Request $request)
    {
        $tenant = auth()->user()->tenant;
        $format = $request->input('format', 'excel'); // excel or pdf
        $filters = $request->only(['project_id', 'status', 'search', 'city', 'ids']);

        if ($format === 'excel') {
            if (! $tenant->hasFeature('excel_export')) {
                return back()->with('error', 'باقتك الحالية لا تدعم تحميل الإكسيل. يرجى الترقية لباقة أعلى.');
            }

            return $this->exportService->exportToExcel($filters);
        }

        if ($format === 'pdf') {
            if (! $tenant->hasFeature('pdf_export')) {
                return back()->with('error', 'باقتك الحالية لا تدعم تحميل PDF. يرجى الترقية لباقة أعلى.');
            }

            return $this->exportService->exportToPdf($filters);
        }

        abort(400, 'Invalid export format.');
    }
}
