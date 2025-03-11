<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    protected $postService;

    /**
     * Constructor برای تزریق وابستگی‌ها
     *
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * دریافت لیست پست‌ها
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPosts(Request $request): JsonResponse
    {
        // دریافت پست‌ها با pagination
        $posts = $this->postService->getPublishedPosts(10);

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $posts,
            'message' => 'لیست پست‌ها با موفقیت دریافت شد.',
        ]);
    }

    /**
     * دریافت اطلاعات یک پست خاص
     *
     * @param int $id
     * @return JsonResponse
     */
    public function getPost(int $id): JsonResponse
    {
        // دریافت پست بر اساس ID
        $post = $this->postService->getPostById($id);

        // اگر پست پیدا نشد، خطا برگردان
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'پست مورد نظر یافت نشد.',
            ], 404);
        }

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'اطلاعات پست با موفقیت دریافت شد.',
        ]);
    }

    /**
     * ایجاد یک پست جدید
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createPost(Request $request): JsonResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطا برگردان
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'خطا در اعتبارسنجی داده‌ها.',
            ], 422);
        }

        // ایجاد پست جدید
        $post = $this->postService->createPost($request->all());

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'پست با موفقیت ایجاد شد.',
        ], 201);
    }

    /**
     * به‌روزرسانی یک پست
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updatePost(Request $request, int $id): JsonResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطا برگردان
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => 'خطا در اعتبارسنجی داده‌ها.',
            ], 422);
        }

        // به‌روزرسانی پست
        $post = $this->postService->updatePost($id, $request->all());

        // اگر پست پیدا نشد، خطا برگردان
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'پست مورد نظر یافت نشد.',
            ], 404);
        }

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'data' => $post,
            'message' => 'پست با موفقیت به‌روزرسانی شد.',
        ]);
    }

    /**
     * حذف یک پست
     *
     * @param int $id
     * @return JsonResponse
     */
    public function deletePost(int $id): JsonResponse
    {
        // حذف پست
        $deleted = $this->postService->deletePost($id);

        // اگر پست پیدا نشد، خطا برگردان
        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'پست مورد نظر یافت نشد.',
            ], 404);
        }

        // بازگرداندن پاسخ JSON
        return response()->json([
            'success' => true,
            'message' => 'پست با موفقیت حذف شد.',
        ]);
    }
}
