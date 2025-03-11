<?php
/**
 * The template for displaying single posts
 *
 * This is the template that displays single posts.
 *
 * @package Seokar
 */

get_header(); // هدر قالب را فراخوانی می‌کند
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- عنوان پست -->
                <header class="entry-header">
                    <?php
                    the_title('<h1 class="entry-title">', '</h1>');

                    // اطلاعات پست (نویسنده، تاریخ، دسته‌بندی‌ها)
                    if ('post' === get_post_type()) :
                        ?>
                        <div class="entry-meta">
                            <?php
                            seokar_posted_on(); // تاریخ انتشار
                            seokar_posted_by(); // نویسنده
                            seokar_post_categories(); // دسته‌بندی‌ها
                            ?>
                        </div><!-- .entry-meta -->
                    <?php endif; ?>
                </header><!-- .entry-header -->

                <!-- تصویر شاخص -->
                <?php seokar_post_thumbnail(); ?>

                <!-- محتوای پست -->
                <div class="entry-content">
                    <?php
                    the_content();

                    // صفحه‌بندی محتوا (اگر پست به چند صفحه تقسیم شده باشد)
                    wp_link_pages([
                        'before' => '<div class="page-links">' . esc_html__('صفحات:', 'seokar'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div><!-- .entry-content -->

                <!-- تگ‌ها -->
                <footer class="entry-footer">
                    <?php seokar_entry_footer(); // نمایش تگ‌ها و اطلاعات فوتر پست ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

            <!-- نویسنده -->
            <?php
            if (get_the_author_meta('description')) :
                get_template_part('template-parts/author', 'bio');
            endif;
            ?>

            <!-- نظرات -->
            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        <?php
        endwhile; // پایان حلقه وردپرس
        ?>
    </div><!-- .container -->
</main><!-- #primary -->

<?php
get_sidebar(); // سایدبار قالب را فراخوانی می‌کند
get_footer(); // فوتر قالب را فراخوانی می‌کند
?>
