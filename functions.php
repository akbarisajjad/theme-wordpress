<?php

/**
 * تنظیمات اولیه قالب
 */
function theme_setup() {
    // پشتیبانی از title tag
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

    // ثبت منوها
    register_nav_menus([
        'primary' => __('منوی اصلی', 'theme-name'),
        'footer'  => __('منوی فوتر', 'theme-name'),
    ]);

    // افزودن اندازه‌های تصویر سفارشی
    add_image_size('custom-thumbnail', 300, 200, true);
    add_image_size('custom-medium', 600, 400, true);
    add_image_size('custom-large', 1200, 800, true);
}
add_action('after_setup_theme', 'theme_setup');

/**
 * افزودن اسکریپت‌ها و استایل‌ها
 */
function theme_scripts() {
    // افزودن استایل اصلی
    wp_enqueue_style('theme-style', get_stylesheet_uri());

    // افزودن استایل‌های سفارشی
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/assets/css/custom.css', [], null);

    // افزودن اسکریپت‌های سفارشی
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/assets/js/custom.js', ['jquery'], null, true);

    // افزودن اسکریپت‌های وابسته به کامنت‌ها
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'theme_scripts');

/**
 * ثبت سایدبارها
 */
function theme_widgets_init() {
    register_sidebar([
        'name'          => __('سایدبار اصلی', 'theme-name'),
        'id'            => 'sidebar-1',
        'description'   => __('این سایدبار در صفحات اصلی نمایش داده می‌شود.', 'theme-name'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    register_sidebar([
        'name'          => __('سایدبار فوتر', 'theme-name'),
        'id'            => 'footer-sidebar',
        'description'   => __('این سایدبار در فوتر نمایش داده می‌شود.', 'theme-name'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);
}
add_action('widgets_init', 'theme_widgets_init');

/**
 * تغییر طول excerpt
 */
function theme_custom_excerpt_length($length) {
    return 20; // تعداد کلمات
}
add_filter('excerpt_length', 'theme_custom_excerpt_length', 999);

/**
 * تغییر متن بیشتر در excerpt
 */
function theme_custom_excerpt_more($more) {
    return '... <a href="' . get_permalink() . '">' . __('ادامه مطلب', 'theme-name') . '</a>';
}
add_filter('excerpt_more', 'theme_custom_excerpt_more');

/**
 * افزودن قابلیت SVG به آپلود رسانه
 */
function theme_allow_svg_upload($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'theme_allow_svg_upload');

/**
 * افزودن کلاس به آیتم‌های منو
 */
function theme_add_menu_class($classes, $item, $args) {
    if ($args->theme_location == 'primary') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'theme_add_menu_class', 10, 3);

/**
 * افزودن لینک به لوگو سفارشی
 */
function theme_custom_logo_with_link($html) {
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
add_filter('get_custom_logo', 'theme_custom_logo_with_link');
