<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and the header section.
 *
 * @package Seokar
 */

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
