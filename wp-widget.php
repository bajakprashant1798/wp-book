<?php
class wpbook1_Widget extends WP_Widget {

/**
 * Register widget with WordPress.
 */
function __construct() {
    parent::__construct(
        'wpbook1_widget', // Base ID
        esc_html__( 'Book Category', 'wpbook1_domain' ), // Name
        array( 'description' => esc_html__( 'Widget display', 'wpbook1_domain' ), ) // Args
    );
}

/**
 * Front-end display of widget.
 *
 */
public function widget( $args, $instance ) {
    echo $args['before_widget'];
    if ( ! empty( $instance['title'] ) ) {
        echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }

    echo 'Hello from wordpress book store';

    echo esc_html__( 'Hello, World!', 'wpbook1_domain' );
    echo $args['after_widget'];
}

/**
 * Back-end widget form.
 *
 */
public function form( $instance ) {
    $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New book title', 'wpbook1_domain' );
    ?>
    <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'wpbook1_domain' ); ?></label> 
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>
    <?php 
}

/**
 * Sanitize widget form values as they are saved.
 *
 */
public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

    return $instance;
}

} // class Foo_Widget   

