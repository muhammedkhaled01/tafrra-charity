<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Services\BeneficiaryService;

class BeneficiaryController extends Controller
{
    public function __construct(protected BeneficiaryService $beneficiaryService)
    {
    }

    public function index(\Illuminate\Http\Request $request)
    {
        $query = Beneficiary::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('national_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

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
