<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\SubscriptionRequest;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SubscriptionRequestController extends Controller
{
    public function create(Subscription $subscription, GeneralSettings $settings)
    {
        return view('subscribe', compact('subscription', 'settings'));
    }

    public function store(Request $request, Subscription $subscription)
    {
        $request->validate([
            'charity_name' => 'required|string|max:255',
            'manager_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'transfer_receipt' => 'required|image|max:5120',
        ]);

        $receiptPath = $request->file('transfer_receipt')->store('receipts', 'public');

        SubscriptionRequest::create([
            'subscription_id' => $subscription->id,
            'charity_name' => $request->charity_name,
            'manager_name' => $request->manager_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'transfer_receipt' => $receiptPath,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'تم تقديم طلب الاشتراك بنجاح. ستتم مراجعة الطلب والموافقة عليه خلال 24 ساعة.');
    }
}
