<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureFeatureIsEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $feature): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        if (! $user->hasFeature($feature)) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'هذه الميزة غير متوفرة في باقة اشتراك الجمعية الحالية.',
                ], 403);
            }

            return redirect()->route('dashboard')->with('error', 'هذه الميزة غير متوفرة في باقة اشتراك الجمعية الحالية. يرجى ترقية الباقة للاستفادة منها.');
        }

        return $next($request);
    }
}
