<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

get_header();
?>

<?php
$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>

<div class="wrapper" id="archive-wrapper">
	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main" id="main">
<div class="row">
				<?php if ( have_posts() ) : ?>

					<header class="page-header archive-header">
						<?php
						the_archive_title( '<h1 class="page-title container">', '</h1>' );
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
						?>
					</header><!-- .page-header -->
<hr/>
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
<div class="col-lg-6">
                           <article class="">
                                    <div class="cat-feat_image_wrapper">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">  <?php
                                            if ( has_post_thumbnail() ) {
                                                $class = "";
                                                echo get_the_post_thumbnail( $post->ID, 'large' );
                                            }
                                            else {
                                                $class = "no-padding";
                                                echo '<img src="' . get_bloginfo( 'stylesheet_directory' )
                                                    . '/img/blog-Thumbnail.jpg" />';
                                            }
                                            ?></a>
                                    </div>
                                    <header class="entry-header mt-2 mb-2">
                                        <?php if(!empty($post_cat)){
                                            $list = implode('<span>&#8226;</span>',$post_cat);
                                            ?>
                                            <h3 class="blog-category"><?php echo $list; ?></h3>
                                        <?php } ?>
                                        <h2 class="entry-title <?php echo $class;?>"><a class="post-title" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                                    </header><!-- .entry-header -->
                                    <p><?php
                                        the_excerpt();
                                        // $excerpt = !empty($post->post_excerpt) ? $post->post_excerpt : get_the_content($post->ID);
                                        // echo $excerpt; ?>
                                    </p>
                                    <!-- .entry-content -->
                                </article>
</div>
					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>
</div>
			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php  if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

			<?php get_sidebar( 'blog' ); ?>

		<?php endif; ?>

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
