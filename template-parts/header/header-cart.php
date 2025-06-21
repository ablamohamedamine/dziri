<?php
/**
 * Template part for displaying header's cart menu
 *
 * @package Dziri
 */

?>


<ul id="site-header-cart" class="site-header-cart menu">
    <?php
        $icons = array(
            'search' => array(
                'function'  => '#',
                'title' => 'Search...',
                'icon'  => 'search'
            ),
        );

        if(dziri_is_woocommerce_activated()) {

            $icons['account'] = array(
                'function'  => esc_url(get_permalink(wc_get_page_id( 'myaccount' ))),
                'title' => 'View Your Account',
                'icon'  => 'person'
            );

            if(get_theme_mod('cod_add_to_cart') !== 'cod') {
                $icons = array_slice($icons, 0, 1) + ['cart' => array(
                    'function'  => esc_url(wc_get_cart_url()),
                    'title' => 'View Shopping Cart',
                    'icon'  => 'shopping_cart'
                )] + $icons;
            }
        }

        foreach ($icons as $key => $icon) { ?>
            <li class="header-<?php echo $key; ?>">
                <a class="<?php echo $key; ?>-contents" href="<?php echo $icon['function']; ?>" title="<?php echo $icon['title']; ?>">
                    <span class="material-icons">
                        <?php echo $icon['icon']; ?>
                    </span>
                    <?php 
                        if($key == 'cart') :
                            if(WC()->cart->get_cart_contents_count()) : ?>
                                <span class="cart-items-number"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                            <?php 
                            endif;
                        endif;
                    ?>
                </a>
            </li>
        <?php
        }
    ?>
</ul>