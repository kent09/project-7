<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">
	<div class="guarantee">
		<div class="container">
			<div class="row align-items-center">
				<?php
					// check if the repeater field has rows of data
					if( have_rows('quality_guarantee', 'option') ):

					 	// loop through the rows of data
					    while ( have_rows('quality_guarantee', 'option') ) : the_row(); ?>

					        <div class="col-lg-4 col-md-6">
								<div class="holder2">
									<?php if(get_sub_field('icon', 'option')): ?>

										<?php echo wp_get_attachment_image( get_sub_field('icon'), $size = 'full-size', "", array( "class" => "img-responsive" ));  ?>

										<div class="content-text">
											<?php the_sub_field('text', 'option'); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
				<?php
					    endwhile;
					endif; ?>
			</div>
		</div>
	</div>
	<div class="<?php echo esc_attr( $container ); ?> footer-widget">

		<div class="row">
			<div class="col-lg-9 col-md-6">
				<div class="row">
					<div class="col-lg-4">
						<div class="holder">
							<?php dynamic_sidebar( 'first' ); ?>
						</div>
					</div><!--col end -->
					<div class="col-lg-4">
						<div class="holder">
							<?php dynamic_sidebar( 'second' ); ?>
						</div>
					</div><!--col end -->
					<div class="col-lg-4">
						<div class="holder">
							<?php dynamic_sidebar( 'third' ); ?>
						</div>
					</div><!--col end -->
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="holder">
					<?php dynamic_sidebar( 'forth' ); ?>
				</div>
			</div><!--col end -->
		</div><!-- row end -->

	</div><!-- container end -->

	<div class="copy-right">
		<ul>
			<li>
				<?php the_field('copy_right', 'option'); ?>
			</li>
			<li>
				<a href="<?php bloginfo("url") . the_field('private_link', 'option'); ?>"><?php the_field('private_text', 'option'); ?></a>
			</li>
			<li>
				<a href="<?php bloginfo("url") . the_field('terms_link', 'option'); ?>"><?php the_field('terms', 'option'); ?></a>
			</li>
		</ul>
	</div>	

</div><!-- wrapper end -->

</div><!-- #page we need this extra closing tag here -->

<?php wp_footer(); ?>

</body>

</html>

