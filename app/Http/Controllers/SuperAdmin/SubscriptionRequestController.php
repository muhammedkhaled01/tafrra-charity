<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubscriptionRequestController extends Controller
{
    public function index()
    {
        $requests = SubscriptionRequest::with('subscription')->latest()->paginate(15);

        return view('super-admin.subscription_requests.index', compact('requests'));
    }

    public function show(SubscriptionRequest $subscriptionRequest)
    {
        return view('super-admin.subscription_requests.show', compact('subscriptionRequest'));
    }

    public function approve(SubscriptionRequest $subscriptionRequest)
    {
        if ($subscriptionRequest->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت معالجته مسبقاً.');
        }

        DB::transaction(function () use ($subscriptionRequest) {
            // 1. Create Tenant
            $tenant = Tenant::create([
                'name' => $subscriptionRequest->charity_name,
                'domain' => Str::slug($subscriptionRequest->charity_name).'-'.Str::random(5),
                'email' => $subscriptionRequest->email,
                'phone' => $subscriptionRequest->phone,
                'subscription_id' => $subscriptionRequest->subscription_id,
                'subscription_expires_at' => now()->addMonth(), // Example: 1 month duration
                'is_active' => true,
            ]);

            // 2. Create User
            $user = User::create([
                'name' => $subscriptionRequest->manager_name,
                'email' => $subscriptionRequest->email,
                'password' => $subscriptionRequest->password, // Already hashed
                'tenant_id' => $tenant->id,
            ]);

            // Assign role if needed (Assuming Spatie Roles)
            $user->assignRole('charity_admin');

            // 3. Mark request as approved
            $subscriptionRequest->update(['status' => 'approved']);
        });

        return redirect()->route('super-admin.subscription-requests.index')->with('success', 'تمت الموافقة على الطلب وتم إنشاء حساب الجمعية بنجاح.');
    }

    public function reject(SubscriptionRequest $subscriptionRequest)
    {
        if ($subscriptionRequest->status !== 'pending') {
            return back()->with('error', 'هذا الطلب تمت معالجته مسبقاً.');
        }

        $subscriptionRequest->update(['status' => 'rejected']);

        return redirect()->route('super-admin.subscription-requests.index')->with('success', 'تم رفض الطلب بنجاح.');
    }
}
