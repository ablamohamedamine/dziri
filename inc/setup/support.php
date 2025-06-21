<?php

/**
 * Enable support on posts and pages.
 */

if ( function_exists( 'add_theme_support' ) ) {
	
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'flex-height'          => true,
		'flex-width'           => true,
		'header-text'          => array( 'site-title', 'site-description' ),
		'unlink-homepage-logo' => true,
		) 
	);
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}

function dziri_load_textdomain() {
    load_theme_textdomain('dziri', get_template_directory() . '/languages');
}

add_action('after_setup_theme', 'dziri_load_textdomain');


wp_link_pages();