<?php
/**
 * Add WooCommerce support
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'after_setup_theme', 'understrap_woocommerce_support' );
if ( ! function_exists( 'understrap_woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function understrap_woocommerce_support() {
		add_theme_support( 'woocommerce' );

		// Add New Woocommerce 3.0.0 Product Gallery support.
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-slider' );

		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'understrap_wc_form_field_args', 10, 3 );
	}
}

/**
* First unhook the WooCommerce wrappers
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
* Then hook in your own functions to display the wrappers your theme requires
*/
add_action( 'woocommerce_before_main_content', 'understrap_woocommerce_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'understrap_woocommerce_wrapper_end', 10 );
if ( ! function_exists( 'understrap_woocommerce_wrapper_start' ) ) {
	function understrap_woocommerce_wrapper_start() {
		$container = get_theme_mod( 'understrap_container_type' );
		echo '<div class="wrapper" id="woocommerce-wrapper">';
		echo '<div class="' . esc_attr( $container ) . '" id="content" tabindex="-1">';
		echo '<main class="site-main" id="main">';
	}
}
if ( ! function_exists( 'understrap_woocommerce_wrapper_end' ) ) {
	function understrap_woocommerce_wrapper_end() {
		echo '</main><!-- #main -->';
		echo '</div><!-- Container end -->';
		echo '</div><!-- Wrapper end -->';
	}
}


/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
if ( ! function_exists( 'understrap_wc_form_field_args' ) ) {
	function understrap_wc_form_field_args( $args, $key, $value = null ) {
		// Start field type switch case.
		switch ( $args['type'] ) {
			/* Targets all select input type elements, except the country and state select input types */
			case 'select':
				// Add a class to the field's html element wrapper - woocommerce
				// input types (fields) are often wrapped within a <p></p> tag.
				$args['class'][] = 'form-group';
				// Add a class to the form input itself.
				$args['input_class']       = array( 'form-control', 'input-lg' );
				$args['label_class']       = array( 'control-label' );
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
					// Add custom data attributes to the form input itself.
				);
				break;
			// By default WooCommerce will populate a select with the country names - $args
			// defined for this specific input type targets only the country select element.
			case 'country':
				$args['class'][]     = 'form-group single-country';
				$args['label_class'] = array( 'control-label' );
				break;
			// By default WooCommerce will populate a select with state names - $args defined
			// for this specific input type targets only the country select element.
			case 'state':
				// Add class to the field's html element wrapper.
				$args['class'][] = 'form-group';
				// add class to the form input itself.
				$args['input_class']       = array( '', 'input-lg' );
				$args['label_class']       = array( 'control-label' );
				$args['custom_attributes'] = array(
					'data-plugin'      => 'select2',
					'data-allow-clear' => 'true',
					'aria-hidden'      => 'true',
				);
				break;
			case 'password':
			case 'text':
			case 'email':
			case 'tel':
			case 'number':
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control', 'input-lg' );
				$args['label_class'] = array( 'control-label' );
				break;
			case 'textarea':
				$args['input_class'] = array( 'form-control', 'input-lg' );
				$args['label_class'] = array( 'control-label' );
				break;
			case 'checkbox':
				$args['label_class'] = array( 'custom-control custom-checkbox' );
				$args['input_class'] = array( 'custom-control-input', 'input-lg' );
				break;
			case 'radio':
				$args['label_class'] = array( 'custom-control custom-radio' );
				$args['input_class'] = array( 'custom-control-input', 'input-lg' );
				break;
			default:
				$args['class'][]     = 'form-group';
				$args['input_class'] = array( 'form-control', 'input-lg' );
				$args['label_class'] = array( 'control-label' );
				break;
		} // end switch ($args).
		return $args;
	}
}

/**
 * hook in order to add custom field on composite product settings
 */
add_action( 'woocommerce_composite_component_admin_config_html', 'default_option_value_if_empty', 27, 3 );
function default_option_value_if_empty($id, $data, $product_id) {
  $placeholder_arr = get_post_meta ($product_id, 'default_placeholder', true);
  $placeholder = isset($placeholder_arr[$id]) ? $placeholder_arr[$id] : "";
  ?>
  <div class="component_title group_title">
    <div class="form-field">
      <label>
        <?php echo __( 'Default Dropdown Placeholder', 'woocommerce-composite-products' ); ?>
      </label>
      <input type="text" class="group_title component_text_input" name="bto_data[<?php echo $id; ?>][default_placeholder]" value="<?php echo esc_attr( $placeholder ); ?>"/><?php echo wc_help_tip( __( 'Default placeholder for dropdown.', 'woocommerce-composite-products' ) ); ?>
    </div>
  </div>
  <?php
}

/**
 * custom save
 */
add_action( 'woocommerce_admin_process_product_object', 'process_custom_field' );
function process_custom_field ($product) {
  if ( $product->is_type( 'composite' ) ) {
    $props = [];
    $counter  = 0;
    foreach ( $_POST[ 'bto_data' ] as $row_id => $post_data ) {
      // $group_id = current_time( 'timestamp' ) + $counter;
      $props[$counter] = strip_tags( wp_unslash( $post_data[ 'default_placeholder' ]));
      $counter++;
    }

    update_post_meta( $product->get_id(), 'default_placeholder', $props);
  }
}

//add payment fee if zip pay
add_action( 'woocommerce_cart_calculate_fees', 'oz_apply_payment_gateway_fee' );
function oz_apply_payment_gateway_fee( $cart_object ) {
  if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;

  $payment_method = WC()->session->get( 'chosen_payment_method' );
  $cart_total = $cart_object->subtotal +  $cart_object->shipping_total;

  if ($payment_method == 'zipmoney') {
    $label = __( 'Zip Money Surcharge', 'woocommerce' );
    $percent = 6;

    $charge = number_format(($cart_total / 100) * $percent, 2);

    // Adding the fee
    $cart_object->add_fee( $label, $charge, false );
  }
}

add_filter('woocommerce_gateway_description', 'updateZipMethodDescription', 10, 2);
function updateZipMethodDescription($description, $id) {
  if ($id == 'zipmoney'){
    return '<span class="zip-custom-desc d-block">Incurs a 6% surcharge.</span>'.  $description;
  } else {
    return $description;
  }
}

add_filter( 'aws_search_tax_results', 'my_aws_search_tax_results', 10, 3 );
function my_aws_search_tax_results( $result_array, $taxonomy, $s ) {
  $tax = $GLOBALS['tax_id'];
  if (!empty($tax)) {
    // $prod_cat = get_term_by( 'id', (int)$tax, 'product_cat' );
    $slug = $tax."-product_cat";
    if(isset($result_array['make_model'])) {
      foreach($result_array['make_model'] as $key=>$model){
        $new_link = $result_array['make_model'][$key]['link']."?really_curr_tax=".$slug;
        $result_array['make_model'][$key]['link'] = $new_link;
      }
    }
  }
  return $result_array;
}

add_action( 'aws_search_start', 'my_action_start', 10,2 );
function my_action_start( $s, $form_id) {
  if ($form_id == 2) {
    global $tax_id;
    $tax_id = $_REQUEST['tax'];
  }
}


// remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
// add_action( 'woocommerce_checkout_before_order_review', 'woocommerce_checkout_payment', 20 );


