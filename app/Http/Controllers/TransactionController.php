<?php

namespace App\Http\Controllers;

use App\Enums\BeneficiaryStatus;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Beneficiary;
use App\Models\Donor;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['donor', 'beneficiary'])->latest()->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $donors = Donor::where('status', 'active')->get();
        $beneficiaries = Beneficiary::where('status', BeneficiaryStatus::Active)->get();

        return view('transactions.create', compact('donors', 'beneficiaries'));
    }

    public function store(StoreTransactionRequest $request)
    {
        Transaction::create($request->validated());

        return redirect()->route('transactions.index')->with('success', 'تم تسجيل السند المالي بنجاح.');
    }

    public function show(Transaction $transaction)
    {
        //
    }

    public function edit(Transaction $transaction)
    {
        //
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    public function destroy(Transaction $transaction)
    {
        //
    }
}
