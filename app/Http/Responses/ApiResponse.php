<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * برگرداندن پاسخ موفقیت‌آمیز
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public static function success($data = null, string $message = 'عملیات موفقیت‌آمیز بود.', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * برگرداندن پاسخ خطا
     *
     * @param  string  $message
     * @param  int  $statusCode
     * @param  mixed  $errors
     * @return JsonResponse
     */
    public static function error(string $message = 'خطایی رخ داده است.', int $statusCode = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     * برگرداندن پاسخ عدم دسترسی
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public static function forbidden(string $message = 'شما مجوز دسترسی به این بخش را ندارید.'): JsonResponse
    {
        return self::error($message, 403);
    }

    /**
     * برگرداندن پاسخ عدم یافتن منبع
     *
     * @param  string  $message
     * @return JsonResponse
     */
    public static function notFound(string $message = 'منبع مورد نظر یافت نشد.'): JsonResponse
    {
        return self::error($message, 404);
    }
}
