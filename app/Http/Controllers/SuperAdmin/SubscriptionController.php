<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enums\SubscriptionFeature;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::withCount('tenants')->latest()->paginate(15);

        return view('super-admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        return view('super-admin.subscriptions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_beneficiaries' => 'required|integer',
            'features' => 'nullable|array',
        ]);

        $featuresArray = [];
        foreach (SubscriptionFeature::cases() as $feature) {
            $featuresArray[$feature->value] = in_array($feature->value, $request->input('features', []));
        }

        Subscription::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'max_beneficiaries' => $validated['max_beneficiaries'],
            'features' => $featuresArray,
        ]);

        return redirect()->route('super-admin.subscriptions.index')->with('success', 'تم إنشاء باقة الاشتراك بنجاح!');
    }

    public function edit(Subscription $subscription)
    {
        return view('super-admin.subscriptions.edit', compact('subscription'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'max_beneficiaries' => 'required|integer',
            'features' => 'nullable|array',
        ]);

        $featuresArray = [];
        foreach (SubscriptionFeature::cases() as $feature) {
            $featuresArray[$feature->value] = in_array($feature->value, $request->input('features', []));
        }

        $subscription->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'max_beneficiaries' => $validated['max_beneficiaries'],
            'features' => $featuresArray,
        ]);

        return redirect()->route('super-admin.subscriptions.index')->with('success', 'تم تحديث بيانات الباقة بنجاح!');
    }

    public function destroy(Subscription $subscription)
    {
        if ($subscription->tenants()->count() > 0) {
            return back()->with('error', 'عفواً، لا يمكن حذف الباقة لأن هناك جمعيات مشتركة بها حالياً. قم بنقلهم لباقة أخرى أولاً.');
        }

        $subscription->delete();

        return redirect()->route('super-admin.subscriptions.index')->with('success', 'تم حذف الباقة نهائياً.');
    }
}
