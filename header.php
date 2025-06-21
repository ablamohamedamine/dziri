<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class('woocommerce'); ?>>

<?php wp_body_open(); ?>
<a href="#content" class="skip-to-content"><?php esc_html_e('Skip to Content', 'dziri') ?></a>

<?php

$wrapper_classes  = 'site-header';
$wrapper_classes .= has_custom_logo() ? ' has-logo' : '';
$wrapper_classes .= has_nav_menu( 'header-menu' ) ? ' has-menu' : '';
$site_title = get_bloginfo('name');
$posts_page_condition = is_home() ? get_option( 'page_for_posts' ) : '';
$page_title = is_search() ? __('Search Results for : ', 'dziri' ) . get_search_query() : ( is_archive() ? get_the_archive_title() : get_the_title($posts_page_condition));
$url = wp_get_attachment_url( get_post_thumbnail_id($posts_page_condition));

$top_heading = '
    <div class="top-heading" style="background: linear-gradient(#0000004d, #0000004d), url(\'' . esc_url($url) . '\');">
        <h1>' . esc_html($page_title) . '</h1>
    </div>';

?>

<div id="page" class="site">
    <?php get_template_part( 'template-parts/header/header', 'mobile' ); ?>
    <header id="masthead" class="<?php echo esc_attr( $wrapper_classes ); ?>">
        <div class="global-header-container">
            <div class="header-container sticky">
                <?php get_template_part( 'template-parts/header/header', 'brand', array( 'site_title' => $site_title) ); 
                ?>
                <?php if ( has_nav_menu( 'header-menu' ) ) : ?>
                    <nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Header Menu', 'dziri' ); ?>">
                        <div class="main-menu-container">
                            <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location'  => 'header-menu',
                                        'menu_class'      => 'menu-wrapper',
                                        'container_class' => 'main-menu-container',
                                        'items_wrap'      => '<ul id="main-menu-list" class="%2$s">%3$s</ul>',
                                        'fallback_cb'     => false,
                                    )
                                );
                            ?>
                        </div>
                    </nav>
                <?php else : ?>
                    <nav id="site-navigation" class="main-navigation no-menu" aria-label="<?php esc_attr_e( 'Header Menu', 'dziri' ); ?>">
                        <p><?php esc_html_e( 'No menu assigned. Please assign a menu from the WordPress admin panel.', 'dziri' ); ?></p>
                    </nav>
                <?php endif; ?>
                <?php get_template_part( 'template-parts/header/header', 'cart' ); ?>
                <?php get_template_part( 'template-parts/header/header', 'search' ); ?>
            </div>
            <div class="heading-container">
                <div>
                    <div>
                        <div class="menu-button-container">
                            <button id="main-mobile-menu" class="menu-toggle button" aria-expanded="false">
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <?php 

                    if(dziri_is_woocommerce_activated()) {
                        $is_not_woo_page = !is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page();
                    } else {
                        $is_not_woo_page = false;
                    }
                    if((!is_front_page() && !is_404() && dziri_is_woocommerce_activated() && $is_not_woo_page) || is_home() || is_search()) : 
                        echo $top_heading;
                    endif; 
                ?>
            </div>
        </div>
    </header>
    <div id="content" class="site-content">
        <?php 
            if (is_front_page() && !is_home()) :
                $slider_images = [];
                for ($i=0; $i < 3; $i++) { 
                    $slider_images[] = get_theme_mod('homepage_slider_image_' . strval($i+1));
                    $slider_number = count(array_filter($slider_images));
                }
                if($slider_number != 0) { ?>

                    <div class="swiper" id="swiper-slider">
                        <div class="swiper-wrapper">
                            <?php 
                                for ($i=0; $i < $slider_number; $i++) { ?>
                                <div class="swiper-slide" style="background-image: url('<?php echo esc_url(get_theme_mod('homepage_slider_image_' . strval($i + 1))); ?>');">
                                    <div>
                                        <h2><?php echo esc_html(get_theme_mod('homepage_slider_title_' . strval($i + 1))); ?></h2>
                                        <p><?php echo esc_html(get_theme_mod('homepage_slider_subtitle_' . strval($i + 1))); ?></p>
                                        <?php 
                                            if(get_theme_mod('homepage_slider_button_text_' . strval($i + 1)) != null) { ?>
                                                <button class="btn-primary">
                                                    <a href="<?php echo esc_url(get_theme_mod('homepage_slider_button_url_' . strval($i + 1))); ?>">
                                                        <?php echo esc_html(get_theme_mod('homepage_slider_button_text_' . strval($i + 1))); ?>
                                                    </a>
                                                </button>
                                            <?php 
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php 
                                }
                            ?>
                        </div>
                        <div class="swiper-pagination"></div>

                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>

                        <div class="swiper-scrollbar"></div>
                    </div>
            <?php
                }
            ?>
        <?php
            elseif (!is_404() && !is_search() && !is_front_page()) : 
        ?>
        <div class="breadcrumbs-wrapper">
            <div class="container">
                <ul class="breadcrumbs" id="breadcrumbs"><?php echo dziri_get_breadcrumb($page_title); ?></ul>
            </div>
        </div>
        <?php
            endif; 
        ?>