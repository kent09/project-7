<?php
/**
 * Blank content partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$address = get_field('location');
$opening_hours = get_field('opening_hours');
$background_image = get_field('contact_details_image_background');
$phonenumbers = get_field('telephone_number');
$address_link = get_field('map_link');
?>
<div id="contact-header-title" class="container">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</article><!-- #post-## -->
</div>
<div id="contact-content" class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="cc-details">
				<!-- <h2>Get In Touch</h2> -->
				<div>
					<i class="fas fa-map-marker-alt"></i><span class="address"><a href="<?php echo $address_link; ?>"><p><?php echo $address; ?></p></a></span>
				</div>
				<div>
					<i class="fas fa-mobile-alt"></i><span class="numbers"><?php echo $phonenumbers; ?></span>
				</div>
				<div>
					 <span class="opening-hours"><?php echo $opening_hours; ?></span>
				</div>
				<div class="embed-container">
					<style>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; } .embed-container iframe, .embed-container object, .embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; margin-top:5%; }</style>
					<div class='embed-container'><iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3320.670208669378!2d150.86161261505387!3d-33.66570618071287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b1297e248181e09%3A0x3b4ee8fec861e88b!2sOz+Canopies+%26+4x4+Accessories!5e0!3m2!1sen!2sph!4v1557804418612!5m2!1sen!2sph' width='600' height='450' frameborder='0' style='border:0' allowfullscreen></iframe></div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<?php echo get_field('contact_form'); ?>
		</div>
	</div>
</div>