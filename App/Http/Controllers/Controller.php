<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * بازگرداندن پاسخ موفقیت‌آمیز به صورت JSON
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse($data = null, string $message = 'عملیات با موفقیت انجام شد.', int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * بازگرداندن پاسخ خطا به صورت JSON
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message = 'خطایی رخ داده است.', int $statusCode = 400, $errors = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], $statusCode);
    }

    /**
     * بازگرداندن پاسخ خطای 404 به صورت JSON
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'منبع مورد نظر یافت نشد.'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    /**
     * بازگرداندن پاسخ خطای اعتبارسنجی به صورت JSON
     *
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     */
    protected function validationErrorResponse($errors, string $message = 'خطا در اعتبارسنجی داده‌ها.'): JsonResponse
    {
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * بازگرداندن پاسخ خطای دسترسی غیرمجاز به صورت JSON
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbiddenResponse(string $message = 'شما مجوز دسترسی به این بخش را ندارید.'): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    /**
     * بازگرداندن پاسخ خطای سرور به صورت JSON
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function serverErrorResponse(string $message = 'خطای سرور رخ داده است.'): JsonResponse
    {
        return $this->errorResponse($message, 500);
    }
}
