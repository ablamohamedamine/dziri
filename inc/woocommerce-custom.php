<?php

/**
 * WooCommerce Customizations
 */

 
// Remove Breadcrumbs

function dziri_remove_breadcrumbs() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

add_action( 'init', 'dziri_remove_breadcrumbs' );

// Add Sidebar

function dziri_shop_sidebar() {

    if(!is_product()) {
        get_sidebar('shop-filter');
    }
}

add_action( 'woocommerce_before_main_content', 'dziri_shop_sidebar');

// Update Cart Icon's Number

function dziri_update_cart_count() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}

add_action('wp_ajax_update_cart_count', 'dziri_update_cart_count');
add_action('wp_ajax_nopriv_update_cart_count', 'dziri_update_cart_count');

// COD Options

function dziri_cod_options() {

    global $post;
    $product            = null;
    if($post && dziri_is_woocommerce_activated()) $product  = wc_get_product( $post->ID );
    $cod_add_to_cart    = get_theme_mod('cod_add_to_cart');

    if (!is_front_page() 
        && $product 
        && $product->is_in_stock() 
        && $product->get_price() != '' 
        && $cod_add_to_cart == 'cod') {

        // Remove Meta, Quantity And Add to Cart

        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

        function dziri_remove_all_quantity_fields( $return, $product ) {
            return true;
        }
        
        if($product && $product->get_type() !== 'variable') {
            remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
        }

        add_filter( 'woocommerce_is_sold_individually', 'dziri_remove_all_quantity_fields', 10, 2 );

        // Add Checkout Form To Single Product Page

        function dziri_add_checkout_form_after_single_product() {
            if ( is_product() ) {
                echo '<div class="woocommerce-checkout-form">';
                echo do_shortcode('[woocommerce_checkout]');
                echo '</div>';
            }
        }

        add_action( 'woocommerce_share', 'dziri_add_checkout_form_after_single_product' );

        add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
        add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' ); 

        // Reorder Checkout Fields

        function dziri_reorder_checkout_fields( $fields ) {  

            $fields['phone']['priority']        = 20;
            $fields['country']['priority']      = 110;
            $fields['state']['priority']        = 120;
            $fields['city']['priority']         = 130;
            
            return $fields;
        }
        
        add_filter( 'woocommerce_default_address_fields', 'dziri_reorder_checkout_fields' );

        // Destroy Products Cookies IDs

        function dziri_destroy_product_ids_cookies($product_id, $second_condition = false, $cookie_name) {

            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $cookie_check = array_key_exists($cookie_name, $_COOKIE) ? $_COOKIE[$cookie_name] : null;
                    $condition =  !$second_condition ? str_contains($cookie, 'product_id_') : str_contains($cookie, 'product_id_') && $cookie !== $cookie_check;
                    if($condition) {
                        $parts = explode('=', $cookie);
                        $name = trim($parts[0]);
                        setcookie($name, '', time()-1000);
                        setcookie($name, '', time()-1000, '/');
                    }
                }
            }
        }

        // Add To Cart On 1st Visit Simple Product

        function dziri_add_to_cart_on_first_visit(){
            
            if( is_product() ) { 
                WC()->cart->empty_cart();
                if(wc_get_product()->get_type() != "variable") {

                    $product_id = wc_get_product()->get_id();
                    setcookie('product_id_' . $product_id, $product_id, time() + (86400 * 30), "/");
                    WC()->cart->add_to_cart( $product_id );
                    dziri_destroy_product_ids_cookies($product_id, true, 'product_id_' . $product_id);
                }
            }
        }

        add_action( 'template_redirect', 'dziri_add_to_cart_on_first_visit');

        // Destroy products Cookies IDs After Order

        function dziri_remove_cookies_after_order($order_id) {

            $order = new WC_Order( $order_id );

            dziri_destroy_product_ids_cookies(null, false, '');
        }

        add_action( 'woocommerce_thankyou', 'dziri_remove_cookies_after_order' );

        function dziri_remove_subtotal_from_orders_total_lines( $totals ) {
            unset($totals['cart_subtotal']  );
            return $totals;
        }

        add_filter( 'woocommerce_get_order_item_totals', 'dziri_remove_subtotal_from_orders_total_lines', 100, 1 );

        // Update Checkout Form On Changing Shipping

        function dziri_trigger_shipping_recalculate() {
            if ( is_product() ) {
            ?>
            <script type="text/javascript">
                jQuery( function( $ ) {
                    $('select[name="shipping_country"], input[name="shipping_postcode"], select[name="shipping_state"], select[name="billing_country"], input[name="billing_postcode"], select[name="billing_state"]').on('change', function() {
                        $('body').trigger('update_checkout');
                    });
                });
            </script>
            <?php
            }
        }

        add_action( 'wp_footer', 'dziri_trigger_shipping_recalculate' );

        // Disable Checkout Terms and Conditions for COD.

        function dziri_disable_checkout_terms_and_conditions(){

            $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
            if ( count($available_gateways) == 1 && $available_gateways['cod'] !== null ) {
                remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
                remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );
            }
        }

        add_action('woocommerce_checkout_init', 'dziri_disable_checkout_terms_and_conditions', 10 );

        // Redirect Default Add To Cart To Single Product Page

        function replacing_add_to_cart_button( $button, $product ) {
            $button_text = __("View Product", "dziri");
            $button = '<a class="button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';
            return $button;
        }

        add_filter( 'woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2 );
    }
}

add_action( 'wp', 'dziri_cod_options', 20 );


// After Theme Setup For WooCommerce COD

function dziri_after_setup_theme_woocommerce() {

    $cod_add_to_cart    = get_theme_mod('cod_add_to_cart');

    // Add To Cart On Choosing Attributs On Variable Products

    function dziri_add_to_cart_on_variable() {
    
        if (isset($_POST['variation_id'])) {

            $variation_id = intval($_POST['variation_id']);
            
            setcookie('product_id_' . $variation_id, $variation_id, time() + (86400 * 30), "/");
            WC()->cart->empty_cart();
            WC()->cart->add_to_cart( $variation_id );
            wp_send_json_success($variation_id);
        } else {
            wp_send_json_error('No variation ID received.');
        }
    }

    add_action('wp_ajax_add_to_cart_on_variable', 'dziri_add_to_cart_on_variable');
    add_action('wp_ajax_nopriv_add_to_cart_on_variable', 'dziri_add_to_cart_on_variable');

    // Update Checkout Quantity on Checkout Form

    function dziri_update_checkout_quantity() {
        if (!isset($_POST['cart_key']) ||!isset($_POST['quantity'])) {
            wp_send_json_error('Invalid request');
        }
        $cart_key = sanitize_text_field($_POST['cart_key']);
        $new_quantity = intval($_POST['quantity']);

        WC()->cart->set_quantity($cart_key, $new_quantity);
        WC()->cart->calculate_totals();

        $updated_cart = WC()->cart->get_cart();
        $cart_totals = WC()->cart->get_totals();
    
        wp_send_json_success(array(
            'cart' => $updated_cart,
            'totals' => $cart_totals,
        ));
    }

    add_action('wp_ajax_update_checkout_quantity', 'dziri_update_checkout_quantity');
    add_action('wp_ajax_nopriv_update_checkout_quantity', 'dziri_update_checkout_quantity');

    
    function dziri_custom_checkout_cart_quantity($quantity_html, $cart_item, $cart_item_key) {

        // $product_id = $cart_item['product_id'];
        $current_quantity = $cart_item['quantity'];

        $quantity_html = '<div style="position: relative">
                            <span class="material-icons" data-name="remove">remove</span>
                                <input type="number" class="checkout-quantity" data-cart-key="' . esc_attr($cart_item_key) . '" value="' . esc_attr($current_quantity) . '" min="1" style="width: 100px; text-align: center;" />
                            <span class="material-icons" data-name="add">add</span>
                        </div>';
        return $quantity_html;
    }

    add_filter('woocommerce_checkout_cart_item_quantity', 'dziri_custom_checkout_cart_quantity', 10, 3);

    // Redirect From Cart & Checkout Pages to Prodcut Page

    if ($cod_add_to_cart == 'cod') {

        function dziri_redirect_cart_and_checkout_to_product_page() {

            if ( is_cart() || (!is_order_received_page() && is_checkout()) ) {
                $prev_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
                wp_safe_redirect( $prev_url);
                exit;
            }
        }

        add_action( 'template_redirect', 'dziri_redirect_cart_and_checkout_to_product_page' );

        // Add Full Name Field

        function dziri_fullname_field( $fields ) {
                    
            $fields['billing']['billing_fullname'] = array(
                'label'     => __('Full Name', 'dziri'),
                'priority'  => 10,
                'required'  => true
            );
            
            $fields['shipping']['shipping_fullname'] = array(
                'label'     => __('Full Name', 'dziri'),
                'priority'  => 10,
                'required'  => true
            );     
            
            return $fields;
        }

        add_filter( 'woocommerce_checkout_fields', 'dziri_fullname_field' );

        // Add Billing Full Name to Address Fields
            
        function dziri_default_billing_address_fields( $fields, $order ) {
            $fields['billing_full_name'] = get_post_meta( $order->get_id(), '_billing_fullname', true );
            return $fields;
        }
        
        add_filter( 'woocommerce_order_formatted_billing_address' , 'dziri_default_billing_address_fields', 10, 2 );

        // Add Shipping Full Name to Address Fields
            
        function dziri_default_shipping_address_fields( $fields, $order ) {
            $fields['shipping_fullname'] = get_post_meta( $order->get_id(), 'shipping_fullname', true );
            return $fields;
        }

        add_filter( 'woocommerce_order_formatted_shipping_address' , 'dziri_default_shipping_address_fields', 10, 2 );

        // Create 'replacements' for new Address Fields
            
        function dziri_add_new_replacement_fields( $replacements, $address ) {
            $replacements['{billing_full_name}'] = isset($address['billing_full_name']) ? $address['billing_full_name'] : '';
            $replacements['{shipping_fullname}'] = isset($address['shipping_fullname']) ? $address['shipping_fullname'] : '';
            return $replacements;
        }

        add_filter( 'woocommerce_formatted_address_replacements', 'dziri_add_new_replacement_fields', 10, 2 );

        // Save custom checkout field data to the order

        function dziri_fullname_update_meta( $order ){
            if( isset($_POST['billing_fullname']) && ! empty($_POST['billing_fullname']) )
                $order->update_meta_data( 'billing_fullname', sanitize_text_field( $_POST['billing_fullname'] ) );
        }

        add_action( 'woocommerce_checkout_create_order', 'dziri_fullname_update_meta', 10, 2 );


        function dziri_fullname_display_admin_order_meta( $order ){
            echo '<strong>' . esc_html__( 'Full Name: ', 'dziri' ) . '</strong>'  . esc_html( $order->get_meta( 'billing_fullname', true ) ) . '';
        }

        add_action( 'woocommerce_admin_order_data_after_billing_address', 'dziri_fullname_display_admin_order_meta', 10, 1 );

        // Remove Some Fields

        function dziri_remove_checkout_fields( $fields ) {

            // Remove Country Field if it Sells for One Country
            $countries = new WC_Countries();
            if(count($countries->get_allowed_countries()) === 1) {
                unset( $fields['billing']['billing_country'] );
                unset( $fields['shipping']['shipping_country'] );
            };

            // Remove Billing fields
            unset( $fields['billing']['billing_company'] );
            unset( $fields['billing']['billing_email'] );
            unset( $fields['billing']['billing_first_name'] );
            unset( $fields['billing']['billing_last_name'] );
            unset( $fields['billing']['billing_address_1'] );
            unset( $fields['billing']['billing_address_2'] );
            unset( $fields['billing']['billing_postcode'] );

            // Remove Shipping fields
            unset( $fields['shipping']['shipping_company'] );
            unset( $fields['shipping']['shipping_email'] );
            unset( $fields['shipping']['shipping_first_name'] );
            unset( $fields['shipping']['shipping_last_name'] );
            unset( $fields['shipping']['shipping_address_1'] );
            unset( $fields['shipping']['shipping_address_2'] );
            unset( $fields['shipping']['shipping_postcode'] );
            
            return $fields;
        }

        add_filter( 'woocommerce_checkout_fields', 'dziri_remove_checkout_fields' );

        add_filter( 'woocommerce_enable_order_notes_field', '__return_false' );
        add_filter( 'woocommerce_cart_needs_shipping_address', '__return_false');
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    }
}

add_action('after_setup_theme', 'dziri_after_setup_theme_woocommerce', 10);

