<?php

namespace App;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use App\Events\EventServiceProvider;
use App\Listeners\ListenerServiceProvider;

class Kernel extends HttpKernel
{
    /**
     * لیست سرویس‌پروایدرهای برنامه
     *
     * @var array
     */
    protected $serviceProviders = [
        // سرویس‌پروایدرهای پیش‌فرض
        \Illuminate\Auth\AuthServiceProvider::class,
        \Illuminate\Cache\CacheServiceProvider::class,
        \Illuminate\Routing\RoutingServiceProvider::class,
        \Illuminate\Session\SessionServiceProvider::class,
        \Illuminate\View\ViewServiceProvider::class,

        // سرویس‌پروایدرهای سفارشی
        EventServiceProvider::class,
        ListenerServiceProvider::class,
    ];

    /**
     * لیست میان‌افزارهای برنامه
     *
     * @var array
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * لیست گروه‌های میان‌افزار
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * لیست میان‌افزارهای قابل اختصاص
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
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

    /**
     * اجرای مراحل راه‌اندازی برنامه
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app): void
    {
        parent::bootstrap($app);

        // ثبت سرویس‌پروایدرهای سفارشی
        foreach ($this->serviceProviders as $provider) {
            $app->register($provider);
        }

        // تنظیمات اولیه قالب
        $this->initializeTheme();
    }

    /**
     * تنظیمات اولیه قالب
     *
     * @return void
     */
    protected function initializeTheme(): void
    {
        // تنظیمات مربوط به قالب
        add_action('after_setup_theme', [$this, 'setupTheme']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);
    }

    /**
     * تنظیمات قالب
     *
     * @return void
     */
    public function setupTheme(): void
    {
        // پشتیبانی از قابلیت‌های وردپرس
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo');
        add_theme_support('html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]);

        // ثبت منوها
        register_nav_menus([
            'primary' => __('منوی اصلی', 'theme-name'),
            'footer' => __('منوی فوتر', 'theme-name'),
        ]);
    }

    /**
     * افزودن اسکریپت‌ها و استایل‌ها
     *
     * @return void
     */
    public function enqueueScripts(): void
    {
        // افزودن استایل‌ها
        wp_enqueue_style('theme-style', get_stylesheet_uri());

        // افزودن اسکریپت‌ها
        wp_enqueue_script('theme-script', get_template_directory_uri() . '/js/app.js', [], null, true);
    }
}
