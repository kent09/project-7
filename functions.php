<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

include 'inc/product_list_widget.php';

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();

    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );

    //wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', array(), $the_theme->get( 'Version' ) );

    wp_enqueue_style( 'simple-bar', get_stylesheet_directory_uri() . '/css/simplebar.min.css', array(), $the_theme->get( 'Version' ) );

    wp_enqueue_style( 'slick-slider', get_stylesheet_directory_uri() . '/css/slick.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/css/slick-theme.css', array(), $the_theme->get( 'Version' ) );
    // wp_enqueue_style( 'select2-css', get_stylesheet_directory_uri() . '/css/select2.min.css', array(), $the_theme->get( 'Version' ) );

    wp_enqueue_style( 'custom-style', get_stylesheet_directory_uri() . '/css/custom.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'category-style', get_stylesheet_directory_uri() . '/css/category.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'single-product-style', get_stylesheet_directory_uri() . '/css/single-product.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_style( 'media-query-style', get_stylesheet_directory_uri() . '/css/media-query.css', array(), $the_theme->get( 'Version' ) );
    // wp_enqueue_script( 'selectWoo-style', get_stylesheet_directory_uri() . '/css/selectWoo.css', array(), $the_theme->get( 'Version' ), true );

    wp_enqueue_script( 'jquery');

    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );

    // wp_enqueue_script( 'jquery-2.2.2.0', 'https://code.jquery.com/jquery-2.2.0.min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'simple-bar-js', get_stylesheet_directory_uri() . '/js/simplebar.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/js/slick.js', array(), $the_theme->get( 'Version' ), true );
    // wp_enqueue_script( 'select2-js', get_stylesheet_directory_uri() . '/js/select2.min.js', array(), $the_theme->get( 'Version' ), true );
    wp_enqueue_script( 'custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array(), $the_theme->get( 'Version' ), true );

    if( is_singular( 'product' )) {
      global $post;

      $placeholder_arr = get_post_meta ($post->ID, 'default_placeholder', true);
      if(is_array($placeholder_arr)){
        wp_localize_script('custom-js', 'default_placeholder', $placeholder_arr);
      }
    }
    // wp_enqueue_script( 'selectWoo-js', get_stylesheet_directory_uri() . '/js/selectWoo.full.min.js', array(), $the_theme->get( 'Version' ), true );
    

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'init', 'script_enquer' );

function script_enquer() {

    $the_theme = wp_get_theme();

    wp_register_script( 'product-filter-js', get_stylesheet_directory_uri() . '/js/product-filter.js', array(), $the_theme->get( 'Version' ), true );

    wp_localize_script( 'product-filter-js', 'product_cat_filter', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

    wp_enqueue_script( 'product-filter-js' );

}

add_action("wp_ajax_product_cat_filter", "product_cat_filter");
add_action("wp_ajax_nopriv_product_cat_filter", "product_cat_filter");

function product_cat_filter() {

    wc_clear_notices();


    if(!isset($_REQUEST["term"])) {

        $respond['type'] = "error";

        $respond = json_encode($respond);

        echo $respond;

        wp_die();
        
        return false;
    }
        
    $terms = $_REQUEST["term"];
    $arr = [];
    foreach ($terms as $term) {
        $result = get_term($term);
        array_push($arr, $result->slug);
    }

    $arr = implode(",",$arr);

    $prod_cat = [
        'product_cat' => $arr
    ];

    $respond['type'] = "success";
    $respond['result'] = $prod_cat;

    $respond = json_encode($respond);

    echo $respond;

    
    wp_die();
}


function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
    acf_add_options_sub_page('Header');
    acf_add_options_sub_page('Footer');
    acf_add_options_sub_page('Product Categories');
    acf_add_options_sub_page('Product Single Page');
}


if ( ! function_exists( 'footer_sidebars' ) ) {

    // Register Sidebars
    function footer_sidebars() {

        $args = array(
            'id'            => 'first',
            'name'          => __( 'First Footer Menu' ),
            'description'   => __( 'First Footer Menu' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
        );
        register_sidebar( $args );

        $args = array(
            'id'            => 'second',
            'name'          => __( 'Second Footer Menu' ),
            'description'   => __( 'Second Footer Menu' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
        );
        register_sidebar( $args );

        $args = array(
            'id'            => 'third',
            'name'          => __( 'Third Footer Menu' ),
            'description'   => __( 'Third Footer Menu' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
        );
        register_sidebar( $args );

        $args = array(
            'id'            => 'forth',
            'name'          => __( 'Forth Footer Logo Info' ),
            'description'   => __( 'Forth Footer Logo Info' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
        );
        register_sidebar( $args );

    }
    add_action( 'widgets_init', 'footer_sidebars' );

}
add_filter('get_product_search_form','custom_product_search_form');

function custom_product_search_form ($form) {
        $form = '<form role="search" method="get" id="searchform" action="' . esc_url( home_url( '/'  ) ) . '">
                <div>
                        <label class="screen-reader-text" for="s">' . __( 'Search for:', 'woocommerce' ) . '</label>
                        <div class="form-group has-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" value="' . get_search_query() . '" class="form-control" placeholder="' . __( ' Search Your Car or Product', 'woocommerce' ) . '">
                        </div>
                        <input type="hidden" name="post_type" value="product" />
                </div>
                </form>';
        return $form;
}

function loopProductImage($product) {
    if ( $attachment_ids = $product->get_gallery_image_ids() ) {

        if( $product->get_image_id() ) {
            array_push($attachment_ids, $product->get_image_id());
        }

        foreach ( $attachment_ids as $attachment_id ) {
            echo '<li>'. wp_get_attachment_image( $attachment_id, "full" ).'</li>';
        }

    }
}

/**
 * Change the breadcrumb separator
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'wcc_change_breadcrumb_delimiter' );
function wcc_change_breadcrumb_delimiter( $defaults ) {
    // Change the breadcrumb delimeter from '/' to '>'
    $defaults['delimiter'] = ' > ';
    return $defaults;
}


/** 
    filter product category
**/
add_action('pre_get_posts','search_filter');
function search_filter($query) {
    if ( !is_admin() && $query->is_main_query() && isset($_GET["product_category"])) {
        $term_query = $query->tax_query->queries[0]['terms'];
        // $term = get_term_by('slug', $query->query_vars['make_model'], 'make_model');

        $taxquery = array(
            'relation' => 'AND',
            array(
                'taxonomy' => 'make_model',
                'field' => 'slug',
                'terms' => $term_query,
            ),
            array(
                'taxonomy' => 'product_cat',
                'field' => 'id',
                'terms' => array( $_GET["product_category"] ),
            )
        );

        $query->set('post_type', array( 'product' ));
        $query->set('tax_query', $taxquery);
        
    }
}

/** 
    Single product delivery option function
**/
require_once 'inc/single-product-options.php';


add_theme_support( 'post-thumbnails' );

add_action( 'widgets_init', 'blog_sidebar' );
function blog_sidebar() {
    register_sidebar( array(
        'name' => __( 'Blog Sidebar', 'understrap' ),
        'id' => 'blog-sidebar',
        'description' => __( 'Widgets in this area will be shown on blog category.', 'understrap' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}


//add option to enable or disable visibility for form label
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

add_filter( 'gform_form_tag', 'gform_form_tag_autocomplete', 11, 2 );
function gform_form_tag_autocomplete( $form_tag, $form ) {
 if ( is_admin() ) return $form_tag;
 if ( GFFormsModel::is_html5_enabled() ) {
 $form_tag = str_replace( '>', ' autocomplete="off">', $form_tag );
 }
 return $form_tag;
}
add_filter( 'gform_field_content', 'gform_form_input_autocomplete', 11, 5 ); 
function gform_form_input_autocomplete( $input, $field, $value, $lead_id, $form_id ) {
 if ( is_admin() ) return $input;
 if ( GFFormsModel::is_html5_enabled() ) {
 $input = preg_replace( '/<(input|textarea)/', '<${1} autocomplete="off" ', $input ); 
 }
 return $input;
}


function shortNumber($num) 
{
    $units = ['', 'K', 'M', 'B', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000;
    }
    return round($num, 2) . $units[$i];
}

function format_product_number($string) {
    return sprintf("%s %s %s",
                substr($string, 0, 5),
                substr($string, 5, 3),
                substr($string, 8));
}

function getProductRulebyTitle($title) {
    if(class_exists('FlycartWooDiscountRulesPricingRules')){
        //class from woo-discount-rules plugin
        $price_rules = new FlycartWooDiscountRulesPricingRules();
        $all_rules = $price_rules->getRules();
        $rule_data = "";
        foreach($all_rules as $rule){
            if(trim($rule->post_title )== trim($title)){
                $rule_data = $rule;
                break;
            }
        }
        return $rule_data;
    }
}

// add span on the message alert
add_filter( 'wc_add_to_cart_message_html', function( $message ) {
    return preg_replace(
        // Or use ^(<a href=".+?" class="button wc-forward">.+?</a>) *(.+)
        '#^(<a href=".+?" class="button wc-forward">.+?</a>) +(.+)#',
        '<span>$2</span> $1',
        trim( $message )
    );
} );

function telephoneTrim($string) {
    return str_replace(["-", "–", " "], '', $string);
}


add_action( 'template_redirect', 'my_custom_redirect' );
function my_custom_redirect() {

    if (!is_category() && !is_tag() && !is_tax())
        return false;

    $taxonomyName = get_query_var( 'taxonomy' );
    if($taxonomyName == 'make_model') {
      $parent = get_term_by('id', get_queried_object()->parent, $taxonomyName) ? ','.get_term_by('id', get_queried_object()->parent, $taxonomyName)->slug : '';
      $child_term = get_queried_object()->slug;

      if(isset($_GET['really_curr_tax'])){
        $really_tax = explode("-", sanitize_text_field($_GET['really_curr_tax']));
        $cat_id = $really_tax[0];
        $prod_cat = get_term_by( 'id', (int)$cat_id, 'product_cat' );
        if ($prod_cat && empty($parent)) {
          $arg['product_cat'] = $prod_cat->slug;
          $current = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
          $redirect = add_query_arg($arg, $current);
          wp_safe_redirect($redirect);
          exit();
        }
      }

      if(empty($parent)) return false;

      $arg = [
        'swoof' => 1,
        $taxonomyName => $child_term.$parent,
      ];
      if (isset($prod_cat)) {
        $arg['product_cat'] = $prod_cat->slug;
      }

      $current = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

      $redirect = add_query_arg($arg, $current);
      wp_safe_redirect($redirect);

      exit();
    }
}  

add_action( 'woocommerce_after_add_to_cart_button', 'privacy_message_below_add_to_cart_button', 1, 0);

function privacy_message_below_add_to_cart_button() {
    if(get_field('contact_us_info', 'option')) {
        the_field('contact_us_info', 'option');
    }
}

add_filter( 'gform_confirmation_anchor', '__return_false' );
add_filter('acf/settings/remove_wp_meta_box', '__return_false');
