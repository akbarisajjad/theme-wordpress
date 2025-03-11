<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class JsonResponse
{
    /**
     * برگرداندن پاسخ JSON
     *
     * @param  mixed  $data
     * @param  string  $message
     * @param  string  $status
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public static function make($data = null, string $message = '', string $status = 'success', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * برگرداندن پاسخ JSON برای خطاها
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
     * برگرداندن پاسخ JSON برای موفقیت‌ها
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
}
