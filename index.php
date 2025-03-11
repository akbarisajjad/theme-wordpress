<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Seokar
 */

get_header(); // هدر قالب را فراخوانی می‌کند
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php bloginfo('description'); ?>">
    <meta name="keywords" content="header, mega menu, advanced search, dark mode">
    <meta name="author" content="<?php bloginfo('name'); ?>">
    <link rel="canonical" href="<?php echo esc_url(home_url('/')); ?>">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <?php wp_head(); // هوک وردپرس برای افزودن اسکریپت‌ها و استایل‌ها ?>
</head>
<body <?php body_class(); ?>>

<!-- Notification Bar -->
<div class="notification-bar">
    Special Offer: Get 20% off on all products!
    <button class="close-notification" aria-label="Close Notification">×</button>
</div>

<header role="banner" aria-label="Site Header">
    <div class="dark-mode-toggle" aria-label="Toggle Dark Mode"></div>

    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo" aria-label="Homepage"><?php bloginfo('name'); ?></a>

    <!-- Advanced Search -->
    <div class="search-container">
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="search" class="search-input" placeholder="<?php esc_attr_e('Search...', 'seokar'); ?>" aria-label="Search" value="<?php echo get_search_query(); ?>" name="s">
            <div class="search-results">
                <ul>
                    <li>Search Result 1</li>
                    <li>Search Result 2</li>
                    <li>Search Result 3</li>
                </ul>
            </div>
        </form>
    </div>

    <!-- Utility Buttons -->
    <div class="utility-buttons">
        <button aria-label="Login">👤</button>
        <button aria-label="Cart">🛒</button>
        <button aria-label="Wishlist">❤️</button>
    </div>

    <button class="menu-toggle" aria-label="Toggle Menu" aria-expanded="false" aria-controls="nav-menu">
        ☰
    </button>

    <!-- Mega Menu -->
    <nav id="nav-menu" role="navigation" aria-label="Primary">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'primary-menu',
            'container'      => false,
        ]);
        ?>
    </nav>
</header>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            // اگر پستی وجود دارد، حلقه وردپرس را شروع کنید
            while (have_posts()) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php
                        // نمایش عنوان پست
                        the_title('<h1 class="entry-title">', '</h1>');
                        ?>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <?php
                        // نمایش محتوای پست
                        the_content();
                        ?>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer">
                        <?php
                        // نمایش اطلاعات فوتر پست (مانند تاریخ، نویسنده، دسته‌بندی‌ها)
                        seokar_entry_footer();
                        ?>
                    </footer><!-- .entry-footer -->
                </article><!-- #post-<?php the_ID(); ?> -->
                <?php
            endwhile;

            // صفحه‌بندی پست‌ها
            the_posts_navigation();

        else :
            // اگر پستی وجود ندارد، پیام مناسب نمایش داده شود
            ?>
            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e('هیچ پستی یافت نشد', 'seokar'); ?></h1>
                </header><!-- .page-header -->

                <div class="page-content">
                    <?php
                    if (is_home() && current_user_can('publish_posts')) :
                        printf(
                            '<p>' . wp_kses(
                                /* translators: 1: Link to WP admin new post page. */
                                __('آماده انتشار اولین پست خود هستید؟ <a href="%1$s">از اینجا شروع کنید</a>.', 'seokar'),
                                [
                                    'a' => [
                                        'href' => [],
                                    ],
                                ]
                            ) . '</p>',
                            esc_url(admin_url('post-new.php'))
                        );
                    elseif (is_search()) :
                        ?>
                        <p><?php esc_html_e('متأسفیم، اما هیچ نتیجه‌ای برای جستجوی شما یافت نشد. لطفاً با کلمات کلیدی دیگر امتحان کنید.', 'seokar'); ?></p>
                        <?php
                        get_search_form();
                    else :
                        ?>
                        <p><?php esc_html_e('به نظر می‌رسد ما نمی‌توانیم آنچه را که به دنبال آن هستید پیدا کنیم. شاید جستجو کمک کند.', 'seokar'); ?></p>
                        <?php
                        get_search_form();
                    endif;
                    ?>
                </div><!-- .page-content -->
            </section><!-- .no-results -->
            <?php
        endif;
        ?>
    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_sidebar(); // سایدبار قالب را فراخوانی می‌کند
get_footer(); // فوتر قالب را فراخوانی می‌کند
?>
