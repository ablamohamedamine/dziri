<?php
/**
 * The sidebar containing the page widget area.
 *
 * @package Dziri
 */

if ( is_active_sidebar( 'page' ) ) : ?>
	<aside>
		<?php
			dynamic_sidebar( 'page' );
			?>
	</aside> 
	<?php
endif; 

?>