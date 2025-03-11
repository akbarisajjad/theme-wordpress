<?php

namespace App;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Foundation\Bootstrap\HandleExceptions;
use Illuminate\Foundation\Bootstrap\RegisterFacades;
use Illuminate\Foundation\Bootstrap\RegisterProviders;
use Illuminate\Foundation\Bootstrap\BootProviders;
use Illuminate\Foundation\Bootstrap\SetRequestForConsole;
use Illuminate\Foundation\Bootstrap\RegisterConsoleKernel;

class Bootstrap
{
    /**
     * اجرای مراحل راه‌اندازی برنامه
     *
     * @param Application $app
     * @return void
     */
    public static function boot(Application $app): void
    {
        // 1. بارگذاری متغیرهای محیطی
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        // 2. بارگذاری تنظیمات
        $app->bootstrapWith([LoadConfiguration::class]);

        // 3. مدیریت خطاها
        $app->bootstrapWith([HandleExceptions::class]);

        // 4. ثبت فاسادها (Facades)
        $app->bootstrapWith([RegisterFacades::class]);

        // 5. ثبت سرویس‌پروایدرها
        $app->bootstrapWith([RegisterProviders::class]);

        // 6. اجرای سرویس‌پروایدرها
        $app->bootstrapWith([BootProviders::class]);

        // 7. تنظیم درخواست برای حالت کنسول
        $app->bootstrapWith([SetRequestForConsole::class]);

        // 8. ثبت کرنل کنسول
        $app->bootstrapWith([RegisterConsoleKernel::class]);

        // 9. اجرای تنظیمات سفارشی
        self::registerCustomServices($app);
        self::registerCustomAliases($app);
    }

    /**
     * ثبت سرویس‌های سفارشی
     *
     * @param Application $app
     * @return void
     */
    protected static function registerCustomServices(Application $app): void
    {
        // مثال: ثبت یک سرویس سفارشی
        $app->singleton('custom.service', function ($app) {
            return new \App\Services\CustomService();
        });
    }

    /**
     * ثبت aliasهای سفارشی
     *
     * @param Application $app
     * @return void
     */
    protected static function registerCustomAliases(Application $app): void
    {
        // مثال: ثبت یک فاساد سفارشی
        $app->alias('custom.service', \App\Facades\CustomFacade::class);
    }
}
