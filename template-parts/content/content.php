<?php
/**
 * Template part for displaying blog posts
 *
 * @package Dziri
 */

?>

<article class="category-blog">
    <div class="content-inner">
        <div class="post-formats-wrapper">
            <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" title="<?php esc_attr(the_title_attribute()); ?>">
                    <?php the_post_thumbnail(); ?>
                </a>
            <?php endif; ?>
        </div> 
        <div class="entry-content">
            <header class="entry-header">
                <div class="entry-contain">
                    <h2 class="entry-title">
                        <a <?php echo 'href="' . esc_url(get_permalink()) . '"'; ?>><?php esc_html(the_title()); ?></a>
                    </h2> 
                        <?php
                            if(!is_search()) { ?>
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
                                            $output .= '<a href="' . esc_url(get_category_link( $category->term_id )) . '">' . esc_html($category->name) . ' </a>';
                                        endforeach;
                                        echo $output; ?>
                                    </li>
                                </ul>
                            <?php
                            }
                        ?>
                </div>
            </header>
            <div class="entry-summary">
                <p><?php esc_html(the_excerpt()); ?></p>
            </div>
            <button class="btn-primary">
                <a <?php echo 'href="' . esc_url(get_permalink()) . '"'; ?>><?php echo esc_html__('Read More', 'dziri'); ?></a>
            </button>
        </div>
    </div>
</article>