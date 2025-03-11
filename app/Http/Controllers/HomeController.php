<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
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
     * نمایش صفحه اصلی
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // دریافت پست‌های منتشر شده با pagination
        $posts = $this->postService->getPublishedPosts(10);

        // دریافت دسته‌بندی‌های فعال
        $categories = Category::where('status', 'active')->get();

        // بازگرداندن view با داده‌های لازم
        return view('home.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    /**
     * نمایش یک پست خاص
     *
     * @param string $slug
     * @return View
     */
    public function showPost(string $slug): View
    {
        // دریافت پست بر اساس slug
        $post = $this->postService->getPostBySlug($slug);

        // اگر پست پیدا نشد، خطای 404 نمایش داده شود
        if (!$post) {
            abort(404, 'صفحه مورد نظر یافت نشد.');
        }

        // بازگرداندن view با داده‌های پست
        return view('home.post', [
            'post' => $post,
        ]);
    }

    /**
     * نمایش پست‌های یک دسته‌بندی خاص
     *
     * @param string $categorySlug
     * @return View
     */
    public function showCategory(string $categorySlug): View
    {
        // دریافت دسته‌بندی بر اساس slug
        $category = Category::where('slug', $categorySlug)->first();

        // اگر دسته‌بندی پیدا نشد، خطای 404 نمایش داده شود
        if (!$category) {
            abort(404, 'دسته‌بندی مورد نظر یافت نشد.');
        }

        // دریافت پست‌های مرتبط با دسته‌بندی
        $posts = $this->postService->getPostsByCategory($category->id, 10);

        // بازگرداندن view با داده‌های دسته‌بندی و پست‌ها
        return view('home.category', [
            'category' => $category,
            'posts' => $posts,
        ]);
    }
}
