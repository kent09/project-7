<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// Register and load the widget
function wpb_load_widget() {
  register_widget( 'wp_oz_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

class wp_oz_widget extends WP_Widget {

  function __construct() {
    parent::__construct(

      'wp_oz_widget',

      __('Product List Category'),

      array( 'description' => __('Show list of category'), )
    );
  }


  public function widget( $args, $instance ) {

    $tax = get_query_var('taxonomy');

    // if($tax != "product_cat"):

    $title = apply_filters( 'widget_title', $instance['title'] );
    $hide = $instance['is_empty_products'];
    $exclude_cat = $instance['excluded_categories'];

    echo $args['before_widget'];
    if ( ! empty( $title ) )
      echo $args['before_title'] . $title . $args['after_title'];

    echo '<ul class="product-categories woof_list_checkbox">';

    $taxonomy     = 'product_cat';
    $orderby      = 'name';
    $show_count   = 0;      // 1 for yes, 0 for no
    $pad_counts   = 0;      // 1 for yes, 0 for no
    $hierarchical = 1;      // 1 for yes, 0 for no
    $title        = '';
    $empty        = $hide;

    $args = array(
      'taxonomy'     => $taxonomy,
      'orderby'      => $orderby,
      'show_count'   => $show_count,
      'pad_counts'   => $pad_counts,
      'hierarchical' => $hierarchical,
      'title_li'     => $title,
      'hide_empty'   => $empty,
      'exclude'      => $exclude_cat
    );

    $all_categories = get_categories( $args );
    $make_model = get_query_var('make_model');

    $product_cat = get_query_var('product_cat');
    $product_cat = explode(",",$product_cat);


    foreach ($all_categories as $cat) {
      $class = '';
      if(in_array($cat->slug, $product_cat)){
        $class = 'checked';
      }

      echo '<li class="cat-item cat-item-'.$cat->term_id.'">
        <input type="checkbox" class="woof_checkbox_term" data-tax="product_cat" name="'.$cat->slug.'" data-term-id="'.$cat->term_id.'" value="'.$cat->term_id.'" '.$class.'>
        <label class="woof_checkbox_label">'.$cat->name.'</label></li>';
    }

    echo '</ul>';
    // endif;
  }

  // Widget Backend
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    } else {
      $title = __( 'Title');
    }

    if ( isset( $instance[ 'is_empty_products' ] ) ) {
      $hide = $instance[ 'is_empty_products' ];
    } else {
      $hide = "1";
    }

    if ( isset( $instance[ 'excluded_categories' ] ) ) {
      $ex_cat = $instance[ 'excluded_categories' ];
    } else {
      $ex_cat = [];
    }

    $args = array(
      'taxonomy'     => 'product_cat',
      'orderby'      => 'name',
      'show_count'   => 0,
      'pad_counts'   => 0,
      'hierarchical' => 0,
      'title_li'     => '',
      'hide_empty'   => 0
    );

    $all_categories = get_categories( $args );

    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
      <label for="<?php echo $this->get_field_id( 'is_empty_products' ); ?>"><?php _e( 'Hide if no items:' ); ?></label>
      <select id="<?php echo $this->get_field_id( 'is_empty_products' ); ?>" name="<?php echo $this->get_field_name( 'is_empty_products' ); ?>">
        <option value="1" <?php echo $hide == '1' ? 'selected' : '';  ?>>Yes</option>
        <option value="0" <?php echo $hide == '0' ? 'selected' : '';  ?>>No</option>
      </select>
    </p>
    <?php
    if (!empty($all_categories)) {
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'excluded_categories' ); ?>"><?php _e( 'Exclude Categories:' ); ?></label>
      <select id="<?php echo $this->get_field_id( 'excluded_categories' ); ?>" name="<?php echo $this->get_field_name( 'excluded_categories' ); ?>[]" multiple="multiple">
        <?php foreach($all_categories as $cat) { ?>
        <option value="<?php echo $cat->term_id; ?>" <?php if(!empty($ex_cat) && in_array($cat->term_id, $ex_cat)){ echo "selected"; } ?>><?php echo $cat->name; ?></option>
        <?php } ?>
      </select>
    </p>
    <?php } ?>
  <?php
  }

  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    $instance['is_empty_products'] = $new_instance['is_empty_products'];
    $instance['excluded_categories'] = $new_instance['excluded_categories'];
    return $instance;
  }
} // Class wpb_widget ends here