<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with('subscription')->latest()->paginate(15);
        return view('super-admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $subscriptions = Subscription::all();
        return view('super-admin.tenants.create', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        // Auto-generate a unique domain slug from the name
        $originalSlug = \Illuminate\Support\Str::slug($request->input('name') ?: 'charity');
        if (empty($originalSlug)) {
            $originalSlug = 'charity';
        }
        
        $domainSlug = $originalSlug;
        $counter = 1;
        $baseHost = parse_url(config('app.url'), PHP_URL_HOST) ?? 'tafrra.com';
        $baseHost = str_replace('www.', '', $baseHost);

        // Ensure uniqueness
        while (Tenant::where('domain', $domainSlug . '.' . $baseHost)->exists()) {
            $domainSlug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $fullDomain = $domainSlug . '.' . $baseHost;
        $request->merge(['domain' => $fullDomain]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|unique:tenants,domain',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string',
            'subscription_id' => 'required|exists:subscriptions,id',
            'expires_in_months' => 'required|integer|min:1',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'required|string|min:8',
        ]);

        $tenant = Tenant::create([
            'name' => $validated['name'],
            'domain' => $validated['domain'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subscription_id' => $validated['subscription_id'],
            'subscription_expires_at' => now()->addMonths((int) $validated['expires_in_months']),
            'is_active' => true,
        ]);

        $user = User::create([
            'tenant_id' => $tenant->id,
            'name' => $validated['admin_name'],
            'email' => $validated['admin_email'],
            'password' => Hash::make($validated['admin_password']),
        ]);

        $user->assignRole(\App\Enums\RoleName::CharityAdmin->value);

        return redirect()->route('super-admin.tenants.index')->with('success', 'Charity created and admin generated.');
    }

    public function edit(Tenant $tenant)
    {
        $subscriptions = Subscription::all();
        return view('super-admin.tenants.edit', compact('tenant', 'subscriptions'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $domainSlug = clone $request; // To prevent mutating original
        
        // If domain doesn't have a dot, assume it's just a slug
        if (!str_contains($request->input('domain'), '.')) {
            $domainSlug = \Illuminate\Support\Str::slug($request->input('domain') ?: $tenant->name);
            $baseHost = parse_url(config('app.url'), PHP_URL_HOST) ?? 'tafrra.com';
            $baseHost = str_replace('www.', '', $baseHost);
            $request->merge(['domain' => $domainSlug . '.' . $baseHost]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'domain' => 'required|string|unique:tenants,domain,' . $tenant->id,
            'subscription_id' => 'required|exists:subscriptions,id',
            'subscription_expires_at' => 'required|date',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
        ]);

        $tenant->update([
            'name' => $validated['name'],
            'domain' => $validated['domain'],
            'subscription_id' => $validated['subscription_id'],
            'subscription_expires_at' => Carbon::parse($validated['subscription_expires_at']),
            'is_active' => $request->has('is_active') ? true : false,
            'city' => $validated['city'] ?? $tenant->city,
            'phone' => $validated['phone'] ?? $tenant->phone,
            'email' => $validated['email'] ?? $tenant->email,
        ]);

        return redirect()->route('super-admin.tenants.index')->with('success', 'Charity updated successfully.');
    }
}
