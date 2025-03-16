<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Date;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * متد عمومی برای تولید پاسخ JSON.
     */
    protected function jsonResponse(
        bool $success,
        string $message,
        int $statusCode,
        mixed $data = null,
        mixed $errors = null,
        array $meta = [],
        array $links = []
    ): JsonResponse {
        $response = [
            'success' => $success,
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!$success && !is_null($errors)) {
            $response['errors'] = $errors;
        }

        if (!empty($meta)) {
            $response['meta'] = $meta;
        }

        if (!empty($links)) {
            $response['links'] = $links;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * بازگرداندن پاسخ موفقیت‌آمیز.
     */
    protected function successResponse(mixed $data = null, string $message = null, int $statusCode = 200, array $meta = [], array $links = []): JsonResponse
    {
        $message = $message ?? ResponseStatus::SUCCESS->message();
        return $this->jsonResponse(true, $message, $statusCode, $data, null, $meta, $links);
    }

    /**
     * بازگرداندن پاسخ خطا.
     */
    protected function errorResponse(string $message = null, int $statusCode = 400, mixed $errors = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::ERROR->message();
        return $this->jsonResponse(false, $message, $statusCode, null, $errors);
    }

    /**
     * پاسخ ایجاد منبع.
     */
    protected function createdResponse(mixed $data = null, string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::CREATED->message();
        return $this->successResponse($data, $message, 201);
    }

    /**
     * پاسخ خطای 404.
     */
    protected function notFoundResponse(string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::NOT_FOUND->message();
        return $this->errorResponse($message, 404);
    }

    /**
     * پاسخ خطای اعتبارسنجی.
     */
    protected function validationErrorResponse(mixed $errors, string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::VALIDATION_ERROR->message();
        return $this->errorResponse($message, 422, $errors);
    }

    /**
     * پاسخ خطای مجوز.
     */
    protected function forbiddenResponse(string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::FORBIDDEN->message();
        return $this->errorResponse($message, 403);
    }

    /**
     * پاسخ خطای احراز هویت.
     */
    protected function unauthorizedResponse(string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::UNAUTHORIZED->message();
        return $this->errorResponse($message, 401);
    }

    /**
     * پاسخ خطای درخواست‌های بیش از حد.
     */
    protected function tooManyRequestsResponse(string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::TOO_MANY_REQUESTS->message();
        return $this->errorResponse($message, 429);
    }

    /**
     * پاسخ خطای سرور.
     */
    protected function serverErrorResponse(string $message = null): JsonResponse
    {
        $message = $message ?? ResponseStatus::SERVER_ERROR->message();
        return $this->errorResponse($message, 500);
    }

    /**
     * پاسخ بدون محتوا (204).
     */
    protected function noContentResponse(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * پاسخ پذیرفته شده (202).
     */
    protected function acceptedResponse(mixed $data = null, string $message = null): JsonResponse
    {
        $message = $message ?? 'درخواست پذیرفته شد.';
        return $this->successResponse($data, $message, 202);
    }
}

/**
 * Enum برای وضعیت‌های پاسخ.
 */
enum ResponseStatus: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case NOT_FOUND = 'not_found';
    case VALIDATION_ERROR = 'validation_error';
    case FORBIDDEN = 'forbidden';
    case UNAUTHORIZED = 'unauthorized';
    case TOO_MANY_REQUESTS = 'too_many_requests';
    case SERVER_ERROR = 'server_error';
    case CREATED = 'created';

    public function message(): string
    {
        return __('messages.' . $this->value);
    }
}
