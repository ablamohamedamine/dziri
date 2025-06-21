<?php
/**
 * The main template file
 *
 * @package Dziri
 */


get_header(); ?>
	<section id="primary" class="content-area">
		<main id="main" class="site-main" style="<?php if ( is_active_sidebar( 'page' ) || is_active_sidebar( 'shop' ) ) { echo esc_attr('"width: 75%;"'); } ?>">
			<div id="blog-archive" class="blog-content">
				<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post(); 
						if(is_singular()) {
							get_template_part( 'template-parts/content/content', 'single');
						} else { 
							get_template_part( 'template-parts/content/content'); 
						}
					}
				} else {
					?>
					<div class="search-no-content">
						<?php
							get_template_part( 'template-parts/content/content', 'none' );
						?>
					</div>
					<?php
					} 
				?>
				<nav class="archive-pagination pagination">
					<?php 
						$pagination = get_the_posts_pagination( array(
							'prev_text' => '<span class="material-icons-outlined">chevron_left</span>',
							'next_text' => '<span class="material-icons-outlined">navigate_next</span>',
						) ); 
						echo $pagination;
					?>
				</nav>
			<?php
			get_footer();