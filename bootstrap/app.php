<?php

use App\Http\Middleware\CheckSubscriptionExpiry;
use App\Http\Middleware\EnsureFeatureIsEnabled;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'subscription.active' => CheckSubscriptionExpiry::class,
            'feature' => EnsureFeatureIsEnabled::class,
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
        ]);

        $middleware->redirectUsersTo(fn (Request $request): string => $request->user()?->isSuperAdmin()
            ? route('super-admin.dashboard')
            : route('dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (UnauthorizedException $exception, Request $request) {
            if ($request->expectsJson() || ! $request->user() || $request->routeIs('dashboard')) {
                return null;
            }

            return redirect()->route('dashboard')->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
        });
    })->create();
