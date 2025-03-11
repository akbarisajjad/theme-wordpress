<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * نمایش فرم ثبت‌نام
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(): \Illuminate\View\View
    {
        return view('auth.register');
    }

    /**
     * ثبت‌نام کاربر جدید
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطاها را برگردان
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ایجاد کاربر جدید
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ورود خودکار کاربر پس از ثبت‌نام
        Auth::login($user);

        // ریدایرکت به صفحه اصلی با پیام موفقیت
        return redirect()->route('home')->with('success', 'ثبت‌نام شما با موفقیت انجام شد!');
    }

    /**
     * نمایش فرم ورود
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    /**
     * ورود کاربر
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // تلاش برای ورود کاربر
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // ریدایرکت به صفحه اصلی با پیام موفقیت
            return redirect()->route('home')->with('success', 'ورود شما با موفقیت انجام شد!');
        }

        // اگر ورود ناموفق بود، خطا برگردان
        return back()->withErrors([
            'email' => 'اطلاعات وارد شده معتبر نیستند.',
        ])->onlyInput('email');
    }

    /**
     * خروج کاربر
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        // خروج کاربر
        Auth::logout();

        // باطل کردن session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // ریدایرکت به صفحه اصلی
        return redirect()->route('home')->with('success', 'خروج شما با موفقیت انجام شد!');
    }

    /**
     * نمایش فرم بازیابی رمز عبور
     *
     * @return \Illuminate\View\View
     */
    public function showForgotPasswordForm(): \Illuminate\View\View
    {
        return view('auth.forgot-password');
    }

    /**
     * ارسال لینک بازیابی رمز عبور
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request): \Illuminate\Http\RedirectResponse
    {
        // اعتبارسنجی ایمیل
        $request->validate(['email' => 'required|email']);

        // ارسال لینک بازیابی رمز عبور
        $status = Password::sendResetLink(
            $request->only('email')
        );

        // بررسی وضعیت ارسال لینک
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * نمایش فرم بازنشانی رمز عبور
     *
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function showResetPasswordForm(string $token): \Illuminate\View\View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * بازنشانی رمز عبور
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // بازنشانی رمز عبور
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
            }
        );

        // بررسی وضعیت بازنشانی رمز عبور
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('success', 'رمز عبور شما با موفقیت بازنشانی شد!')
            : back()->withErrors(['email' => __($status)]);
    }
}
