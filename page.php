<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
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
                <!-- عنوان صفحه -->
                <header class="entry-header">
                    <?php
                    the_title('<h1 class="entry-title">', '</h1>');
                    ?>
                </header><!-- .entry-header -->

                <!-- تصویر شاخص -->
                <?php seokar_post_thumbnail(); ?>

                <!-- محتوای صفحه -->
                <div class="entry-content">
                    <?php
                    the_content();

                    // صفحه‌بندی محتوا (اگر صفحه به چند صفحه تقسیم شده باشد)
                    wp_link_pages([
                        'before' => '<div class="page-links">' . esc_html__('صفحات:', 'seokar'),
                        'after'  => '</div>',
                    ]);
                    ?>
                </div><!-- .entry-content -->

                <!-- ویرایش صفحه -->
                <?php if (get_edit_post_link()) : ?>
                    <footer class="entry-footer">
                        <?php
                        edit_post_link(
                            sprintf(
                                wp_kses(
                                    /* translators: %s: Name of current post. Only visible to screen readers */
                                    __('ویرایش <span class="screen-reader-text">%s</span>', 'seokar'),
                                    [
                                        'span' => [
                                            'class' => [],
                                        ],
                                    ]
                                ),
                                wp_kses_post(get_the_title())
                            ),
                            '<span class="edit-link">',
                            '</span>'
                        );
                        ?>
                    </footer><!-- .entry-footer -->
                <?php endif; ?>
            </article><!-- #post-<?php the_ID(); ?> -->

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
