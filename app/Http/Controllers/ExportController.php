<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct(protected ExportService $exportService)
    {
    }

    public function exportBeneficiaries(Request $request)
    {
        $tenant = auth()->user()->tenant;
        $format = $request->input('format', 'excel'); // excel or pdf
        $filters = $request->only(['project_id', 'status']);

        if ($format === 'excel') {
            if (!$tenant->hasFeature('excel_export')) {
                abort(403, 'Your plan does not support Excel exports.');
            }
            return $this->exportService->exportToExcel($filters);
        }

        if ($format === 'pdf') {
            if (!$tenant->hasFeature('pdf_export')) {
                abort(403, 'Your plan does not support PDF exports. Please upgrade to Pro or Enterprise.');
            }
            return $this->exportService->exportToPdf($filters);
        }

        abort(400, 'Invalid export format.');
    }
}
