<?php
/**
 * The footer for our theme
 *
 * This is the template that displays the footer section.
 *
 * @package Seokar
 */

?>

<footer role="contentinfo" aria-label="Site Footer">
    <div class="footer-container">
        <!-- Footer Widgets -->
        <div class="footer-widgets">
            <div class="footer-widget">
                <h3 class="widget-title"><?php esc_html_e('درباره ما', 'seokar'); ?></h3>
                <p><?php esc_html_e('ما یک تیم حرفه‌ای هستیم که در زمینه طراحی وب و سئو فعالیت می‌کنیم.', 'seokar'); ?></p>
            </div>

            <div class="footer-widget">
                <h3 class="widget-title"><?php esc_html_e('لینک‌های مفید', 'seokar'); ?></h3>
                <ul>
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('خانه', 'seokar'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/about')); ?>"><?php esc_html_e('درباره ما', 'seokar'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/services')); ?>"><?php esc_html_e('خدمات', 'seokar'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('تماس با ما', 'seokar'); ?></a></li>
                </ul>
            </div>

            <div class="footer-widget">
                <h3 class="widget-title"><?php esc_html_e('تماس با ما', 'seokar'); ?></h3>
                <ul>
                    <li><?php esc_html_e('تلفن: ۰۲۱-۱۲۳۴۵۶۷۸', 'seokar'); ?></li>
                    <li><?php esc_html_e('ایمیل: info@seokar.com', 'seokar'); ?></li>
                    <li><?php esc_html_e('آدرس: تهران، خیابان آزادی، پلاک ۱۲۳', 'seokar'); ?></li>
                </ul>
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="social-media">
            <a href="https://facebook.com" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://instagram.com" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://linkedin.com" aria-label="LinkedIn"><i class="fab fa-linkedin"></i></a>
        </div>

        <!-- Copyright -->
        <div class="copyright">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('تمام حقوق محفوظ است.', 'seokar'); ?></p>
        </div>
    </div>
</footer>

<?php wp_footer(); // هوک وردپرس برای افزودن اسکریپت‌ها و استایل‌ها ?>
</body>
</html>
