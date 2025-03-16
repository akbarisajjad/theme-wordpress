<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد سیستم شوید.');
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $guard
     * @return Response
     */
    public function handle(Request $request, Closure $next, ?string $guard = null): Response
    {
        // اگر کاربر احراز هویت نشده باشد
        if (Auth::guard($guard)->guest()) {
            // اگر درخواست از نوع AJAX باشد
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'شما مجوز دسترسی به این بخش را ندارید.',
                ], 401);
            }

            // هدایت به صفحه‌ی لاگین
            return redirect()->route('login');
        }

        // ادامه پردازش درخواست
        return $next($request);
    }
}
