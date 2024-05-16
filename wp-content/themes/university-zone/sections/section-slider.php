<?php
/**
* Banner Section
*/ 

$banner_control = get_theme_mod( 'university_zone_ed_slider_section', 'static_banner_cta' );
$banner_title   = get_theme_mod( 'university_zone_banner_title', __( 'Better Education for a Better World', 'university-zone' ) );
$link_label     = get_theme_mod( 'university_zone_banner_link_label', __( 'Apply Now', 'university-zone' ) );
$link_url       = get_theme_mod( 'university_zone_banner_link_url', '#' );
$class          = has_header_video() ? ' video-banner' : '';
$banner_post    = get_theme_mod( 'education_zone_banner_post' );
$read_more      = get_theme_mod( 'education_zone_banner_read_more', __( 'Read More', 'university-zone' ) );
if( 'post_banner' == $banner_control ){
    if( $banner_post ){
        $qry = new WP_Query( "p=$banner_post" );

        echo '<div class="banner-wrapper'. esc_attr( $class ).'">';

        if( $qry->have_posts() ){ 
            while( $qry->have_posts() ){   
                $qry->the_post();
                if( has_post_thumbnail() ){ 
                    the_post_thumbnail( 'education-zone-banner', array( 'itemprop' => 'image' ) ); ?>  
                    <div class="banner-text">
                        <div class="container">
                            <div class="text">
                                <?php if( $banner_title ){ ?>
                                    <h2 class="title"><?php echo esc_html( $banner_title ); ?></h2>
                                <?php } ?>
                                <?php if( $read_more ): ?>
                                    <div class="btn-holder">
                                        <a href="<?php the_permalink(); ?>" class="apply-now"><?php echo esc_html( $read_more ); ?></a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            wp_reset_postdata();
        }
        echo '</div><!-- .banner-wrapper -->';
    } 
} elseif( has_custom_header() && 'static_banner_cta' == $banner_control ){ 
                                                                              
    echo '<div class="banner-wrapper'. esc_attr( $class ).'">';

        the_custom_header_markup(); ?>                                                                
        <div class="banner-text">
            <div class="container">
                <div class="text">
                    <?php if ( $banner_title ) echo '<h2 class="title">'. esc_html( $banner_title ).'</h2>';
                    
                        if ( $link_label && $link_url ) {
                            ?>
                            <div class="btn-holder">
                                <?php
                                    if ( $link_label && $link_url ) echo  '<a href="'. esc_url( $link_url ) .'" class="apply-now">'. esc_html( $link_label ) .'</a>'; 
                                ?>
                            </div>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </div>
    </div><!-- .banner-wrapper -->
<?php
}