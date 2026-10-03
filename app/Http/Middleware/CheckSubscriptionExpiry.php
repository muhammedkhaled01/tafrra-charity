<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Super admins are not blocked by tenant subscription limits
        if ($user && $user->isSuperAdmin()) {
            return $next($request);
        }

        if ($user && $user->tenant) {
            $tenant = $user->tenant;

            $isExpired = $tenant->subscription_expires_at && $tenant->subscription_expires_at->isPast();

            // Expired or deactivated charities are sent to the expiry page
            if (($isExpired || ! $tenant->is_active) && ! $request->routeIs('subscription.expired')) {
                return redirect()->route('subscription.expired');
            }
        }

        return $next($request);
    }
}
