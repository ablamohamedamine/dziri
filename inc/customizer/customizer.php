<?php

/**
 * Customizer Setup.
 */

function dziri_customizer_settings( $wp_customize ) { 

    // Add Multiple Checkbox

    /**
     * https://justintadlock.com/archives/2015/05/26/multiple-checkbox-customizer-control
     * 
     * By Justin Tadlock
    */ 

    class Dziri_Customize_Control_Checkbox_Multiple extends WP_Customize_Control {

        public $type = 'checkbox-multiple';
        public function render_content() {
            if ( empty( $this->choices ) )
                return; ?>
            <?php if ( !empty( $this->label ) ) : ?>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php endif; ?>
            <?php if ( !empty( $this->description ) ) : ?>
                <span class="description customize-control-description"><?php echo esc_html($this->description); ?></span>
            <?php endif; ?>
            <?php $multi_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>
            <ul>
                <?php foreach ( $this->choices as $value => $label ) : ?>
                    <li>
                        <label>
                            <input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> data-customize-setting-link="<?php echo esc_attr( $value ); ?>" />
                            <?php echo esc_html( $label ); ?>
                        </label>
                    </li>
                <?php endforeach; ?>
            </ul>
            <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
        <?php 
        }
    }

    // Sanitizing Functions

    /**
     * By https://divpusher.com/blog/wordpress-customizer-sanitization-examples/
     * 
     */

    function dziri_sanitize_checkbox_tabs( $values ) {

        $multi_values = !is_array( $values ) ? explode( ',', $values ) : $values;
        return !empty( $multi_values ) ? array_map( 'sanitize_text_field', $multi_values ) : array();
    }

    function dziri_sanitize_radio( $input, $setting ){
        $input = sanitize_key($input);
        $choices = $setting->manager->get_control( $setting->id )->choices;
        return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
    }

    function dziri_sanitize_file( $file, $setting ) {
          
        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png'
        );
        $file_ext = wp_check_filetype( $file, $mimes );
        return ( $file_ext['ext'] ? $file : $setting->default );
    }

    $fonts = array(
        'Jost' => 'Jost',
        'Kaushan Script' => 'Kaushan Script',
        'Emilys Candy' => 'Emilys Candy',
        'Jockey One' => 'Jockey One',
        'Montserrat' => 'Montserrat',
        'Poppins' => 'Poppins',
        'Source Sans Pro' => 'Source Sans Pro',
        'Open Sans' => 'Open Sans',
        'Oswald' => 'Oswald',
        'Playfair Display' => 'Playfair Display',
        'Raleway' => 'Raleway',
        'Droid Sans' => 'Droid Sans',
        'Lato' => 'Lato',
        'Arvo' => 'Arvo',
        'Lora' => 'Lora',
        'Merriweather' => 'Merriweather',
        'Oxygen' => 'Oxygen',
        'PT Serif' => 'PT Serif',
        'PT Sans' => 'PT Sans',
        'PT Sans Narrow' => 'PT Sans Narrow',
        'Cabin' => 'Cabin',
        'Fjalla One' => 'Fjalla One',
        'Francois One' => 'Francois One',
        'Josefin Sans' => 'Josefin Sans',
        'Libre Baskerville' => 'Libre Baskerville',
        'Arimo' => 'Arimo',
        'Ubuntu' => 'Ubuntu',
        'Bitter' => 'Bitter',
        'Droid Serif' => 'Droid Serif',
        'Roboto' => 'Roboto',
        'Open Sans Condensed' => 'Open Sans Condensed',
        'Roboto Condensed' => 'Roboto Condensed',
        'Roboto Slab' => 'Roboto Slab',
        'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
        'Rokkitt' => 'Rokkitt',
    );

    // Panels

    $wp_customize->add_panel( 'dziri_home_panel', array(
        'title'  => __( 'Home', 'dziri' ),
        'priority'   => 10
        ) 
    );

    $wp_customize->add_panel( 'dziri_fonts_panel', array(
        'title'  => __( 'Fonts', 'dziri' ),
        'priority'   => 11
        ) 
    );

    $wp_customize->add_panel( 'dziri_colors_panel', array(
        'title'  => __( 'Colors', 'dziri' ),
        'priority'   => 12
        ) 
    );

    $wp_customize->add_panel( 'dziri_cod_panel', array(
        'title'  => __( 'COD', 'dziri' ),
        'priority'   => 13
        ) 
    );

    $wp_customize->add_panel( 'dziri_footer_panel', array(
        'title'  => __( 'Footer', 'dziri' ),
        'priority'   => 14
        ) 
    );
    
    // Home Slider

    $wp_customize->add_section( 'dziri_home_slider' , array(
        'title'      => __( 'Home Page Slider', 'dziri' ),
        'priority'   => 60,
        'panel'      => 'dziri_home_panel'
        ) 
    );

    for ($i=0; $i < 3; $i++) { 

        $wp_customize->add_setting( 'homepage_slider_image_' . strval($i + 1) , array(
            'default'           => '',
            'sanitize_callback' => 'dziri_sanitize_file'
            ) 
        );
    
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'homepage_slider_image_' . strval($i + 1), 
            array(
                'label'     => sprintf(__('Homepage Slider Image  %s', 'dziri'), strval($i + 1)),
                'section'   => 'dziri_home_slider',
                'settings'  => 'homepage_slider_image_' . strval($i + 1),
                )
            ) 
        );
    
        $wp_customize->add_setting( 'homepage_slider_title_' . strval($i + 1) , array(
            'default'           => '',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
            ) 
        );
    
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_slider_title_' . strval($i + 1), 
            array(
                'label'         => sprintf(__('Homepage Slider Title  %s', 'dziri'), strval($i + 1)),
                'section'       => 'dziri_home_slider',
                'settings'      => 'homepage_slider_title_' . strval($i + 1),
                'type'          => 'text',
                'input_attrs'   => array(
                    'maxlength' => 30
                )
                )
            ) 
        );
    
        $wp_customize->add_setting( 'homepage_slider_subtitle_' . strval($i + 1) , array(
            'default'           => '',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
            ) 
        );
    
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_slider_subtitle_' . strval($i + 1), 
            array(
                'label'     => sprintf(__('Homepage Slider Subtitle  %s', 'dziri'), strval($i + 1)),
                'section'   => 'dziri_home_slider',
                'settings'  => 'homepage_slider_subtitle_' . strval($i + 1),
                'type'      => 'text',
                'input_attrs' => array(
                    'maxlength' => 100
                    )
                )
            ) 
        );
    
        $wp_customize->add_setting( 'homepage_slider_button_text_' . strval($i + 1) , array(
            'default'           => '',
            'sanitize_callback' => 'wp_filter_nohtml_kses'
            ) 
        );
    
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_slider_button_text_' . strval($i + 1), 
            array(
                'label'     => sprintf(__('Homepage Slider Button Text  %s', 'dziri'), strval($i + 1)),
                'section'   => 'dziri_home_slider',
                'settings'  => 'homepage_slider_button_text_' . strval($i + 1),
                'type'      => 'text',
                'input_attrs' => array(
                    'maxlength' => 15
                    )
                )
            ) 
        );
    
        $wp_customize->add_setting( 'homepage_slider_button_url_' . strval($i + 1) , array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw'
            ) 
        );
    
        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_slider_button_url_' . strval($i + 1), 
            array(
                'label'     => sprintf(__('Homepage Slider Button URL  %s', 'dziri'), strval($i + 1)),
                'section'   => 'dziri_home_slider',
                'settings'  => 'homepage_slider_button_url_' . strval($i + 1),
                'type'      => 'url'
                )
            ) 
        );
    }

    $wp_customize->add_setting( 'homepage_banner_subtitle' , array(
        'default'           => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
        ) 
    );

    // Home Products Tabs

    $wp_customize->add_section( 'dziri_home_products' , array(
        'title'      => __( 'Home Page Products Tabs', 'dziri' ),
        'priority'   => 70,
        'panel'      => 'dziri_home_panel'
        ) 
    );
    
    $wp_customize->add_setting( 'home_products', array(
        'default'           => 'new-arrivals,featured-products,onsale-items',
        'transport'         => 'postMessage', 
        'sanitize_callback' => 'dziri_sanitize_checkbox_tabs', 
        ) 
    );

    $wp_customize->add_control( new Dziri_Customize_Control_Checkbox_Multiple( $wp_customize, 'home_products', 
        array(
            'label'             => __( 'Product\'s Tabs', 'dziri' ),
            'section'           => 'dziri_home_products',
            'type'              => 'checkbox-multiple',
            'choices'   => array(
                'new-arrivals'      => 'New Arrivals',
                'featured-products' => 'Featured Products',
                'onsale-items'      => 'On Sale Items',
            )
        ) 
    ) );
    
    
    // Home Banner

    $wp_customize->add_section( 'dziri_home_banner' , array(
        'title'      => __( 'Home Page Banner', 'dziri' ),
        'priority'   => 80,
        'panel'      => 'dziri_home_panel'
        ) 
    );

    $wp_customize->add_setting( 'homepage_banner' , array(
        'default'           => '',
        'sanitize_callback' => 'dziri_sanitize_file'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'homepage_banner', 
        array(
            'label'     => __('Homepage Banner Image', 'dziri'),
            'section'   => 'dziri_home_banner',
            'settings'  => 'homepage_banner',
            )
        ) 
    );

    $wp_customize->add_setting( 'homepage_banner_title' , array(
        'default'           => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_banner_title', 
        array(
            'label'     => __('Homepage Banner Title', 'dziri'),
            'section'   => 'dziri_home_banner',
            'settings'  => 'homepage_banner_title',
            'type'      => 'text',
            'input_attrs' => array(
                'maxlength' => 30
            )
            )
        ) 
    );

    $wp_customize->add_setting( 'homepage_banner_subtitle' , array(
        'default'           => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_banner_subtitle', 
        array(
            'label'     => __('Homepage Banner Subtitle', 'dziri'),
            'section'   => 'dziri_home_banner',
            'settings'  => 'homepage_banner_subtitle',
            'type'      => 'text',
            'input_attrs' => array(
                'maxlength' => 50
            )
            )
        ) 
    );
    
    // Home Brands

    $wp_customize->add_section( 'dziri_home_brands' , array(
        'title'      => __( 'Home Page Brands', 'dziri' ),
        'priority'   => 90,
        'panel'      => 'dziri_home_panel'
        ) 
    );

    for ($i=0; $i < 10; $i++) { 
        $wp_customize->add_setting( 'brand_iamge_' . strval($i + 1) , array(
            'default'           => array(),
            'sanitize_callback' => 'dziri_sanitize_file'
            ) 
        );
    
        $wp_customize->add_control( new WP_Customize_Image_Control ( $wp_customize, 'brand_iamge_' . strval($i + 1), 
            array(
                'label'     => sprintf(__('Brand Image  %s', 'dziri'), strval($i + 1)),
                'section'   => 'dziri_home_brands',
                'settings'  => 'brand_iamge_' . strval($i + 1)
                ) 
            ) 
        );
    }

    $wp_customize->add_section( 'dziri_home_about' , array(
        'title'      => __( 'Home Page About Us', 'dziri' ),
        'priority'   => 90,
        'panel'      => 'dziri_home_panel'
        ) 
    );

    $wp_customize->add_setting( 'homepage_about_description' , array(
        'default'           => '',
        'sanitize_callback' => 'wp_filter_nohtml_kses'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'homepage_about_description', 
        array(
            'label'     => __('Homepage About Us Descripion', 'dziri'),
            'section'   => 'dziri_home_about',
            'settings'  => 'homepage_about_description',
            'type'      => 'textarea'
            )
        ) 
    );

    // Heading Colors

    $wp_customize->add_section( 'heading_color' , array(
        'title'      => __( 'Heading Color', 'dziri' ),
        'priority'   => 80,
        'panel'      => 'dziri_colors_panel'
        ) 
    );

    $custom_heading_colors = array(
        'banner_title'      => 'Banner Title',
        'homepage_titles'   => 'Home Page Titles',
        'blog_titles'       => 'Blog Titles',
        'shop_titles'       => 'Shop Titles',
        'pages_titles'      => 'Pages Heading Title ',
        'other_titles'      => 'h3, h4, h5, h6'
    );

    foreach ($custom_heading_colors as $key => $custom_heading_color) {
        
        $wp_customize->add_setting( $key , array(
            'default'           => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, 
            array(
                'label'     => $custom_heading_color,
                'section'   => 'heading_color',
                'settings'  => $key,
                )
            ) 
        );
    }

    // Main Colors

    $wp_customize->add_section( 'main_colors' , array(
        'title'      => __( 'Main Color', 'dziri' ),
        'priority'   => 60,
        'panel'      => 'dziri_colors_panel'
        ) 
    );

    $custom_main_colors = array(
        'primary_color'         => 'Primary Color',
        'secondary_color'       => 'Secondary Color',
        'dark_grey'             => 'Dark',
        'light_grey'            => 'Light',
    );

    foreach ($custom_main_colors as $key => $custom_main_color) {
        
        $wp_customize->add_setting( $key , array(
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, 
            array(
                'label'     => $custom_main_color,
                'section'   => 'main_colors',
                'settings'  => $key,
                )
            ) 
        );
    }

    // General Colors

    $wp_customize->add_section( 'general_colors' , array(
        'title'      => __( 'General Color', 'dziri' ),
        'priority'   => 70,
        'panel'      => 'dziri_colors_panel'
        ) 
    );

    $custom_general_colors = array(
        'body_color'            => 'Body Color',
        'text_color'            => 'Texts Color',
        'menu_color'            => 'Menu Color',
        'menu_hover_colors'     => 'Menu Hover, Active, Focus Color',
        'links_color'           => 'Links Color',
        'links_hover_colors'    => 'Link Hover, Active, Focus Color',
        'icons_color'           => 'Icons Color'
    );

    foreach ($custom_general_colors as $key => $custom_general_color) {
        
        $wp_customize->add_setting( $key , array(
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, 
            array(
                'label'     => $custom_general_color,
                'section'   => 'general_colors',
                'settings'  => $key,
                )
            ) 
        );
    }

    // Buttons Colors

    $wp_customize->add_section( 'buttons_colors' , array(
        'title'      => __( 'Buttons Colors', 'dziri' ),
        'priority'   => 70,
        'panel'      => 'dziri_colors_panel'
        ) 
    );

    $custom_button_colors = array(
        'slider_button'             => 'Slider Buttons',
        'slider_button_hover'       => 'Slider Buttons Hover',
        'slider_button_text'        => 'Slider Buttons Text',
        'slider_button_text_hover'  => 'Slider Buttons Text Hover',
        'shop_button'               => 'Shop Page Buttons',
        'shop_button_hover'         => 'Shop Page Buttons Hover',
        'shop_button_text'          => 'Shop Page Buttons Text',
        'shop_button_text_hover'    => 'Shop Page Buttons Text Hover',
        'product_button'            => 'Single Product Button',
        'product_button_hover'      => 'Single Product Button Hover',
        'product_button_text'       => 'Single Product Button Text',
        'product_button_text_hover' => 'Single Product Button Text Hover',
        'blog_button'               => 'Blog Buttons',
        'blog_button_hover'         => 'Blog Buttons Hover',
        'blog_button_text'          => 'Blog Buttons Text',
        'blog_button_text_hover'    => 'Blog Buttons Text Hover',
        'back_to_top'               => 'Back to Top Button',
        'back_to_top_hover'         => 'Back to Top Button Hover',
        'back_to_top_text'          => 'Back to Top Button Text',
        'back_to_top_text_hover'    => 'Back to Top Button Text Hover',
    );

    foreach ($custom_button_colors as $key => $custom_button_color) {
        
        $wp_customize->add_setting( $key , array(
            'default'           => '',
            'transport'         => 'refresh',
            'sanitize_callback' => 'sanitize_hex_color',
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key, 
            array(
                'label'     => $custom_button_color,
                'section'   => 'buttons_colors',
                'settings'  => $key,
                )
            ) 
        );
    }

    // Fonts

    $wp_customize->add_section('dziri_google_fonts', array(
        'title'     => __('Google Fonts', 'dziri'),
        'priority'  => 10, 
        'panel'     => 'dziri_fonts_panel'
    ));


    $wp_customize->add_setting('heading_font', array(
        'default'           => 'Jost',
        'sanitize_callback' => 'sanitize_text_field',
    ));

 
    $wp_customize->add_control('heading_font', array(
        'label'       => __('Heading Font', 'dziri'),
        'section'     => 'dziri_google_fonts',
        'settings'    => 'heading_font',
        'type'        => 'select',
        'choices'     => $fonts,
    ));
   
    $wp_customize->add_setting('primary_font', array(
        'default'           => 'Jost',
        'sanitize_callback' => 'sanitize_text_field',
    ));

 
    $wp_customize->add_control('primary_font', array(
        'label'       => __('Primary Font', 'dziri'),
        'section'     => 'dziri_google_fonts',
        'settings'    => 'primary_font',
        'type'        => 'select',
        'choices'     => $fonts,
    ));
 
    // Add To Cart or COD Form

    $wp_customize->add_section( 'dziri_cod_add_to_cart' , array(
        'title'      => __( 'Add To Cart ', 'dziri' ),
        'priority'   => 80,
        'panel'      => 'dziri_cod_panel'
        ) 
    );

    $wp_customize->add_setting( 'cod_add_to_cart' , array(
        'default'           => 'cod',
        'sanitize_callback' => 'dziri_sanitize_radio',
        'transport'         => 'postMessage'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'cod_add_to_cart', 
        array(
            'label'     => __('Enable Add To Cart or COD Form', 'dziri'),
            'section'   => 'dziri_cod_add_to_cart',
            'settings'  => 'cod_add_to_cart',
            'type'      => 'radio',
            'choices'   => array(
                'cod'           => __('COD Form', 'dziri'),
                'add_to_cart'   => __('Add To Cart', 'dziri'),
                ),
            )
        ) 
    );

    // Footer Social
    $wp_customize->add_section( 'dziri_footer_social' , array(
        'title'      => __( 'Footer Social', 'dziri' ),
        'priority'   => 100,
        'panel'      => 'dziri_footer_panel'
        ) 
    );
    

    $socials = [
        'facebook_link'  => __( 'Facebook', 'dziri' ),
        'instagram_link' => __( 'Instagram', 'dziri' ),
        'youtube_link'   => __( 'YouTube', 'dziri' ),
        'twitter_link'   => __( 'Twitter', 'dziri')
    ];

    foreach ($socials as $key => $social) {
        
        $wp_customize->add_setting( $key , array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw'
            ) 
        );

        $wp_customize->add_control( new WP_Customize_Control( $wp_customize, $key, 
            array(
                'label'     => $social,
                'section'   => 'dziri_footer_social',
                'settings'  => $key,
                'type'      => 'url'
                ) 
            ) 
        );
    }
    
    $wp_customize->add_setting( 'whatsapp_link' , array(
        'default'           => 'https://wa.me/',
        'sanitize_callback' => 'esc_url_raw'
        ) 
    );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'whatsapp_link', 
        array(
            'label'     => __( 'WhatsApp', 'dziri' ),
            'section'   => 'dziri_footer_social',
            'settings'  => 'whatsapp_link',
            'type'      => 'url'
            ) 
        ) 
    );
}

add_action( 'customize_register', 'dziri_customizer_settings' );

// Enqueue Scripts For Preview

function dziri_theme_preview_register() {


	$is_production = !defined('WP_DEBUG') || WP_DEBUG === false;
	$min_suffix = $is_production ? '.min' : '';
	$home_products = get_theme_mod('home_products', 'new-arrivals,featured-products,onsale-items');
    echo '<script>var savedHomeProducts = "' . esc_js($home_products) . '";</script>';
    wp_enqueue_script( 'dziri-customize-controls-script', get_template_directory_uri() . '/assets/js/customize-controls' . $min_suffix . '.js', array( 'jquery', 'customize-preview' ), _DZIRI_VERSION, true );
    wp_localize_script('dziri-customize-controls-script', 'dziri_customizer', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}

add_action( 'customize_controls_enqueue_scripts', 'dziri_theme_preview_register' );

function dziri_enqueue_selected_font() {
    $primary_font = esc_html(get_theme_mod('primary_font', 'Jost')); 
    wp_enqueue_style('primary-font', 'https://fonts.googleapis.com/css2?family=' . urlencode($primary_font) . '&display=swap');
}
add_action('wp_enqueue_scripts', 'dziri_enqueue_selected_font');



function dziri_save_cod_add_to_cart() {
    if ( isset( $_POST['cod_add_to_cart'] ) ) {
        $new_value = sanitize_text_field( $_POST['cod_add_to_cart'] );
         
        set_theme_mod( 'cod_add_to_cart', $new_value );
       
    } 
}
add_action( 'wp_ajax_save_cod_add_to_cart', 'dziri_save_cod_add_to_cart' );
add_action( 'wp_ajax_nopriv_save_cod_add_to_cart', 'dziri_save_cod_add_to_cart' );
