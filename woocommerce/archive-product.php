<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */

do_action( 'woocommerce_before_main_content' );

global $wp_query;
$cat = $wp_query->get_queried_object();

$image = null;
if(isset($cat->term_id)) {
	// $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
	$image = wp_get_attachment_url( $thumbnail_id );
}

$make_model = get_query_var( 'make_model');
$product_cat = get_query_var( 'product_cat');

$term = explode(",",$make_model);

$term_list = [];
foreach ($term as $terms) {
	$term_obj  = get_term_by('slug', $terms, 'make_model');
	if(isset($term_obj->name)){
		array_push($term_list, $term_obj->name);
	}
}

$term = implode(" ", array_reverse($term_list));

$product_title = ucwords( str_replace('-', ' ', $product_cat) );

$product_title = explode(",",$product_title);
$product_title = implode(", ", $product_title);


if(isset($_GET['product_category'])) {
	$product_term = get_term_by('id', $_GET['product_category'], 'product_cat');
	$product_title = $product_term->name;
}

$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );

?>

 <div class="row">

 	<?php if ( 'left' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>
		<?php get_template_part( 'sidebar-templates/sidebar', 'left' ); ?>
	<?php endif; ?>

	<div class="col prod-category-page">

		<?php if($image): ?>
			<div class="top-feature-image" style="background-image: url(<?php echo $image; ?>);">
				<div class="info"></div>
			</div>
		<?php endif; ?>
		<!-- <pre><?php //var_dump($cat->term_id); ?></pre> -->

		<header class="woocommerce-products-header">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) && empty($make_model) ) : ?>
				<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
			<?php else: ?>
				<h1 class="woocommerce-products-header__title page-title">
					<?php 
					if  ( !empty($product_title) && !empty($term) ) {

						echo $term.': '.$product_title; 

					} elseif ( !empty($product_title) ) {

						echo $product_title; 

					} elseif ( !empty($term) ) {

						echo $term; 

					} else {

						the_title();
					}
					?>
				</h1>
			<?php endif; ?>
		</header>
		<?php
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		if ( woocommerce_product_loop() ) {

			/**
			 * Hook: woocommerce_before_shop_loop.
			 *
			 * @hooked wc_print_notices - 10
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );

			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Hook: woocommerce_shop_loop.
					 *
					 * @hooked WC_Structured_Data::generate_product_data() - 10
					 */
					do_action( 'woocommerce_shop_loop' );

					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
		} else {
			/**
			 * Hook: woocommerce_no_products_found.
			 *
			 * @hooked wc_no_products_found - 10
			 */
			do_action( 'woocommerce_no_products_found' );
		}

		/**
		 * Hook: woocommerce_after_main_content.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */

		do_action( 'woocommerce_after_main_content' ); ?>
	</div>

	

</div>
<?php get_footer( 'shop' );
