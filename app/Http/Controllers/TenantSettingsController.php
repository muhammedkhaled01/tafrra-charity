<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenantSettingsController extends Controller
{
    public function edit()
    {
        $tenant = auth()->user()->tenant;

        return view('settings.edit', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = auth()->user()->tenant;

        $validated = $request->validate([
            'license_number' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'stamp' => 'nullable|image|max:2048',
            'signatures' => 'nullable|array',
            'signatures.*.name' => 'required_with:signatures|string|max:255',
            'signatures.*.title' => 'nullable|string|max:255',
            'signatures.*.file' => 'nullable|image|max:2048',
        ]);

        $tenant->license_number = $validated['license_number'] ?? $tenant->license_number;

        if ($request->hasFile('logo')) {
            if ($tenant->logo) {
                Storage::disk('public')->delete($tenant->logo);
            }
            $tenant->logo = $request->file('logo')->store('tenants/logos', 'public');
        }

        if ($request->hasFile('stamp')) {
            if ($tenant->stamp) {
                Storage::disk('public')->delete($tenant->stamp);
            }
            $tenant->stamp = $request->file('stamp')->store('tenants/stamps', 'public');
        }

        // Handle signatures
        $existingSignatures = $tenant->signatures ?? [];
        $newSignatures = [];

        if (isset($validated['signatures'])) {
            foreach ($validated['signatures'] as $index => $sigData) {
                $imagePath = $existingSignatures[$index]['image'] ?? null;

                if (isset($sigData['file']) && $sigData['file']) {
                    if ($imagePath) {
                        Storage::disk('public')->delete($imagePath);
                    }
                    $imagePath = $sigData['file']->store('tenants/signatures', 'public');
                }

                $newSignatures[] = [
                    'name' => $sigData['name'],
                    'title' => $sigData['title'] ?? '',
                    'image' => $imagePath,
                ];
            }
        }

        $tenant->signatures = $newSignatures;
        $tenant->save();

        return redirect()->back()->with('success', 'تم حفظ إعدادات الجمعية بنجاح.');
    }
}
