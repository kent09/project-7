<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package understrap
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

global $woocommerce;
$container = get_theme_mod('understrap_container_type');
$myaccount_page_id = get_option('woocommerce_myaccount_page_id');
$myaccount_page_url ="";
if ($myaccount_page_id) {
    $myaccount_page_url = get_permalink($myaccount_page_id);
}
$count = $woocommerce->cart->cart_contents_count;
$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : $woocommerce->cart->get_cart_url();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div class="site" id="page">

	<!-- ******************* The Navbar Area ******************* -->
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">

		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e('Skip to content', 'understrap'); ?></a>
    <?php
    $social = get_field('social_media', 'option');
    if ($social) {
    ?>
    <div class="social-media-list">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <ul class="list-inline social-media-icons mt-1 mb-1">
              <li class="list-inline-item first-label mr-3">Follow us</li>
              <?php foreach($social as $so) { ?>
              <li class="list-inline-item"><a href="<?php echo $so['url'];?>" target="_blank"><i class="<?php echo $so['font_awesome_class']; ?>"></i></a></li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
		<div class="container header">
			<div class="row">
				<div class="col-lg-4 col-md-4">
			<!-- Your site title as branding in the menu -->
				<?php if (! has_custom_logo()) {
    ?>

					<?php if (is_front_page() && is_home()) : ?>

						<h1 class="navbar-brand mb-0"><a rel="home" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" itemprop="url"><?php bloginfo('name'); ?></a></h1>

					<?php else : ?>

						<a class="navbar-brand" rel="home" href="<?php echo esc_url(home_url('/')); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" itemprop="url"><?php bloginfo('name'); ?></a>

					<?php endif; ?>


				<?php
} else {
        the_custom_logo();
    } ?><!-- end custom logo -->
				</div>
				<div class="col-lg-5 col-md-5 col-sm-10 col-10">
					<div class="top-search">
						<?php
							$search = get_field('search_bar', 'option');
						 	echo do_shortcode($search); 
						?>
	            	</div>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-2 col-2">
					<div class="top-right-info">
						<a href="<?php echo $cart_url; ?>" class="cart">
							<div class="icon">
			                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
			                    <?php
			                    	if($count > 0) {
                                    	echo "<span>".shortNumber($count)."</span>";
			                    	}
                                ?>
		                  	</div>
			                <div class="top-checkout-txt"><?php the_field('check_out_now_text', 'option'); ?></div>
		                </a>
		                <div class="top-contact">
		                	<?php
                        if(get_field('tel2_link', 'option') || get_field('tel1_link', 'option')):
                          $tel = get_field('tel1_link', 'option');
                        ?>
			                	<div class="icon">
										<a href="tel:<?php echo !empty($tel) ? telephoneTrim($tel) : telephoneTrim(get_field('tel2_link', 'option')) ?>"><i class="fa fa-phone" aria-hidden="true"></i></a>
								</div>
							<?php endif; ?>
							<div class="contact-number">
								<?php if(get_field('tel1_link', 'option')): ?>
									<a href="tel:<?php echo telephoneTrim(get_field('tel1_link', 'option')); ?>">

										<p><?php the_field('tel_1', 'option'); ?></p>
									</a>
								<?php endif; ?>
								
								<?php if(get_field('tel2_link', 'option')): ?>
									<a href="tel:<?php echo telephoneTrim(get_field('tel2_link', 'option')); ?>">
										<p><?php the_field('tel_2', 'option'); ?></p>
									</a>
								<?php endif; ?>
							</div>
						</div>
						<div class="navbar-dark">
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'understrap'); ?>">
								<div>
									<span></span>
									<span></span>
									<span></span>
								</div>
							</button>
						</div>
	                </div>
				</div>
			</div>
		</div>

		<nav class="navbar navbar-expand-md navbar-dark bg-primary">

		<?php if ('container' == $container) : ?>
			<div class="container">
		<?php endif; ?>
		
				<!-- The WordPress Menu goes here -->
				<?php wp_nav_menu(
                                    array(
                        'theme_location'  => 'primary',
                        'container_class' => 'collapse navbar-collapse',
                        'container_id'    => 'navbarNavDropdown',
                        'menu_class'      => 'navbar-nav ml-auto',
                        'fallback_cb'     => '',
                        'menu_id'         => 'main-menu',
                        'depth'           => 3,
                        'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
                    )
                ); ?>
			<?php if ('container' == $container) : ?>
			</div><!-- .container -->
			<?php endif; ?>

		</nav><!-- .site-navigation -->

	</div><!-- #wrapper-navbar end -->
