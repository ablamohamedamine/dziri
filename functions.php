<?php
/**
 * Dziri functions and definitions
 *
 * @package Dziri
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

 if ( ! defined( '_DZIRI_VERSION' ) ) {
	define( '_DZIRI_VERSION', '1.0.10' );
}

// Check if WooCommerce is active

function dziri_is_woocommerce_activated() {
	return class_exists( 'WooCommerce' );
}


/**
 * Enqueue Scripts and Styles.
 */

require get_template_directory() . '/inc/scripts/enqueue.php';


/**
 * Define Google Fonts.
 */

require get_template_directory() . '/inc/fonts/google-fonts.php';


/*
 * Enable support on posts and pages.
 */

require get_template_directory() . '/inc/setup/support.php';


/**
 * Register menu locations.
 */

 require get_template_directory() . '/inc/setup/menus.php';


/**
 * Register widget area.
 */

 require get_template_directory() . '/inc/widgets/widgets-area.php';


/**
 * Widgets.
 */

 require get_template_directory() . '/inc/widgets/widgets.php';


/**
 * Customizer.
 */

 require get_template_directory() . '/inc/customizer/customizer.php';


/**
 * Utiles
 */

require get_template_directory() . '/inc/utiles.php';

/**
 * WooCommerce
 */

if(dziri_is_woocommerce_activated()) require get_template_directory() . '/inc/woocommerce-custom.php'; 


/**
 * Performance
 */

require get_template_directory() . '/inc/performance.php'; 


/**
 *  Required Plugins
 */

require_once get_template_directory() . '/inc/setup/plugins-activation.php';
