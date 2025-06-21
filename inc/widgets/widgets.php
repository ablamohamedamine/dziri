<?php

/**
 * Register Widgets
 */

require get_template_directory() . '/inc/widgets/class-last-posts.php';
require get_template_directory() . '/inc/widgets/class-search.php';


function dziri_register_widgets() {

	register_widget( 'Last_Posts' );
	register_widget( 'Dziri_Search' );

}
add_action( 'widgets_init', 'dziri_register_widgets' );