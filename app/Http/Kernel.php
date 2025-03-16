<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * لیست میان‌افزارهای全局 که برای هر درخواست اعمال می‌شوند.
     *
     * @var array
     */
    protected $middleware = [
        // میان‌افزارهای عمومی مانند بررسی CSRF، فشرده‌سازی پاسخ‌ها و غیره.
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * گروه‌های میان‌افزار که می‌توانید به مسیرها یا کنترلرها اختصاص دهید.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // میان‌افزارهای مربوط به درخواست‌های وب
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // میان‌افزارهای مربوط به درخواست‌های API
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * لیست میان‌افزارهای قابل اختصاص به مسیرها یا کنترلرها.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.api' => \App\Http\Middleware\ApiAuth::class,
        'check.role' => \App\Http\Middleware\CheckRole::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
    ];

    /**
     * اولویت‌های میان‌افزارها.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Routing\Middleware\ThrottleRequests::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
