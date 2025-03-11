<?php

namespace App\Http\Controllers;

use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class AIController extends Controller
{
    protected $aiService;

    /**
     * Constructor برای تزریق وابستگی‌ها
     *
     * @param AIService $aiService
     */
    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * آموزش مدل هوش مصنوعی
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function trainModel(Request $request): JsonResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'dataset' => 'required|string', // مسیر یا شناسه دیتاست
            'epochs' => 'required|integer|min:1', // تعداد دوره‌های آموزش
            'batch_size' => 'required|integer|min:1', // اندازه بچ
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطا برگردان
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'خطا در اعتبارسنجی داده‌ها.',
            ], 422);
        }

        // آموزش مدل
        $trainingResult = $this->aiService->trainModel(
            $request->dataset,
            $request->epochs,
            $request->batch_size
        );

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $trainingResult,
            'message' => 'مدل با موفقیت آموزش داده شد.',
        ]);
    }

    /**
     * پیش‌بینی با استفاده از مدل آموزش‌دیده
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function predict(Request $request): JsonResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'input_data' => 'required|string', // داده‌های ورودی برای پیش‌بینی
            'model_id' => 'required|string', // شناسه مدل آموزش‌دیده
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطا برگردان
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'خطا در اعتبارسنجی داده‌ها.',
            ], 422);
        }

        // انجام پیش‌بینی
        $prediction = $this->aiService->predict(
            $request->input_data,
            $request->model_id
        );

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $prediction,
            'message' => 'پیش‌بینی با موفقیت انجام شد.',
        ]);
    }

    /**
     * ارزیابی مدل آموزش‌دیده
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function evaluateModel(Request $request): JsonResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'test_dataset' => 'required|string', // مسیر یا شناسه دیتاست تست
            'model_id' => 'required|string', // شناسه مدل آموزش‌دیده
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطا برگردان
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'خطا در اعتبارسنجی داده‌ها.',
            ], 422);
        }

        // ارزیابی مدل
        $evaluationResult = $this->aiService->evaluateModel(
            $request->test_dataset,
            $request->model_id
        );

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $evaluationResult,
            'message' => 'مدل با موفقیت ارزیابی شد.',
        ]);
    }

    /**
     * دریافت لیست مدل‌های آموزش‌دیده
     *
     * @return JsonResponse
     */
    public function getTrainedModels(): JsonResponse
    {
        // دریافت لیست مدل‌ها
        $models = $this->aiService->getTrainedModels();

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $models,
            'message' => 'لیست مدل‌ها با موفقیت دریافت شد.',
        ]);
    }

    /**
     * دریافت اطلاعات یک مدل خاص
     *
     * @param string $modelId
     * @return JsonResponse
     */
    public function getModelDetails(string $modelId): JsonResponse
    {
        // دریافت اطلاعات مدل
        $modelDetails = $this->aiService->getModelDetails($modelId);

        // اگر مدل پیدا نشد، خطا برگردان
        if (!$modelDetails) {
            return response()->json([
                'success' => false,
                'message' => 'مدل مورد نظر یافت نشد.',
            ], 404);
        }

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $modelDetails,
            'message' => 'اطلاعات مدل با موفقیت دریافت شد.',
        ]);
    }

    /**
     * حذف یک مدل آموزش‌دیده
     *
     * @param string $modelId
     * @return JsonResponse
     */
    public function deleteModel(string $modelId): JsonResponse
    {
        // حذف مدل
        $deleted = $this->aiService->deleteModel($modelId);

        // اگر مدل پیدا نشد، خطا برگردان
        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'مدل مورد نظر یافت نشد.',
            ], 404);
        }

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'message' => 'مدل با موفقیت حذف شد.',
        ]);
    }
}
