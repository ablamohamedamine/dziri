<?php
/**
 * Template part for displaying single post
 *
 * @package Dziri
 */

?>

<article id="post-<?php esc_attr(the_ID()); ?>" class="<?php esc_attr(post_class()); ?>">
    <ul class="entry-meta">
        <li class="author">
            <span><?php echo esc_html__('Posted by', 'dziri'); ?></span>
            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( get_the_author() ); ?>"><?php esc_html(the_author()); ?></a>
        </li>
        <li class="entry-category">
            <span><?php echo esc_html__('Categories', 'dziri'); ?></span>
            <?php
                $categories = get_the_category();
                $output = '';
                foreach($categories as $category) :
                    if(!empty($output)) :
                        $output .= ', ';
                    endif;
                    $output .= '<a href="' . esc_url(get_category_link( $category->term_id )) . '">' .  esc_html($category->name) . ' </a>';
                endforeach;
                echo $output;
            ?>
        </li>
        <li class="post-tag">
            <?php
                $tags = get_the_tags();
                if($tags) :
            ?>
            <span><?php echo esc_html__('Tags', 'dziri'); ?></span> 
            <?php
                $output = '';
                foreach($tags as $tag) :
                    if(!empty($output)) :
                        $output .= ', ';
                    endif;
                    $output .= '<a href="' . esc_url(get_tag_link( $tag->term_id )) . '">' . esc_html($tag->name) . ' </a>';
                endforeach;
                echo $output;
                endif;
            ?>
        </li>
        <li class="entry-date">
            <span><?php echo esc_html__('Date', 'dziri'); ?></span>
            <a href="<?php echo esc_url(get_day_link( get_the_time('Y'), get_the_time('m'), get_the_time('d'))); ?>"> <?php echo esc_html(get_the_date()); ?></a>
        </li>
    </ul>
    <div class="entry-content">
        <p><?php esc_html(the_content()); ?></p>
    </div>
    <div class="entry-navigation-post">
        <div class="prev-post">
            <p class="heading"><?php echo esc_html__('Previous  post', 'dziri');?></p>
            <?php $prev_post = get_previous_post(); 
                if ($prev_post) : 
            ?>
            <h3 class="title">
                <a href="<?php echo esc_url(get_permalink($prev_post)); ?>"><?php echo esc_html($prev_post->post_title); ?></a>
            </h3>
            <?php echo get_the_post_thumbnail($prev_post); 
                endif;
            ?>
        </div>
        <div class="next-post">
            <p class="heading"><?php echo esc_html__('Next  post', 'dziri');?></p>
            <?php $next_post = get_next_post(); 
                if ($next_post) : 
            ?>
            <h3 class="title">
                <a href="<?php echo esc_url(get_permalink($next_post)); ?>"><?php echo esc_html($next_post->post_title); ?></a>
            </h3>
            <?php echo get_the_post_thumbnail($next_post); 
                endif;
            ?>
        </div>
    </div>
</article>
<?php 
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    } 
?>