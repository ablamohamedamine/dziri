<?php 

/**
 * The template for displaying 404 pages (not found)
 *
 * @package Dziri
 */

get_header(); ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<h2>
				<?php echo sprintf(__('<span>%1$s</span> %2$s', 'dziri'), '404', 'Error'); ?>
			</h2>
			<p>
				<?php echo sprintf( 
					__('Sorry, we can\'t find the page you are looking for. Please go to <a href="%s">Home Page</a>.', 'dziri'),
					esc_url( home_url() ) ); ?>
			</p>
			<p>
				<?php echo sprintf( 
					__('Or you can search here:', 'dziri') ); 
					get_search_form(); ?>
			</p>
<?php get_footer(); 