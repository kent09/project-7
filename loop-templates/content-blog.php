<?php
/**
 * Content empty partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div id="faq-header-title" class="container">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</article><!-- #post-## -->
</div>
<div class="container blog-list">
	<div class="row">
		<div class="col-md-12">
			<?php 
			// the query
			$wpb_all_query = new WP_Query(array('post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>
			 
			<?php if ( $wpb_all_query->have_posts() ) : ?>
			<div id="blog-list">
				<ul>
				 
				    <!-- the loop -->
				    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
				        <li>
				        	<div class="blog-post-thum container">
				        		<div class="row">
				        			<div class="col-md-3">
				        				<div class="thumb-img-holder">
				        					<?php the_post_thumbnail(); ?>
				        				</div>
				        			</div>
				        			<div class="col-md-9">
				        				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				        				<div class="blog-excerpt"><?php echo get_excerpt();?></div>
				        			</div>
				        		</div>
				        	</div>
				        </li>
				    <?php endwhile; ?>
				    <!-- end of the loop -->
				 
				</ul>
			 </div>
			    <?php wp_reset_postdata(); ?>
			 
			<?php else : ?>
			    <p><?php _e( 'Sorry, no posts to display.' ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>
