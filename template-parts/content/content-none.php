<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Dziri
 */

get_header(); 
?>
<div class="content-none">
    <p class="text-none">
        <?php echo esc_html__('No Posts Found Here', 'dziri'); ?>
    </p>
    <?php get_search_form(); ?>
</div>
<?php
get_footer();