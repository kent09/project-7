<?php
/**
 * Template Name: Blog Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>
<div class="wrapper" id="archive-wrapper">
	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">
		<div class="row">
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>
			<main class="site-main" id="main">

                <?php
                $args = array(
                    'numberposts' => 1,
                    'order' => 'DESC',
                    'post_type' => 'post',
                    'post_status' => 'publish'
                );
                $recent_post = wp_get_recent_posts( $args,OBJECT);
                $feat_post = get_posts(array(
                    'numberposts'	=> 1,
                    'post_type'		=> 'post',
                    'meta_query'	=> array(
                        array(
                            'key'	  	=> 'featured_post',
                            'value'	  	=> '1',
                            'compare' 	=> '=',
                        ),
                    ),
                ));
                $featured = !empty($feat_post) ? $feat_post[0] : $recent_post;
                $feat_categories = get_the_category($featured->ID);
                $feat_post_cat = array();
                foreach($feat_categories as $cat){
                    $feat_post_cat[] = "<a href='".get_category_link($cat->cat_ID)."'/>".$cat->name."</a>";
                }
                ?>
                <article class="post type-post status-publish format-standard has-post-thumbnail hentry blog-feat-post" id="post-<?php the_ID(); ?>">
                <?php echo get_the_post_thumbnail( $featured->ID, 'large' ); ?>
                 <header class="entry-header mt-2 mb-2 feat-post-header">
                        <?php if(!empty($feat_post_cat)){
                            $list = implode('<span>&#8226;</span>',$feat_post_cat);
                            ?>
                            <h3 class="blog-category"><?php echo $list; ?></h3>
                        <?php } ?>
                        <h2 class="entry-title <?php echo $class;?>"><a class="post-title" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <!--<div class="entry-meta"><span class="byline"> by <span class="author vcard"><a href="<?php //the_permalink(); ?>" rel="bookmark"><?php //$author = get_the_author(); echo $author; ?> </a></span></span> &#8226; <span class="posted-on"><time><?php //echo date("M d, Y"); ?></time></span></div>-->
                   </header><!-- .entry-header -->
                   <p><?php
                        $excerpt = !empty($post->post_excerpt) ? $post->post_excerpt : get_the_content($post->ID);
                        echo $excerpt; ?>
                   </p>
                </article>
                <div class="row">
                    <?php
                    $args = array(
                        'numberposts'	=> -1,
                        'post_type'		=> 'post',
                        'post_status' => 'publish',
                        'post__not_in' => array($featured->ID),
                        'orderby'=>'date',
                        'order'=>'DESC'

                    );
                    // query
                    $the_query = new WP_Query( $args );


                    if ( $the_query->have_posts() ) : ?>
                        <?php /* Start the Loop */ ?>
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post();
                            $class = "";
                            $categories = get_the_category();
                            $post_cat = array();
                            foreach($categories as $cat){
                                $post_cat[] = "<a href='".get_category_link($cat->cat_ID)."'/>".$cat->name."</a>";
                            }
                            ?>
                            <div class="col-lg-6 categorytemp">
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
                                        <!--<div class="entry-meta"><span class="byline"> by <span class="author vcard"><a href="<?php //the_permalink(); ?>" rel="bookmark"><?php //$author = get_the_author(); echo $author; ?> </a></span></span> &#8226; <span class="posted-on"><time><?php //echo date("M d, Y"); ?></time></span></div>-->
                                    </header><!-- .entry-header -->
                                    <p><?php

                                        $excerpt = !empty($post->post_excerpt) ? $post->post_excerpt : get_the_content($post->ID);
                                        // echo $excerpt; 
                                        echo get_the_excerpt($post->ID);

                                        // var_dump(get_the_excerpt($post->ID));
                                        ?>
                                    </p>
                                    <!-- .entry-content -->
                                </article>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <?php get_template_part( 'loop-templates/content', 'none' ); ?>
                    <?php endif; wp_reset_query(); ?>
                </div>
			</main><!-- #main -->
			<!-- The pagination component -->
			<?php understrap_pagination(); ?>
		</div><!-- #primary -->
		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>
			<?php get_sidebar( 'blog' ); ?>
		<?php endif; ?>
	</div> <!-- .row -->
</div><!-- Container end -->
</div><!-- Wrapper end -->
<?php get_footer(); ?>

