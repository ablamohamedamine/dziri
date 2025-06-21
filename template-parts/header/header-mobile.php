<?php
/**
 * Template part for displaying header's mobile menu
 *
 * @package Dziri
 */

?>

<div class="mobile-menu-wrapper">
    <div class="mobile-menu-inner">
        <div class="menu-header-wrapper">
            <h3><?php echo esc_html__('Mobile Menu', 'dziri'); ?></h3>
        </div>
        <nav class="mobile-menu-container">
            <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'header-menu',
                        'menu_class'      => 'menu-wrapper',
                        'container_class' => 'main-mobile-menu-container',
                        'items_wrap'      => '<ul id="main-menu-list" class="%2$s">%3$s</ul>',
                        'fallback_cb'     => false,
                    )
                );
            ?>
        </nav>
    </div>
</div>