<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد سیستم شوید.');
        }

        $user = Auth::user();
        if ($user->role !== $role) {
            return redirect()->route('home')->with('error', 'شما مجوز دسترسی به این صفحه را ندارید.');
        }

        return $next($request);
    }
}
