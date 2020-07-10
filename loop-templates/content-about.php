<?php
/**
 * Content empty partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$content = get_field('about_content');
?>
<div id="about-header-title" class="container">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</article><!-- #post-## -->
</div>
<div class="container-fluid">
	<div id="au-content" class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="content-holder">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</div>
</div>