<?php
/**
 * Courses Section
*/
 
$section_title = get_theme_mod( 'education_zone_courses_section_title' );
$post_one      = get_theme_mod( 'education_zone_featured_courses_post_one' );
$post_two      = get_theme_mod( 'education_zone_featured_courses_post_two' );
$post_three    = get_theme_mod( 'education_zone_featured_courses_post_three' );
$post_four     = get_theme_mod( 'education_zone_featured_courses_post_four' );
$post_five     = get_theme_mod( 'university_zone_featured_courses_post_five' );
$post_six      = get_theme_mod( 'university_zone_featured_courses_post_six' );
$course_posts  = array( $post_one, $post_two, $post_three, $post_four, $post_five, $post_six );
$course_posts  = array_diff( array_unique( $course_posts ), array('') );

$args = array(
        'post__in'   => $course_posts,
        'orderby'   => 'post__in',
        'tax_query' => array(
			array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-gallery' ),
			'operator' => 'NOT IN',
			)),
        );

$qry = new WP_Query( $args );
?>
<div class="container">
	<?php education_zone_get_section_header( $section_title );
	
    if( $course_posts && $qry->have_posts() ){ ?>
        <ul>
        <?php           
            while( $qry->have_posts() ){ 
                $qry->the_post(); ?>
                <li>
        			<div class="image-holder">
                        <a href="<?php the_permalink(); ?>">
                            <?php 
                            if( has_post_thumbnail() ){
                                the_post_thumbnail( 'university-zone-featured-course', array( 'itemprop' => 'image' ) );
                            }else{ 
                                education_zone_get_fallback_svg( 'university-zone-featured-course' );
                            } ?>
                        </a>
        				<div class="description">
        					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        					<?php the_excerpt(); ?>
        					<a class="btn-readmore" href="<?php the_permalink(); ?>"><?php echo esc_html__( 'Read More', 'university-zone' ); ?></a>
        				</div>
        			</div>

                </li>
		<?php } 
            wp_reset_postdata();
        ?>
        </ul>
    <?php } ?>
</div>