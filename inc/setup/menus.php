<?php

/**
 * Register menu locations.
 */

function dziri_register_nav_menus() {
	register_nav_menus(
	  array(
		'header-menu' => __( 'Header Menu', 'dziri' )
	   )
	 );
   }
add_action( 'init', 'dziri_register_nav_menus' );