<?php

class Dziri_Search extends WP_Widget {
	public function __construct() {
        parent::__construct(
            'dziri_search',
            'Dziri Search'
        );
	}

	public function widget( $args, $instance ) {
        extract( $args );
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $before_widget;
        if ( isset( $title ) ) {
            echo $before_title . $title . $after_title;
        }
        get_search_form();
        echo $after_widget;
	}

	public function form( $instance ) {
        $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : __( 'Search', 'dziri' );
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html__( 'Title:', 'dziri' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

	public function update( $new_instance, $old_instance ) {
        $instance          = $old_instance;
		$instance['title'] = ( isset( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : __( 'Last Posts', 'dziri' );
		return $instance;
	}
}