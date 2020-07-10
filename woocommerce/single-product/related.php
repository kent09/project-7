<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post;
$terms = get_the_terms( $post->ID, 'make_model');
if($terms){
	foreach ($terms as $key => $value) {
		if($value->parent):
			$cat[] = $value->slug;
		endif;
	}
}

$args = array(
	'post_type' => 'product',
	'post_status' => 'publish',
	'posts_per_page' => 4,
	'orderby'        => 'rand',
	'tax_query' => array(
		array(
			'taxonomy' => 'make_model',
			'field'    => 'slug',
			'terms'    => isset($cat) ? $cat : '' ,
		),
	),
);
$query = new WP_Query( $args );

if ( $query->have_posts() ):

?>
<div class="related-product">
	<div class="container">
		<section class="related products">

      <?php
      $heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related products', 'woocommerce' ) );

      if ( $heading ) :
        ?>
        <h2><?php echo esc_html( $heading ); ?></h2>
      <?php endif; ?>
				
			<?php 

				woocommerce_product_loop_start();
				// The Loop
					while ( $query->have_posts() ) {
						$query->the_post();
				      	
				      	$post_object = get_the_ID();
				     
						setup_postdata( $GLOBALS['post'] =& $post_object );
						wc_get_template_part( 'content', 'product' );

					}
	
				woocommerce_product_loop_end();
	 		
			?>
		
		</section>
	</div>
</div>

<?php

endif;

wp_reset_postdata();
