<?php

class Last_Posts extends WP_Widget {
	public function __construct() {
        parent::__construct(
            'dziri_last_posts',
            'Dziri Last Posts'
        );
	}

	public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( ! empty( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        if( $instance['posts_number'] > 5 ) :
            $instance['posts_number'] = 5;
        endif;
        $arg = array(
            'posts_per_page' => $instance['posts_number'],
        );
        $query = new WP_Query( $arg );
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                ?>
                    <div>
                        <div class="last-posts-img">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            <?php endif; ?>
                        </div>
                        <h2 class="last-posts">
                            <a href="<?php echo esc_url(get_permalink()); ?>"> <?php echo the_title(); ?></a>
                        </h2>
                    </div>
                <?php
            }
        }
        echo $after_widget;
        wp_reset_postdata();
	}

	public function form( $instance ) {
        $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Last Posts', 'dziri' );
        $posts_number = isset( $instance[ 'posts_number' ] ) ? (intval($instance[ 'posts_number' ])) : 3;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html__( 'Title:', 'dziri' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'posts_number' ); ?>"><?php esc_html__( 'Posts Number:', 'dziri' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'posts_number' ); ?>" name="<?php echo $this->get_field_name( 'posts_number' ); ?>" type="number" max="5" value="<?php echo esc_attr($posts_number); ?>" />
        </p>
        <?php
    }

	public function update( $new_instance, $old_instance ) {
        $instance          = $old_instance;
		$instance['title'] = ( isset( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : __( 'Last Posts', 'dziri' );
        $instance['posts_number'] = isset( $new_instance['posts_number'] ) ? intval( $new_instance['posts_number'] ) : 3;
		return $instance;
	}
}