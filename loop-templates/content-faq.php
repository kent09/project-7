<?php
/**
 * Blank content partial template.
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>
<div id="faq-header-title">
	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</article><!-- #post-## -->
</div>

<div class="faq-content">
    <?php if (have_rows('faq_list')) :
        $ctr = 0;
        while (have_rows('faq_list')) : the_row();
            // vars
            $question = get_sub_field('question');
            $answer = get_sub_field('answer');
    ?>
            <div class="faq-holder">
            	<h3><?php echo $question; ?></h3>
            	<?php echo $answer; ?>
            </div>
    <?php
            $ctr++;
        endwhile;
    else :

    // no rows found

    endif;
    ?>

</div>


