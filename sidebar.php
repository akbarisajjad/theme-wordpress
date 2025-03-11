<?php
/**
 * The sidebar for our theme
 *
 * This is the template that displays the sidebar section.
 *
 * @package Seokar
 */

if (!is_active_sidebar('sidebar-1')) {
    return; // اگر سایدبار فعال نباشد، چیزی نمایش داده نشود
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="سایدبار">
    <div class="sidebar-container">
        <?php dynamic_sidebar('sidebar-1'); // نمایش ویجت‌های سایدبار ?>
    </div>
</aside>
