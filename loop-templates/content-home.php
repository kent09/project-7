<?php
/**
 * Partial template for content in page.php
 *
 * @package understrap
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$size = 'full';
?>

<article>
    <div id="home_top_slider" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php if (have_rows('home_top_slider')) :
                $ctr = 0;
                while (have_rows('home_top_slider')) : the_row();
                    // vars
                    $image = get_sub_field('hm_background_image');
            ?>
                    <div class="carousel-item <?php echo $ctr == 0 ? "active" : ""; ?>">
                        <?php echo wp_get_attachment_image($image,$size); ?>
                    </div>
                    <?php
                    $ctr++;
                endwhile;
            else :

            // no rows found

            endif;
            ?>
        </div>
        <a class="carousel-control-prev" href="#home_top_slider" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#home_top_slider" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div id="home_top_slider_mobile" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php if (have_rows('home_top_slider_mobile')) :
                $ctr = 0;
                while (have_rows('home_top_slider_mobile')) : the_row();
                    // vars
                    $image = get_sub_field('hm_background_image');
            ?>
                    <div class="carousel-item <?php echo $ctr == 0 ? "active" : ""; ?>">
                        <?php echo wp_get_attachment_image($image,$size); ?>
                    </div>
                    <?php
                    $ctr++;
                endwhile;
            else :

            // no rows found

            endif;
            ?>
        </div>
        <a class="carousel-control-prev" href="#home_top_slider_mobile" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#home_top_slider_mobile" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</article>
<div id="searchbar-section" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container searchbar-group sbg-align">
                <div class="row sbg-row-inner">
                    <div class="col-lg-8 col-md-12 sbg-align">
                        <?php
                            $icon = get_field('search_bar_section_icon');
                            $searchbar_text = get_field('search_bar_section_text');
                            $searchbar_subtext = get_field('search_bar_section_subtext');
                        ?>
                        <div class="sb-icon">
                            <?php echo wp_get_attachment_image($icon,$size); ?>
                        </div>
                        <div class="search-bar-text-group">
                            <?php echo $searchbar_text ?>
                            <?php echo $searchbar_subtext ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-10 searchbar-margin">
                        <div class="sb-product-search">
                            <?php if ( 
                                function_exists( 'aws_get_search_form' ) ) { 
                                    aws_get_search_form( true, 
                                        array(  'id' => 1,
                                        ) 
                                    ); 
                                } 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="popular-accessories" class="margin-top-2">
    <div class="container section-headers">
        <div class="row">
            <div class="col-md-12">
                <center><p> Popular Accessories </p></center>
            </div>
            <?php if (have_rows('popular_accessories_section')) : 
                $ctr = 0;
                while (have_rows('popular_accessories_section')) : the_row();
                    // vars
                    
                    $pa_text = get_sub_field('accessory_category');
					
                    if( $pa_text ):
						$pa_image = get_field('category_images', 'category_'.$pa_text->term_id);
                    ?>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="category-group">
                                <a href="<?php echo get_term_link($pa_text->term_id); ?>"> 
                                    <h4><?php echo $pa_text->name; ?></h4>
                                    <div class="pa-image">
                                        <?php $size = 'medium'; ?>
                                        <?php echo wp_get_attachment_image($pa_image,$size); ?>
                                        <p>View All <?php echo $pa_text->name; ?></p>
                                    </div>
                                </a>
                                <div class="pa-category-search">
                                    <?php
                                    if (
                                        function_exists( 'aws_get_search_form' ) ) {
                                            set_query_var('taxonomy', $pa_text->term_id);
                                            aws_get_search_form( true, 
                                                array(  'id' => 2,
                                                        'data-tax'=>$pa_text->term_id,
                                                 ) 
                                             ); 
                                         } 
                                    ?>
                                </div>
                            </div>
                    </div>
                    <?php
                    endif;
                    $ctr++;
                endwhile;
                else :
                // no rows found
                endif;
            ?>
        </div>
    </div>
</div>

<div id="shop-by-carmake" class="container margin-top-2">
    <div class="section-headers">
        <div class="row">
            <div class="col-md-12 h-sec-header">
                <center><p> Shop By Car Make </p></center> 
            </div>
            <ul>
                <?php if (have_rows('shop_by_car_make')) : 
                    $ctr = 0;
                    while (have_rows('shop_by_car_make')) : the_row();
                        // vars
                        $sc_id = get_sub_field('car_make');
                ?>
                <li>
                    <div class="sc-logo-group">
                    <?php if( get_field('category_images', 'category_'.$sc_id) ): ?>
                        <div class="sc-col">
                            <a href="<?php echo get_category_link($sc_id); ?>">
                                <div class="sc-logo"> 
                                    <?php echo wp_get_attachment_image(get_field('category_images', 'category_'.$sc_id),$size); ?>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>

                <?php endif; 
                    $ctr++;
                    endwhile;
                    else :
                    // no rows found
                    endif;
                ?>
            </ul>
        </div>
    </div>
</div>
<div id="leading-brands" class="margin-top-2">
    <div class="container section-headers">
        <div class="row">
            <div class="col-md-12">
                <center><p> We Stock Leading Brands </p></center>
                <div class="lb-image-group">
                    <ul>
                        <?php if (have_rows('leading_brands_section')) : 
                            $ctr = 0;
                            while (have_rows('leading_brands_section')) : the_row();
                                // vars
                                $lb_id = get_sub_field('brand');
                                ?>
                                <li>
                                    <div class="lb-image-logos">
    									<!--<a href="<?php //echo get_category_link($lb_id); ?>">-->
                                        	<?php echo wp_get_attachment_image(get_field('category_images', 'category_'.$lb_id),$size); ?>
    									<!--</a>-->
                                    </div>
                                </li>
                                <?php
                                $ctr++;
                            endwhile;
                            else :
                            // no rows found
                            endif;
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="home-border" class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="hm-border"></div>
        </div>
    </div>
</div>

<div id="aboutus-section" class="container">
    <div class="row">
        <?php
            $aboutus_image = get_field('about_section_image');
            $aboutus_header_text = get_field('about_section_header');
            $aboutus_text = get_field('about_section_text');
        ?>

        <div class="col-lg-6 col-md-12">
            <div class="au-image" style="background-image: url(<?php echo $aboutus_image ?>);">
            </div>
        </div>
        <div class="col-lg-6 col-md-12 au-text-section">
            <h2><?php echo $aboutus_header_text?></h2>
            <div class="au-text"><?php echo $aboutus_text?></div>
            <a href="<?php bloginfo("url") . the_field('contact_link'); ?>" class="aboutus-button">Contact Us</a>
        </div>
    </div>
</div>
