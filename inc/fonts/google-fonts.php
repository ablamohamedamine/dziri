<?php

/**
 * Google Fonts.
 */

function dziri_custom_styles($custom) {

    $dziri_heading_font = esc_html(get_theme_mod('heading_font'));
	$dziri_primary_font = esc_html(get_theme_mod('primary_font'));
	if ( $dziri_heading_font ) {
		$font = explode(":", $dziri_heading_font);
		$custom .= "h1, h2, h3, h4, h5, h6 { font-family: {$font[0]}; }"."\n";
	}
	if ( $dziri_primary_font ) {
		$font = explode(":", $dziri_primary_font);
		$custom .= "*:not(h1, h2, h3, h4, h5, h6) { font-family: {$font[0]}; }"."\n";
	}

    wp_add_inline_style( 'dziri-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'dziri_custom_styles' );

