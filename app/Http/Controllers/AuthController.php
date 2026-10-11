<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $intendedUrl = $request->session()->pull('url.intended');

            // Redirect based on role
            if (Auth::user()->isSuperAdmin()) {
                return redirect()->route('super-admin.dashboard');
            }

            if ($intendedUrl && ! $this->isSuperAdminUrl($intendedUrl)) {
                return redirect()->to($intendedUrl);
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'البيانات المدخلة غير صحيحة.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Determine whether the given URL points to the super admin area.
     */
    protected function isSuperAdminUrl(string $url): bool
    {
        $path = trim((string) parse_url($url, PHP_URL_PATH), '/');

        return $path === 'super-admin' || str_starts_with($path, 'super-admin/');
    }
}
