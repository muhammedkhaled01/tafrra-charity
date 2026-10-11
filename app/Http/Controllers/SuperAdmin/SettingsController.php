<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Settings\GeneralSettings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function seo(GeneralSettings $settings)
    {
        return view('super-admin.settings.seo', compact('settings'));
    }

    public function updateSeo(Request $request, GeneralSettings $settings)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string|max:1000',
            'site_keywords' => 'required|string|max:500',
            'support_email' => 'required|email|max:255',
            'support_phone' => 'required|string|max:20',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_iban' => 'nullable|string|max:255',
        ]);

        $settings->site_name = $request->site_name;
        $settings->site_description = $request->site_description;
        $settings->site_keywords = $request->site_keywords;
        $settings->support_email = $request->support_email;
        $settings->support_phone = $request->support_phone;
        $settings->facebook_url = $request->facebook_url;
        $settings->twitter_url = $request->twitter_url;
        $settings->instagram_url = $request->instagram_url;
        $settings->bank_name = $request->bank_name;
        $settings->bank_account_name = $request->bank_account_name;
        $settings->bank_iban = $request->bank_iban;

        $settings->save();

        return redirect()->back()->with('success', 'تم تحديث إعدادات الموقع بنجاح!');
    }
}
