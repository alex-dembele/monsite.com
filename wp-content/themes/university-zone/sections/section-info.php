<?php
/**
 * Info Section
*/
?>

<div class="container">
    <div class="thumb-text">
    <?php
        $post_one   = get_theme_mod( 'education_zone_info_one_post' ); 
        $post_two   = get_theme_mod( 'education_zone_info_second_post' ); 
        $post_three = get_theme_mod( 'education_zone_info_third_post' ); 
        $post_four  = get_theme_mod( 'education_zone_info_fourth_post' ); 
        $info_posts = array( $post_one, $post_two, $post_three, $post_four );
        $info_posts = array_diff( array_unique( $info_posts ), array('') );
               
        $args = array(
            'post__in'            => $info_posts,
            'orderby'             => 'post__in',
            'ignore_sticky_posts' => true
        );
        
        $info_qry = new WP_Query( $args );
        
        if( $info_posts && $info_qry->have_posts() ){ 
            $i = 1;
            while( $info_qry->have_posts() ){ 
                $info_qry->the_post(); ?>
                    <li>
                        <div class="box-<?php echo esc_attr( $i );?> box">
                            <div class="image-holder">
                                <span>
                                    <?php 
                                    if( has_post_thumbnail() ){ 
                                        the_post_thumbnail( 'university-zone-info-thumb', array( 'itemprop' => 'image' ) ); 
                                    }else{
                                        education_zone_get_fallback_svg( 'university-zone-info-thumb' );
                                    } ?>
                                </span>
                            </div>
                            <div class="caption-holder">
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <?php the_excerpt(); ?>
                                <a class="apply-now" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Apply Now','university-zone' ) ?></a>
                            </div>
                        </div>  
                    </li> 
                <?php 
                    $i++; 
                }
                wp_reset_postdata();
            }
        ?>
    </div>
</div>
