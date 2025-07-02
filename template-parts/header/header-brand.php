<?php
/**
 * Template part for displaying header's logo
 *
 * @package Dziri
 */

$site_title = $args['site_title'];

?>

<div class="site-branding">
    <?php if ( has_custom_logo() && $site_title ) : ?>
        <div class="site-logo">
            <a href="<?php  esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
                <?php esc_html(the_custom_logo()); ?>
            </a>
        </div>
    <?php else: ?>
        <a href="<?php  esc_url( home_url( '/' ) ); ?>" class="custom-logo-link">
            <p><?php echo esc_html($site_title); ?></p>
        </a>
    <?php endif; ?>
</div>