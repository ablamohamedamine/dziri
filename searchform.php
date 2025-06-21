<?php
/**
 * The template for displaying Seacrh Form.
 *
 * @package Dziri
 */

?><form action="/" method="get" class="searchform">
	<input type="text" name="s" id="search" value="<?php esc_attr(the_search_query()); ?>" placeholder="<?php echo esc_attr__('Search...', 'dziri'); ?>"/>
	<button for="searchsubmit" type="submit" class="searchform-submit">	
		<span class="material-icons-outlined">
			search
		</span>
	</button>
</form>