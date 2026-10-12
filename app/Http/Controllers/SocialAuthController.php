<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        if (empty(config('services.google.client_id')) || empty(config('services.google.client_secret'))) {
            return redirect()->route('login')->with('error', 'خدمة تسجيل الدخول بواسطة Google غير مهيأة بعد في إعدادات النظام.');
        }

        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and authenticate.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            Log::error('Google OAuth error: '.$e->getMessage());

            return redirect()->route('login')->with('error', 'حدث خطأ أثناء الاتصال بحساب Google، يرجى المحاولة مرة أخرى.');
        }

        $email = $googleUser->getEmail();
        $googleId = $googleUser->getId();

        if (empty($email)) {
            return redirect()->route('login')->with('error', 'تعذر جلب البريد الإلكتروني من حساب Google الخاص بك.');
        }

        // Search by google_id first, then by email
        $user = User::where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if (! $user) {
            return redirect()->route('login')->with('error', "البريد الإلكتروني ({$email}) غير مسجل في أي جمعية بالنظام. يرجى الاشتراك أولاً أو مراجعة إدارة الجمعية.");
        }

        // Link google_id and avatar if not set
        $needsSave = false;
        if (empty($user->google_id)) {
            $user->google_id = $googleId;
            $needsSave = true;
        }

        if (empty($user->avatar) && $googleUser->getAvatar()) {
            $user->avatar = $googleUser->getAvatar();
            $needsSave = true;
        }

        if ($needsSave) {
            $user->save();
        }

        // If user belongs to a tenant, check active status
        if (! $user->isSuperAdmin() && $user->tenant && ! $user->tenant->is_active) {
            return redirect()->route('login')->with('error', 'حساب الجمعية الخاصة بك موقوف حالياً، يرجى مراجعة إدارة المنصة.');
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        if ($user->isSuperAdmin() || ! $user->tenant) {
            return redirect()->route('super-admin.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
