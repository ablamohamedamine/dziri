<?php

/**
 * Register widget area.
 */

function dziri_register_sidebars() {
	register_sidebar(
		array(
			'id'            => 'page',
			'name'          => esc_html__( 'Page', 'dziri' ),
			'description'   => esc_html__( 'This is Blog\'s and Page\'s Sidebar ', 'dziri' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar( 
		array(
			'id'            => 'shop',
			'name'          => esc_html__( 'Shop', 'dziri' ),
			'description'   => esc_html__( 'This is Shop\'s Sidebar ', 'dziri' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	for($i = 0; $i < 5; $i++) :
		register_sidebar(
			array(
				'id'            => 'footer-' . strval( $i+1 ),
				'name'          => sprintf(esc_html__( 'Footer %s', 'dziri' ), strval( $i+1 )),
				'description'   => sprintf(esc_html__( 'This is Footer\'s Widget %s', 'dziri' ), strval( $i+1 )),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	endfor;
}

add_action( 'widgets_init', 'dziri_register_sidebars' );