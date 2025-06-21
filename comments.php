<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Dziri
 */


if ( post_password_required() )
    return;
?>
<div id="comments" class="comments-area">
    <?php if ( have_comments() ) : ?>
        <h3 class="theme-heading border-bottom comments-title">
            <?php echo esc_html__('This Post Has ' . get_comments_number() . 'dziri'); ?>
        </h3>
        <ol class="comment-list">
            <?php
                wp_list_comments( array() );
            ?>
        </ol>
        <?php if ( ! comments_open() && get_comments_number() ) : ?>
            <p class="no-comments"><?php esc_html__( 'Comments are closed.', 'dziri' ); ?></p>
        <?php endif; ?>
    <?php endif; ?>
    <?php comment_form(); ?>
</div>
<div class="pagination">
	<?php paginate_comments_links(); ?>
</div>
