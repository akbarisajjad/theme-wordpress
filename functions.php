<?php
/**
 * Theme Name: Seokar
 * Theme URI: https://seokar.click
 * Author: Sajjad Akbari
 * Author URI: https://sajjadakbari.ir
 * Description: قالب حرفه‌ای سئوکار برای وردپرس، طراحی شده برای بهینه‌سازی سئو و سرعت سایت.
 * Version: 1.0.0
 * License: GNU General Public License v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: seokar
 * Tags: seo-friendly, custom-background, custom-logo, custom-menu, featured-images, threaded-comments, translation-ready
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// تعریف ثابت‌های اصلی
define('SEOKAR_THEME_VERSION', '1.0.0');
define('SEOKAR_THEME_PATH', get_stylesheet_directory());
define('SEOKAR_THEME_URI', get_stylesheet_directory_uri());

// بارگذاری فایل‌های اصلی
if (file_exists(SEOKAR_THEME_PATH . '/app/Bootstrap.php')) {
    require_once SEOKAR_THEME_PATH . '/app/Bootstrap.php';
}

// راه‌اندازی قالب
function seokar_setup() {
    // پشتیبانی از ترجمه
    load_theme_textdomain('seokar', SEOKAR_THEME_PATH . '/languages');

    // پشتیبانی از تگ عنوان
    add_theme_support('title-tag');

    // پشتیبانی از تصاویر شاخص
    add_theme_support('post-thumbnails');

    // پشتیبانی از لوگو سفارشی
    add_theme_support('custom-logo', [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // پشتیبانی از HTML5
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ]);

    // پشتیبانی از خوراک RSS
    add_theme_support('automatic-feed-links');

    // پشتیبانی از Post Formats
    add_theme_support('post-formats', ['aside', 'gallery', 'quote', 'image', 'video']);

    // ثبت منوها
    register_nav_menus([
        'primary' => __('منوی اصلی', 'seokar'),
        'footer'  => __('منوی فوتر', 'seokar'),
    ]);

    // افزودن اندازه‌های تصویر سفارشی
    add_image_size('custom-thumbnail', 300, 200, true);
    add_image_size('custom-medium', 600, 400, true);
    add_image_size('custom-large', 1200, 800, true);

    // پشتیبانی از WooCommerce (اگر نصب شده باشد)
    if (class_exists('WooCommerce')) {
        add_theme_support('woocommerce');
    }

    // پشتیبانی از Gutenberg
    add_theme_support('align-wide');
    add_theme_support('responsive-embeds');
    add_theme_support('editor-styles');
    add_editor_style('public/assets/css/editor-style.css');
}
add_action('after_setup_theme', 'seokar_setup');

// بارگذاری فایل‌های CSS و JS (فقط در بخش فرانت‌اند)
if (!is_admin()) {
    function seokar_scripts() {
        // افزودن استایل اصلی با نسخه‌دهی بر اساس نسخه قالب
        wp_enqueue_style('seokar-style', get_stylesheet_uri(), [], SEOKAR_THEME_VERSION);

        // افزودن استایل‌های سفارشی
        wp_enqueue_style('seokar-custom-style', SEOKAR_THEME_URI . '/assets/css/custom.css', [], SEOKAR_THEME_VERSION, 'all');

        // افزودن اسکریپت‌های سفارشی
        wp_enqueue_script('seokar-custom-script', SEOKAR_THEME_URI . '/assets/js/custom.js', ['jquery'], SEOKAR_THEME_VERSION, true);

        // افزودن اسکریپت‌های وابسته به کامنت‌ها
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }

        // بارگذاری فونت‌ها با display=swap
        wp_enqueue_style('seokar-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Vazir:wght@400;700&display=swap', [], SEOKAR_THEME_VERSION);
    }
    add_action('wp_enqueue_scripts', 'seokar_scripts');
}

// ثبت سایدبارها
function seokar_widgets_init() {
    register_sidebar([
        'name'          => __('سایدبار اصلی', 'seokar'),
        'id'            => 'sidebar-1',
        'description'   => __('این سایدبار در صفحات اصلی نمایش داده می‌شود.', 'seokar'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    register_sidebar([
        'name'          => __('سایدبار فوتر', 'seokar'),
        'id'            => 'footer-sidebar',
        'description'   => __('این سایدبار در فوتر نمایش داده می‌شود.', 'seokar'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'seokar_widgets_init');

// تغییر طول excerpt
function seokar_custom_excerpt_length($length) {
    return 20; // تعداد کلمات
}
add_filter('excerpt_length', 'seokar_custom_excerpt_length', 999);

// تغییر متن بیشتر در excerpt
function seokar_custom_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '">' . __('ادامه مطلب', 'seokar') . '</a>';
}
add_filter('excerpt_more', 'seokar_custom_excerpt_more');

// افزودن قابلیت SVG به آپلود رسانه با اعتبارسنجی
function seokar_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'seokar_allow_svg_upload');

function seokar_check_svg($file) {
    if ('image/svg+xml' === $file['type']) {
        $file_contents = file_get_contents($file['tmp_name']);
        if (strpos($file_contents, '<script') !== false) {
            $file['error'] = __('فایل SVG حاوی اسکریپت است و مجاز نمی‌باشد.', 'seokar');
        }
    }
    return $file;
}
add_filter('wp_check_filetype_and_ext', 'seokar_check_svg', 10, 4);

// افزودن کلاس به آیتم‌های منو
function seokar_add_menu_class($classes, $item, $args) {
    if ($args->theme_location == 'primary') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'seokar_add_menu_class', 10, 3);

// افزودن لینک به لوگو سفارشی
function seokar_custom_logo_with_link($html) {
    $custom_logo_id = get_theme_mod('custom_logo');
    $html = sprintf(
        '<a href="%1$s" class="custom-logo-link" rel="home">%2$s</a>',
        esc_url(home_url('/')),
        wp_get_attachment_image($custom_logo_id, 'full', false, [
            'class' => 'custom-logo',
        ])
    );
    return $html;
}
add_filter('get_custom_logo', 'seokar_custom_logo_with_link');

// تنظیمات سفارشی‌سازی (Customizer)
function seokar_customize_register($wp_customize) {
    // افزودن بخش جدید در Customizer
    $wp_customize->add_section('seokar_settings', [
        'title'    => __('تنظیمات Seokar', 'seokar'),
        'priority' => 30,
    ]);

    // افزودن تنظیمات رنگ اصلی
    $wp_customize->add_setting('primary_color', [
        'default'           => '#0073e6',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', [
        'label'    => __('رنگ اصلی', 'seokar'),
        'section'  => 'seokar_settings',
        'settings' => 'primary_color',
    ]));
}
add_action('customize_register', 'seokar_customize_register');

// فعال‌سازی قابلیت‌های توسعه‌دهنده (فقط در حالت توسعه)
if (WP_DEBUG) {
    // فعال‌سازی نمایش خطاها
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // بارگذاری فایل‌های توسعه‌دهنده (در صورت وجود)
    if (file_exists(SEOKAR_THEME_PATH . '/dev/debug.php')) {
        require_once SEOKAR_THEME_PATH . '/dev/debug.php';
    }
}
