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
        <div class="site-logo"><?php esc_html(the_custom_logo()); ?></div>
    <?php else: ?>
        <p><?php echo esc_html($site_title); ?></p>
    <?php endif; ?>
</div>