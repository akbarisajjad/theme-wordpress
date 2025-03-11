<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Services\AdminService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    protected $adminService;

    /**
     * Constructor برای تزریق وابستگی‌ها
     *
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * نمایش داشبورد مدیریت
     *
     * @return View
     */
    public function dashboard(): View
    {
        // آمار کلی
        $stats = $this->adminService->getDashboardStats();

        return view('admin.dashboard', [
            'stats' => $stats,
        ]);
    }

    /**
     * نمایش لیست کاربران
     *
     * @return View
     */
    public function users(): View
    {
        // دریافت لیست کاربران با pagination
        $users = $this->adminService->getUsers(10);

        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * نمایش فرم ایجاد کاربر جدید
     *
     * @return View
     */
    public function createUser(): View
    {
        return view('admin.users.create');
    }

    /**
     * ذخیره کاربر جدید
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeUser(Request $request): RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,user',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطاها را برگردان
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ایجاد کاربر جدید
        $this->adminService->createUser($request->all());

        // ریدایرکت به لیست کاربران با پیام موفقیت
        return redirect()->route('admin.users')
            ->with('success', 'کاربر با موفقیت ایجاد شد.');
    }

    /**
     * نمایش فرم ویرایش کاربر
     *
     * @param int $id
     * @return View
     */
    public function editUser(int $id): View
    {
        // دریافت کاربر بر اساس ID
        $user = $this->adminService->getUserById($id);

        // اگر کاربر پیدا نشد، خطای 404 نمایش داده شود
        if (!$user) {
            abort(404, 'کاربر مورد نظر یافت نشد.');
        }

        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * به‌روزرسانی کاربر
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function updateUser(Request $request, int $id): RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|in:admin,editor,user',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطاها را برگردان
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // به‌روزرسانی کاربر
        $this->adminService->updateUser($id, $request->all());

        // ریدایرکت به لیست کاربران با پیام موفقیت
        return redirect()->route('admin.users')
            ->with('success', 'کاربر با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف کاربر
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteUser(int $id): RedirectResponse
    {
        // حذف کاربر
        $this->adminService->deleteUser($id);

        // ریدایرکت به لیست کاربران با پیام موفقیت
        return redirect()->route('admin.users')
            ->with('success', 'کاربر با موفقیت حذف شد.');
    }

    /**
     * نمایش لیست پست‌ها
     *
     * @return View
     */
    public function posts(): View
    {
        // دریافت لیست پست‌ها با pagination
        $posts = $this->adminService->getPosts(10);

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * نمایش فرم ایجاد پست جدید
     *
     * @return View
     */
    public function createPost(): View
    {
        // دریافت دسته‌بندی‌ها
        $categories = $this->adminService->getCategories();

        return view('admin.posts.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * ذخیره پست جدید
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storePost(Request $request): RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطاها را برگردان
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ایجاد پست جدید
        $this->adminService->createPost($request->all());

        // ریدایرکت به لیست پست‌ها با پیام موفقیت
        return redirect()->route('admin.posts')
            ->with('success', 'پست با موفقیت ایجاد شد.');
    }

    /**
     * نمایش فرم ویرایش پست
     *
     * @param int $id
     * @return View
     */
    public function editPost(int $id): View
    {
        // دریافت پست بر اساس ID
        $post = $this->adminService->getPostById($id);

        // اگر پست پیدا نشد، خطای 404 نمایش داده شود
        if (!$post) {
            abort(404, 'پست مورد نظر یافت نشد.');
        }

        // دریافت دسته‌بندی‌ها
        $categories = $this->adminService->getCategories();

        return view('admin.posts.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * به‌روزرسانی پست
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function updatePost(Request $request, int $id): RedirectResponse
    {
        // اعتبارسنجی داده‌های ورودی
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category_id' => 'sometimes|exists:categories,id',
        ]);

        // اگر اعتبارسنجی ناموفق بود، خطاها را برگردان
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // به‌روزرسانی پست
        $this->adminService->updatePost($id, $request->all());

        // ریدایرکت به لیست پست‌ها با پیام موفقیت
        return redirect()->route('admin.posts')
            ->with('success', 'پست با موفقیت به‌روزرسانی شد.');
    }

    /**
     * حذف پست
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function deletePost(int $id): RedirectResponse
    {
        // حذف پست
        $this->adminService->deletePost($id);

        // ریدایرکت به لیست پست‌ها با پیام موفقیت
        return redirect()->route('admin.posts')
            ->with('success', 'پست با موفقیت حذف شد.');
    }
}
