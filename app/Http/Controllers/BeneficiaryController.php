<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBeneficiaryRequest;
use App\Http\Requests\UpdateBeneficiaryRequest;
use App\Models\Beneficiary;
use App\Services\BeneficiaryService;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller
{
    public function __construct(protected BeneficiaryService $beneficiaryService) {}

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
