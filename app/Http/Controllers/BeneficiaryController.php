<?php

namespace App\Http\Controllers;

use App\Exports\BeneficiariesTemplateExport;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Imports\BeneficiariesImport;
use App\Models\Beneficiary;
use App\Services\BeneficiaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BeneficiaryController extends Controller
{
    public function __construct(protected BeneficiaryService $beneficiaryService) {}

    public function downloadTemplate()
    {
        return Excel::download(new BeneficiariesTemplateExport, 'نموذج_استيراد_المستفيدين.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (! in_array($ext, ['xlsx', 'xls', 'csv'])) {
                        $fail('يجب أن يكون الملف بصيغة Excel (xlsx, xls) أو CSV.');
                    }
                },
            ],
        ], [
            'file.required' => 'يرجى اختيار ملف الإكسيل لرفعه.',
            'file.file' => 'الملف المرفوع غير صالح.',
            'file.max' => 'حجم الملف يجب ألا يتجاوز 10 ميجابايت.',
        ]);

        try {
            $import = new BeneficiariesImport;
            Excel::import($import, $request->file('file'));
        } catch (\Throwable $e) {
            Log::error('Beneficiary import failed: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return redirect()->route('beneficiaries.index')
                ->with('error', 'حدث خطأ أثناء قراءة ملف الإكسيل: '.$e->getMessage());
        }

        $messageParts = [];
        if ($import->importedCount > 0) {
            $messageParts[] = "تمت إضافة {$import->importedCount} مستفيد جديد بنجاح.";
        }
        if ($import->updatedCount > 0) {
            $messageParts[] = "تم تحديث بيانات {$import->updatedCount} مستفيد مسجل مسبقاً.";
        }

        $successMsg = ! empty($messageParts)
            ? implode(' ', $messageParts)
            : 'تمت معالجة الملف، لم يتم العثور على سجلات جديدة.';

        if (! empty($import->errors)) {
            return redirect()->route('beneficiaries.index')
                ->with('success', $successMsg)
                ->with('warning', implode(' | ', array_slice($import->errors, 0, 3)));
        }

        return redirect()->route('beneficiaries.index')->with('success', $successMsg);
    }

    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:100'],
            'marital_status' => ['nullable', 'string', 'max:50'],
        ]);

        $query = Beneficiary::query()
            ->search($filters['search'] ?? null)
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['city'] ?? null, fn ($query, string $city) => $query->where('city', $city))
            ->when($filters['marital_status'] ?? null, fn ($query, string $maritalStatus) => $query->where('marital_status', $maritalStatus));

        $beneficiaries = $query->latest()->paginate(15)->withQueryString();

        return view('beneficiaries.index', compact('beneficiaries'));
    }

    public function create()
    {
        return view('beneficiaries.create');
    }

    public function store(StoreBeneficiaryRequest $request)
    {
        $beneficiary = $this->beneficiaryService->create($request->validated());

        return redirect()->route('beneficiaries.show', $beneficiary)->with('success', 'Beneficiary created successfully.');
    }

    public function show(Beneficiary $beneficiary)
    {
        $beneficiary->load(['sponsorships.donor', 'projects']);

        return view('beneficiaries.show', compact('beneficiary'));
    }

    public function edit(Beneficiary $beneficiary)
    {
        return view('beneficiaries.edit', compact('beneficiary'));
    }

    public function update(UpdateBeneficiaryRequest $request, Beneficiary $beneficiary)
    {
        $this->beneficiaryService->update($beneficiary, $request->validated());

        return redirect()->route('beneficiaries.show', $beneficiary)->with('success', 'Beneficiary updated successfully.');
    }

    public function destroy(Beneficiary $beneficiary)
    {
        $this->beneficiaryService->delete($beneficiary);

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary deleted successfully.');
    }
}
