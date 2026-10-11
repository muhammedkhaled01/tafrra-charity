<?php

namespace App\Http\Controllers;

use App\Enums\BeneficiaryStatus;
use App\Http\Requests\StoreSponsorshipRequest;
use App\Http\Requests\UpdateSponsorshipRequest;
use App\Models\Beneficiary;
use App\Models\Donor;
use App\Models\Sponsorship;

class SponsorshipController extends Controller
{
    public function index()
    {
        $sponsorships = Sponsorship::with(['donor', 'beneficiary'])->latest()->paginate(15);

        return view('sponsorships.index', compact('sponsorships'));
    }

    public function create()
    {
        $donors = Donor::where('status', 'active')->get();
        $beneficiaries = Beneficiary::where('status', BeneficiaryStatus::Active)->get();

        return view('sponsorships.create', compact('donors', 'beneficiaries'));
    }

    public function store(StoreSponsorshipRequest $request)
    {
        Sponsorship::create($request->validated());

        return redirect()->route('sponsorships.index')->with('success', 'تم إنشاء الكفالة بنجاح');
    }

    public function show(Sponsorship $sponsorship)
    {
        //
    }

    public function edit(Sponsorship $sponsorship)
    {
        $donors = Donor::where('status', 'active')->get();
        $beneficiaries = Beneficiary::where('status', BeneficiaryStatus::Active)->get();

        return view('sponsorships.edit', compact('sponsorship', 'donors', 'beneficiaries'));
    }

    public function update(UpdateSponsorshipRequest $request, Sponsorship $sponsorship)
    {
        $sponsorship->update($request->validated());

        return redirect()->route('sponsorships.index')->with('success', 'تم تحديث بيانات الكفالة بنجاح');
    }

    public function destroy(Sponsorship $sponsorship)
    {
        //
    }
}
