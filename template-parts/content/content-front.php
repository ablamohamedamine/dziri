<?php
/**
 * The template for displaying homepage
 *
 * @package Dziri
 */

 ?>

<div id="page-content" class="page-content">
    <?php
        if(dziri_is_woocommerce_activated()) {
            $saved_home_products = get_theme_mod('home_products', 'new-arrivals,featured-products,onsale-items');
            $saved_home_products_array = !is_array($saved_home_products) ?  explode(',', $saved_home_products) : $saved_home_products;
            if(!empty($saved_home_products_array)) {
        ?>
        <div class="product-section">
            <div class="title">
                <h2><?php echo esc_html__('Our Products', 'dziri') ?></h2>
            </div>
            <div class="product-tabs">
                <ul role="tablist" class="tab-product">
                    <?php 
                    $products_tabs = array(
                        "new-arrivals"      => "New Arrivals",
                        "featured-products" => "Featured Products",
                        "onsale-items"      => "Sale Items",
                    );
                    $first_item = true;
                    foreach($products_tabs as $key => $product_tab) {
                        if(in_array($key, $saved_home_products_array)) {
                            ?>
                            <li>
                                <a href="#<?php echo $key; ?>" class="<?php echo $first_item ? 'active ' . $key : $key; ?>">
                                    <?php echo esc_html($product_tab); ?>
                                </a>
                            </li>
                            <?php
                            $first_item = false;
                        }
                    }
                    ?>
                </ul>

            </div>
            <?php

            $do_not_duplicate = array();
            $products_blocks = array(
                "new-arrivals"      => array(
                    "args" => array(
                        'post_type'             => 'product',
                        'posts_per_page'        => '16',
                        'orderby'               => 'rand',
                        'order'                 => 'DESC',
                    ),
                ),
                "featured-products" => array(
                    "args" => array(
                        'post_type'             => 'product',
                        'posts_per_page'        => '16',
                        'orderby'               => 'rand',
                        'order'                 => 'DESC',
                        'post__in'              => wc_get_featured_product_ids(),
                        'post__not_in'          => $do_not_duplicate
                    ),
                ),
                "onsale-items"      => array(
                    "args" => array(
                        'post_type'             => 'product',
                        'posts_per_page'        => '16',
                        'orderby'               => 'rand',
                        'order'                 => 'DESC',
                        'post__in'              => wc_get_product_ids_on_sale(),
                        'post__not_in'          => $do_not_duplicate
                    ),
                ),
            );
            $first_item = true;
            foreach ($products_blocks as $key => $product_block) {
                if(in_array($key, $saved_home_products_array))  : 
                ?> 
                    <div class="product-block" id="<?php echo $key; ?>" <?php echo $first_item ? 'style="display: block;"' : ''; ?>>
                        <?php
                            $loop = 'loop_' . $key;
                            $loop = new WP_Query( $product_block["args"] );
                            if ( woocommerce_product_loop()) {
                                do_action( 'woocommerce_before_shop_loop' );
                                woocommerce_product_loop_start();
                                if ( $loop->have_posts() ) {
                                    while ( $loop->have_posts() ) : 
                                        $loop->the_post();
                                        do_action( 'woocommerce_shop_loop' );
                                        wc_get_template_part( 'content', 'product' );
                                        $do_not_duplicate[] = $post->ID;
                                    endwhile;
                                    woocommerce_product_loop_end();
                                    do_action( 'woocommerce_after_shop_loop' );
                                    wp_reset_postdata();

                                }
                            }
                        ?>
                    </div>
                    <?php $first_item = false;
                endif;
            }
        }
        ?>

    </div>
    <?php } ?>
    <?php 
        if(get_theme_mod('homepage_banner') != null) { ?>
            <div class="banner-section" style="background-image: linear-gradient(90deg, #ffffff4d, #0000004d 70%), url('<?php echo (get_theme_mod('homepage_banner')); ?>');">
                <div>
                    <h2><?php echo (get_theme_mod('homepage_banner_title')); ?></h2>
                    <p><?php echo (get_theme_mod('homepage_banner_subtitle')); ?></p>
                </div>
                <div></div>
            </div>
    <?php } ?>
    <?php 

        $brand_images = [];
        for ($i=0; $i < 10; $i++) { 
            $brand_images[] = get_theme_mod('brand_iamge_' . strval($i+1));
        }
        $brand_number = count(array_filter($brand_images));
        if ($brand_number != null) { 
    ?>
        <div class="brands">
            <div class="title">
                <h2><?php echo esc_html__('Our Brands', 'dziri') ?></h2>
            </div>
            <div class="swiper" id="swiper-brands">
                <div class="swiper-wrapper">
                <?php
                    for ($i=0; $i < $brand_number; $i++) { 
                        ?>
                        <div class="swiper-slide">
                            <div style="background-image: url('<?php echo esc_url(get_theme_mod('brand_iamge_' . strval($i + 1))); ?>');
                                        filter: grey;
                                        -webkit-filter: grayscale(100%);">
                            </div>
                        </div>
                        <?php
                    }
                ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>

            </div>
        </div>
    <?php } ?>
    <?php
        if(get_theme_mod('homepage_about_description') != null) {
    ?>
        <div class="about-us">
            <div class="title">
                <h2><?php echo esc_html__('Who we are?', 'dziri') ?></h2>
            </div>
            <p><?php echo esc_html(get_theme_mod('homepage_about_description')); ?></p>
        </div>
    <?php } ?>
    <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_content(); 
            }
        }