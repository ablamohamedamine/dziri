<?php
/**
 * The sidebar containing the footer widget area.
 * 
 * @package Dziri
 */

for($i = 0; $i < 5; $i++) : ?>
	<div id="widget-footer-<?php echo $i+1 ?>" class="widget-footer">
		<?php
			if ( is_active_sidebar( 'footer-' . strval( $i+1 ) ) ) : 
				dynamic_sidebar( 'footer-' . strval( $i+1 ) ); 
			endif; 
		?>
	</div>
<?php endfor;