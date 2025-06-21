<?php
/**
 * The sidebar containing the page  widget area.
 * 
 * @package Dziri
 */


if ( is_active_sidebar( 'shop' ) ) : ?>
	<div id="widget-shop" class="widget-shop">
		<?php
			dynamic_sidebar( 'shop' ); 
		?>
	</div>
<?php 
endif; 
?>
