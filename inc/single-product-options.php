<?php 

add_action( 'woocommerce_single_product_summary', 'single_product_payment_method', 12 );
function single_product_payment_method() {

    $html = '<div class="payment-method-text">';
    $html .= get_field('payment_method_text');
    $html .= '</div>';

    if(get_field('payment_method_text')) {
        echo $html;
    }
}

// -----------------------------------------
// 2. Throw error if custom input field empty
 
add_filter( 'woocommerce_add_to_cart_validation', 'single_product_add_on_validation', 10, 3 );
 
function single_product_add_on_validation( $passed, $product_id, $qty ){

    if( (isset($_POST['_delivery']) && $_POST['_delivery'] == 'quote') || (isset($_POST['_delivery']) && $_POST['_delivery'] == 'pickup') ) {
        $passed = false;
    }
    return $passed;
}

 
// -----------------------------------------
// 3. Save custom input field value into cart item data
 
// add_filter( 'woocommerce_add_cart_item_data', 'single_product_add_on_cart_item_data', 10, 2 );
 
// function single_product_add_on_cart_item_data( $cart_item, $product_id ){

//     if( isset( $_POST['_quote'] ) ) {
//         $cart_item['quote'] = sanitize_text_field( $_POST['_quote'] );
//     }
//     if( isset( $_POST['_delivery'] ) ) {
//         $cart_item['delivery'] = sanitize_text_field( $_POST['_delivery'] );
//     }
//     return $cart_item;
// }
 
// -----------------------------------------
// 4. Display custom input field value @ Cart
 
// add_filter( 'woocommerce_get_item_data', 'single_product_add_on_display_cart', 10, 2 );
 
// function single_product_add_on_display_cart( $_data, $cart_item ) {

//     if ( isset( $cart_item['delivery'] ) ){
//         $_data[] = array(
//             'key' => __( 'Delivery Method '),
//             'value' => $cart_item['delivery'] == 'pickup' ? 'Pick up' : 'Delivery',
//             'display' => ''
//         );
//     }

//     return $_data;
// }
 
// -----------------------------------------
// 5. Save custom input field value into order item meta
 
// add_action( 'woocommerce_add_order_item_meta', 'single_product_add_on_order_item_meta', 10, 2 );
 
// function single_product_add_on_order_item_meta( $item_id, $values ) {
//     if ( ! empty( $values['delivery'] ) ) {
//         wc_add_order_item_meta( $item_id, 'Delivery Method', $values['delivery'], true );
//     }
// }
 
// -----------------------------------------
// 6. Display custom input field value into order table
 
// add_filter( 'woocommerce_order_item_product', 'single_product_add_on_display_order', 10, 2 );
 
// function single_product_add_on_display_order( $cart_item, $order_item ){
//     if( isset( $order_item['delivery'] ) ){
//         $cart_item_meta['delivery'] = $order_item['delivery'];
//     }
//     return $cart_item;
// }
 
// -----------------------------------------
// 7. Display custom input field value into order emails
 
// add_filter( 'woocommerce_email_order_meta_fields', 'single_product_add_on_display_emails' );
 
// function single_product_add_on_display_emails( $fields ) { 
//     $fields['delivery'] = 'Delivery Method';
//     return $fields; 
// }

// add_action( 'woocommerce_checkout_create_order_line_item', 'single_product_add_delivery_option_to_order_items', 10, 4 );

// function single_product_add_delivery_option_to_order_items( $item, $cart_item_key, $values, $order ) {
//     if ( empty( $values['delivery'] ) ) {
//         return;
//     }
 
//     $item->add_meta_data( __( 'Delivery Method' ), $values['delivery'] );
// }
 

/**
 * Output plus button for quantity.
 */

add_action( 'woocommerce_before_add_to_cart_quantity', 'single_display_quantity_plus' );
function single_display_quantity_plus() { 
    ?>
    <div class="quantity-holder">
        <span class="input-group-btn">
            <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quantity">
                <i class="fa fa-plus"></i>
            </button>
        </span>
    <?php
}

/**
 * Output minus button for quantity.
 */

add_action( 'woocommerce_after_add_to_cart_quantity', 'single_display_quantity_minus' );
function single_display_quantity_minus() { 
    ?>
        <span class="input-group-btn">
            <button type="button" class="btn btn-default btn-number btn-minus" disabled="disabled" data-type="minus" data-field="quantity">
                <i class="fa fa-minus"></i>
            </button>
        </span>
    </div>
    <?php
}

// change related product text
function custom_related_products_text( $translated_text, $text, $domain ) {
  switch ( $translated_text ) {
    case 'Related products' :
      $translated_text = __( 'Customers also looked at', 'woocommerce' );
      break;
  }
  return $translated_text;
}
add_filter( 'gettext', 'custom_related_products_text', 20, 3 );


add_filter( 'woocommerce_product_description_tab_title', 'rename_description_product_tab_label' );

function rename_description_product_tab_label() {
    return 'Specifications';
}
add_filter( 'woocommerce_product_additional_information_tab_title', 'rename_additional_info_product_tab_label' );
 
function rename_additional_info_product_tab_label() {
    return 'Options';
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_single_add_to_cart_text' );  // 2.1 +
function woo_custom_single_add_to_cart_text() {
    return __( 'GET A QUOTE', 'woocommerce' );
}

function hide_shipping_method_based_on_shipping_class( $rates, $package )
{
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    // HERE define the shipping method to hide
    $method_key_id = 'flat_rate:1';

    // Checking in cart items
    $cart_item = array_column(WC()->cart->get_cart(), 'delivery');
    if(!in_array('delivery', $cart_item) && in_array("pickup", $cart_item)) {
        unset($rates[$method_key_id]);
    }
    return $rates;
}
add_filter( 'woocommerce_package_rates', 'hide_shipping_method_based_on_shipping_class', 10, 2 );

// change checkout text
function woocommerce_button_proceed_to_checkout() { 
    $text = 'SUBMIT YOUR QUOTE';
    $cart_item = array_column(WC()->cart->get_cart(), 'delivery');
    if(!in_array('pickup', $cart_item)) {
        $text = 'PROCEED TO CHECKOUT';
    } 
    ?>

    <a href="<?php echo esc_url( wc_get_checkout_url() );?>" class="btn btn-primary btn-lg btn-block">
        <?php esc_html_e( $text, 'woocommerce' ); ?>
    </a>

    <?php
} 


add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 
function woo_custom_order_button_text() {
    $text = 'SUBMIT YOUR QUOTE';
    $cart_item = array_column(WC()->cart->get_cart(), 'delivery');
    if(!in_array('pickup', $cart_item)) {
        $text = 'PLACE YOUR ORDER';
    }
    return __( $text, 'woocommerce' ); 
}


add_filter( 'gettext', 'translate_woocommerce_strings', 999, 3 );
function translate_woocommerce_strings( $translated, $text, $domain ) {

    if(is_checkout()) {
        $cart_item = array_column(WC()->cart->get_cart(), 'delivery');
        if(in_array('pickup', $cart_item)) {
            return $translated = str_ireplace( 'Your order', 'Your quote', $translated );
        }
    }
   
    return $translated;
}


function wpb_new_product_tab( $tabs ) {
    // Add the new tab
    global $post;
    unset( $tabs[ 'description' ]);
    unset( $tabs[ 'additional_information']);
    if ( $post->post_excerpt ) {
        $tabs['description'] = array(
            'title'       => __( 'Specifications'),
            'priority' => 5,
            'callback'    => 'woocommerce_product_description_tab'
        );
    }
    return $tabs;

}
add_filter( 'woocommerce_product_tabs', 'wpb_new_product_tab' );


add_filter( 'woocommerce_product_tabs', 'custom_tabs' );
function custom_tabs( $tabs ) {
    global $post;
    
    $priority = 100;
    while ( has_sub_field( 'tabs', $post->ID ) ) {
        $title = get_sub_field( 'title' );
        $content = get_sub_field( 'content' );
        $id = sanitize_title( $title );
        $id = str_replace( '-', '_', $id );

        $tabs[ $id ] = array(
            'title'     => $title,
            'priority'  => $priority++,
            'callback'  => 'custom_tab_content'
        );
    }
    
    return $tabs;
}


function custom_tab_content( $id ) {
    global $post;
    while ( has_sub_field( 'tabs', $post->ID ) ) {
        $title = get_sub_field( 'title' );
        $this_id = sanitize_title( $title );
        $this_id = str_replace( '-', '_', $this_id);
        if ( $id == $this_id ) {
            the_sub_field( 'content' );
        }
    }
}

// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields', 20, 1 );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
    
    $fields['billing']['billing_address_1']['placeholder'] = '';
    $fields['billing']['billing_address_2']['placeholder'] = '';
    $fields['billing']['billing_address_2']['label'] = 'Apartment, suite, unit etc.(optional)';
    $fields['shipping']['shipping_address_1']['placeholder'] = '';
    $fields['shipping']['shipping_address_2']['placeholder'] = '';
    $fields['shipping']['shipping_address_2']['label'] = 'Apartment, suite, unit etc.';
    return $fields;
}
