<?php

/**
 * Enqueue Scripts & Styles
 */



function dziri_scripts() {

	$is_production = !defined('WP_DEBUG') || WP_DEBUG === false;
	$min_suffix = $is_production ? '.min' : '';

	wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined' );
	wp_enqueue_style( 'swiper', get_template_directory_uri() . '/assets/css/swiper-bundle' . $min_suffix . '.css' );
	wp_enqueue_style( 'dziri-normalize', get_template_directory_uri() . '/assets/css/normalize' . $min_suffix . '.css' );
	wp_enqueue_style( 'dziri-style', get_template_directory_uri() . '/assets/css/style' . $min_suffix . '.css', _DZIRI_VERSION );
	wp_enqueue_style( 'dziri-main', get_template_directory_uri() . '/assets/css/main' . $min_suffix . '.css', _DZIRI_VERSION );
    // wp_style_add_data( 'dziri-main', 'rtl', true );
	$custom_css = dziri_get_customizer_colors();
	wp_add_inline_style( 'dziri-main', $custom_css );
	
	$enqueue_files = array('jquery');
	if(dziri_is_woocommerce_activated()) {
		array_push($enqueue_files, 'woocommerce');
	}
	wp_enqueue_script( 'swiper', get_template_directory_uri() . '/assets/js/swiper-bundle' . $min_suffix . '.js', array( 'jquery' ) );
	wp_register_script( 'dziri-script', get_template_directory_uri() . '/assets/js/scripts' . $min_suffix . '.js', $enqueue_files, _DZIRI_VERSION, true );
    wp_localize_script('dziri-script', 'dziri_ajax', array('ajax_url' => admin_url('admin-ajax.php')));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	if ( dziri_is_woocommerce_activated() && (is_checkout() || is_cart() || is_product()) ) {
		wp_enqueue_script('wc-checkout', WC()->plugin_url() . '/assets/js/frontend/checkout.min.js', array('jquery'), null, true);
	}

	$translation_strings = array(
		"viewProduct" => __("View Product", "dziri")
	);

	wp_localize_script( 'dziri-script', 'translationStrings', $translation_strings );
	wp_enqueue_script( 'dziri-script' );
}

add_action( 'wp_enqueue_scripts', 'dziri_scripts' );