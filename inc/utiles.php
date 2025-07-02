<?php


/**
 * Create Breacrumb
 */

function dziri_get_breadcrumb($page_title) {

	$display = '';
    $display = '<li><a href="'.home_url().'" rel="nofollow">'.  esc_html__('Home', 'dziri') . '</a></li>';

    if(dziri_is_woocommerce_activated()) {
        $is_woo_page = is_product() || is_cart() || is_checkout();
    } else {
        $is_woo_page = false;
    }

    if (is_single() || (dziri_is_woocommerce_activated() && $is_woo_page)) :

      $is_regular_post = is_single() && (!dziri_is_woocommerce_activated() || (dziri_is_woocommerce_activated() && !is_product()));

      $post_type_title = $is_regular_post ? __('Blog', 'dziri') : __('Shop', 'dziri');
      $post_type = $is_regular_post ? 'post' : 'product';
      $display .= '<li>
						<a href="' . esc_url(get_post_type_archive_link( $post_type )) . '">' .  esc_html($post_type_title, 'dziri') . '</a>
					</li>
					<li>' . esc_html($page_title) . '</li>';
    elseif (is_page() || is_home() || is_category() || is_date() || is_author() || 
            (dziri_is_woocommerce_activated() && is_woocommerce() && !is_product())
            ) :
        $display .= '<li>' . esc_html($page_title) . '</li>';
    elseif (is_search()) :
        $display .=  the_search_query();
    endif;
	
	return $display;
}


/**
 * Edit Default Comment Forms
 */

function dziri_edit_comment_form( $fields ) {

    $coockies_consent = $fields['cookies'];
    $comment_field = $fields['comment'];
    unset( $fields['comment'], $fields['cookies'] );
    $fields['comment'] = $comment_field;
    $fields['coockies'] = $coockies_consent;
    return $fields;
}
	 
add_filter( 'comment_form_fields', 'dziri_edit_comment_form');


/**
 * Remove tags and additional strings on default pages titles
 */

function dziri_custom_titles($title) {
    if(dziri_is_woocommerce_activated()) {
        $is_woo_page = is_shop() || is_product_category() || is_product_tag();
    } else {
        $is_woo_page = false;
    }

    if ($is_woo_page || is_category() || is_tag() || is_date() || is_author()) {
        $title = str_replace(':', '', ltrim($title, strtok($title, ':')));
        $title = str_replace('</span>', '', $title);
        $title = str_replace('<span>', '', $title);
    }
    return $title;
}

add_filter('get_the_archive_title', 'dziri_custom_titles');

// Add Inline Colors From Customizer

function dziri_get_customizer_colors() {
    ob_start();

    $css_selectors = array(
        'banner_title'          => '#swiper-slider h2',
        'homepage_titles'       => '.title h2',
        'blog_titles'           => 'h2.entry-title a',
        'shop_titles'           => '.woocommerce ul.products li.product .woocommerce-loop-product__title',
        'pages_titles'          => '.top-heading h1',
        'other_titles'          => 'h3, h4, h5, h6',
        'body_color'            => 'body:not(#wpadminbar *)',
        'text_color'            => 'p',
        'menu_color'            => 'li.menu-item a',
        'menu_hover_colors'     => 'li.menu-item a:hover, li.menu-item a:focus, li.menu-item a:active, li.menu-item.current-menu-item a',
        'links_color'           => 'a',
        'links_hover_colors'    => 'a:hover, a:focus, a:active, .tab-product .active',
        'icons_color'           => '.material-icons'
    );

    foreach ($css_selectors as $key => $css_selector) {
        $key = get_theme_mod( $key, '' );
        if ( ! empty( $key ) ) {
          ?>
          <?php echo $css_selector; ?> {
            color: <?php echo sanitize_hex_color($key); ?> !important;
          }
          <?php
        }
    }

    $css_colors_var = array(
        'primary_color'         => '--primary-color',
        'secondary_color'       => '--secondary-color',
        'dark_grey'             => '--dark-color',
        'light_grey'            => '--light-color',
    );

    foreach ($css_colors_var as $key => $css_color_var) {
        $key = get_theme_mod( $key, '' );
        if ( ! empty( $key ) ) {
          ?>
          :root {
             <?php echo $css_color_var . ': ' . sanitize_hex_color($key); ?>;
        }
          <?php
        }
    }

    
    $buttons_colors = array(
        'slider_button'         => '#swiper-slider .btn-primary',
        'slider_button_hover'   => '#swiper-slider .btn-primary:hover',
        'shop_button'           => '.woocommerce ul.products li.product .button.btn-primary',
        'shop_button_hover'     => '.woocommerce ul.products li.product .button.btn-primary:hover',
        'product_button'        => '.woocommerce div.product form.cart .button.btn-primary',
        'product_button_hover'  => '.woocommerce div.product form.cart .button.btn-primary:hover',
        'blog_button'           => '.category-blog .btn-primary',
        'blog_button_hover'     => '.category-blog .btn-primary:hover',
        'back_to_top'           => '.back-to-top',
        'back_to_top_hover'     => '.back-to-top:hover',
    );

    foreach ($buttons_colors as $key => $button_color) {
        $key = get_theme_mod( $key, '' );
        if ( !empty( $key ) ) {
          ?>
          <?php echo $button_color; ?> {
            background-color: <?php echo sanitize_hex_color($key); ?> !important;
          }
          <?php
        }
    }

    $buttons_text_colors = array(
        'slider_button_text'        => '#swiper-slider .btn-primary a',
        'slider_button_text_hover'  => '#swiper-slider .btn-primary:hover a',
        'shop_button_text'          => '.woocommerce ul.products li.product .button.btn-primary',
        'shop_button_text_hover'    => '.woocommerce ul.products li.product .button.btn-primary:hover',
        'product_button_text'       => '.woocommerce div.product form.cart .button.btn-primary',
        'product_button_text_hover' => '.woocommerce div.product form.cart .button.btn-primary:hover',
        'blog_button_text'          => '.category-blog .btn-primary',
        'blog_button_text_hover'    => '.category-blog .btn-primary:hover',
        'back_to_top_text'          => '.back-to-top',
        'back_to_top_text_hover'    => '.back-to-top:hover span',
    );

    foreach ($buttons_text_colors as $key => $button_text_color) {
        $key = get_theme_mod( $key, '' );
        if ( !empty( $key ) ) {
          ?>
          <?php echo $button_text_color; ?> {
            color: <?php echo sanitize_hex_color($key); ?> !important;
          }
          <?php
        }
    }

    $css = ob_get_clean();
    return $css;
  }
  