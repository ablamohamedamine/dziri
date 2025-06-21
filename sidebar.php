<?php
/**
 * The sidebar containing the main widget area.
 * 
 * @package Dziri
 * 
 */

 if ( is_active_sidebar( 'main' ) ) : ?>
	<aside>
		<?php
			dynamic_sidebar( 'main' );
			?>
	</aside> 
	<?php
endif; 

?>