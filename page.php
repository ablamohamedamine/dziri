<?php
/**
 * The template for displaying pages
 *
 * @package Dziri
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main">
        <div id="page-content" class="page-content">
            <?php
                if(is_front_page() && !is_home()) {
                    get_template_part( 'template-parts/content/content', 'front');
                }
                else {
                    the_content();
                }

                get_footer();
