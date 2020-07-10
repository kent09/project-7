<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package understrap
 */

if ( ! is_active_sidebar( 'left-sidebar' ) ) {
	return;
}

// when both sidebars turned on reduce col size to 3 from 4.
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<?php if ( 'both' === $sidebar_pos ) : ?>
	<div class="col-md-3 widget-area" id="left-sidebar" role="complementary">
<?php else : ?>
	<div class="col-md-3 widget-area" id="left-sidebar" role="complementary">
<?php endif; ?>
<?php dynamic_sidebar( 'left-sidebar' ); ?>

<p class="clear"></p>

<div class="compform">
<?php the_field('competition_form', 'option'); ?>
</div>

<p class="clear"></p>
<?php if( have_rows('category_sidebar_banners', 'option') ): ?>    
    <?php while( have_rows('category_sidebar_banners', 'option') ): the_row(); ?>
<p align="center"><a href="<?php the_sub_field('sidebar_link'); ?>"><img src="<?php the_sub_field('sidebar_banner'); ?>"></a></p>
    <?php endwhile; ?>    
<?php endif; ?>
						



</div><!-- #secondary -->
