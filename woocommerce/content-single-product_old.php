<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked wc_print_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
  echo get_the_password_form(); // WPCS: XSS ok.
  return;
}

global $product;
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class(); ?>>
  <div class="row">
    <div class="col-md-7">
      <div class="row feature-default-desktop">
        <?php
        $attachment_ids = [];
        if($product->get_image_id()) {
          array_push($attachment_ids, $product->get_image_id());
        }
        if(!empty($product->get_gallery_image_ids())) {
          $attachment_ids = array_merge($product->get_gallery_image_ids(), $attachment_ids);
        }
        ?>


        <?php if(empty($attachment_ids)): ?>
        <div class="col">
          <div class="feature-default text-center">
            <?php
            echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) ); ?>
          </div>
          <?php else: ?>

          <?php if(!empty($product->get_gallery_image_ids())): ?>
          <div class="col-lg-9 col-md-8 col-sm-7 feature-default">
            <?php else: ?>
            <div class="col feature-default">
              <?php endif; ?>

              <?php woocommerce_show_product_sale_flash(); ?>
              <div class="product-feature-image slider">
                <?php foreach ($attachment_ids as $attachment_id ) { ?>
                  <div class="item">
                    <div class="woocommerce-product-gallery__wrapper">
                      <?php $html = wc_get_gallery_image_html( $attachment_id, true ); ?>
                      <?php echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id ); ?>
                    </div>
                  </div>
                  <?php /* <div class="item" style="background-image: url(<?php echo wp_get_attachment_image_url($attachment_id, 'full'); ?>);">
								</div> */ ?>
                <?php } ?>
              </div>

              <?php endif; ?>

            </div>
            <?php if(!empty($product->get_gallery_image_ids())): ?>
              <div class="col-lg-3 col-md-4 col-sm-5">
                <div class="side-thumbnail slider">
                  <?php foreach ($attachment_ids as $attachment_id ) { ?>
                    <div class="item" style="background-image: url(<?php echo wp_get_attachment_image_url($attachment_id, 'full'); ?>);">
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="short-description">
            <div class="content">
              <?php if(get_the_content()): ?>
                <h4>Product Details</h4>
                <?php the_content(); ?>
              <?php endif; ?>
            </div>
            <?php if(have_rows('model_list_left') || have_rows('model_list_right')): ?>
              <div class="model-list">
                <h4>This product is available for:</h4>
                <div class="content-wrapper">
                  <ul class="left-bullet">
                    <?php while( have_rows('model_list_left') ): the_row(); ?>
                      <li><?php echo get_sub_field('model_item'); ?></li>
                    <?php endwhile; ?>
                  </ul>
                  <ul class="right-bullet">
                    <?php while( have_rows('model_list_right') ): the_row(); ?>
                      <li><?php echo get_sub_field('model_item'); ?></li>
                    <?php endwhile; ?>
                  </ul>
                </div>
              </div>
            <?php endif;?>
          </div>
          <div class="product-summary-holder">
            <?php

            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
            remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 10 );
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
            remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
            /**
             * Hook: woocommerce_after_single_product_summary.
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_before_single_product_summary' );
            do_action( 'woocommerce_after_single_product_summary' );
            ?>
          </div>
        </div>
        <div class="col-md-5">
          <div class="entry-summary">
            <?php
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
            ?>
            <div class="product-code">
              Product code: <?php echo format_product_number($product->get_sku()); ?>
            </div>
            <?php woocommerce_template_single_title(); ?>
            <?php woocommerce_template_single_price(); ?>

            <?php if(empty($attachment_ids)): ?>
              <div class="feature-default-mobile text-center">
                <?php
                echo sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ), esc_html__( 'Awaiting product image', 'woocommerce' ) ); ?>
              </div>
            <?php else: ?>
              <div class="feature-default-mobile">
                <?php woocommerce_show_product_sale_flash(); ?>
                <div class="product-feature-image slider">
                  <?php foreach ($attachment_ids as $attachment_id ) { ?>
                    <div class="item" style="background-image: url(<?php echo wp_get_attachment_image_url($attachment_id, 'full'); ?>);">
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php endif; ?>

            <?php

            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action( 'woocommerce_single_product_summary' );
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="product-summary-holder">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php woocommerce_upsell_display(); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade productModal" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="title">Contact Us</div>
        <div class="modal-body">
          <?php echo do_shortcode(get_field('contact_popup_form', 'option'))?>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade productModal" id="pickUpModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <div class="title">Get A Quote</div>
        <div class="modal-body">
          <?php echo do_shortcode(get_field('getquote_popup_form', 'option'))?>
        </div>
      </div>
    </div>
  </div>

  <?php woocommerce_output_related_products(); ?>

  <?php do_action( 'woocommerce_after_single_product' ); ?>
