<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonorRequest;
use App\Http\Requests\UpdateDonorRequest;
use App\Models\Donor;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::latest()->paginate(15);

        return view('donors.index', compact('donors'));
    }

    public function create()
    {
        return view('donors.create');
    }

    public function store(StoreDonorRequest $request)
    {
        Donor::create($request->validated());

        return redirect()->route('donors.index')->with('success', 'تم إضافة الداعم بنجاح');
    }

    public function show(Donor $donor)
    {
        $donor->load(['sponsorships.beneficiary']);

        return view('donors.show', compact('donor'));
    }

    public function edit(Donor $donor)
    {
        return view('donors.edit', compact('donor'));
    }

    public function update(UpdateDonorRequest $request, Donor $donor)
    {
        $donor->update($request->validated());

        return redirect()->route('donors.index')->with('success', 'تم تحديث بيانات الداعم بنجاح');
    }

    public function destroy(Donor $donor)
    {
        $donor->delete();

        return redirect()->route('donors.index')->with('success', 'تم حذف الداعم بنجاح');
    }
}
