<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * میان‌افزارهای全局 (برای تمام درخواست‌ها)
     *
     * @var array
     */
    protected $middleware = [
        // مدیریت CORS
        \App\Http\Middleware\CorsMiddleware::class,

        // بررسی حالت تعمیر و نگهداری
        \App\Http\Middleware\CheckForMaintenanceMode::class,

        // اعتبارسنجی اندازه درخواست
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,

        // حذف فضاهای خالی از داده‌های ورودی
        \App\Http\Middleware\TrimStrings::class,

        // تبدیل رشته‌های خالی به null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        // اعتبارسنجی داده‌های ورودی
        \App\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * گروه‌های میان‌افزار
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // رمزگذاری کوکی‌ها
            \Illuminate\Cookie\Middleware\EncryptCookies::class,

            // افزودن کوکی‌ها به درخواست
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,

            // شروع session
            \Illuminate\Session\Middleware\StartSession::class,

            // اشتراک‌گذاری خطاها با viewها
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,

            // اعتبارسنجی CSRF token
            \App\Http\Middleware\VerifyCsrfToken::class,

            // اتصال stateهای درخواست
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // محدود کردن نرخ درخواست‌ها
            \App\Http\Middleware\ThrottleRequests::class . ':60,1',

            // اتصال stateهای درخواست
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * میان‌افزارهای قابل اختصاص (Route Middleware)
     *
     * @var array
     */
    protected $routeMiddleware = [
        // احراز هویت کاربر
        'auth' => \App\Http\Middleware\Authenticate::class,

        // احراز هویت کاربر از طریق API
        'auth.api' => \App\Http\Middleware\AuthenticateApi::class,

        // بررسی مجوزهای کاربر
        'can' => \Illuminate\Auth\Middleware\Authorize::class,

        // بررسی نقش کاربر
        'role' => \App\Http\Middleware\CheckRole::class,

        // بررسی حالت تعمیر و نگهداری
        'maintenance' => \App\Http\Middleware\CheckForMaintenanceMode::class,

        // اعتبارسنجی امضا
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,

        // محدود کردن نرخ درخواست‌ها
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        // بررسی فعال‌سازی ایمیل
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];

    /**
     * اولویت‌های میان‌افزار
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
