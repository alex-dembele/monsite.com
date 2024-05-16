<?php
/*
All Pluggable functions from the Parent Theme are overridden in University Zone via parent-functions.php
*/

/*
Parent Theme Function for site header
*/
function education_zone_site_header(){
    $phone          = get_theme_mod( 'education_zone_phone' );
    $email          = get_theme_mod( 'education_zone_email' );
    $ed_social_link = get_theme_mod( 'education_zone_ed_social');
    $cta_label      = get_theme_mod( 'university_zone_cta_label', __( 'Apply Now', 'university-zone' ) );
    $cta_links      = get_theme_mod( 'university_zone_cta_url' );
    $cta_newtab     = get_theme_mod( 'university_zone_ed_cta_newtab' );
    $ed_search_form = get_theme_mod( 'university_zone_ed_search_form' );
    ?>
    <header id="masthead" class="site-header header-two" role="banner" itemscope itemtype="https://schema.org/WPHeader">
    <div class="header-holder">
        <?php 
        if( has_nav_menu( 'secondary' ) || $ed_social_link ){ ?>
            <div class="header-top">
                <div class="container">
                    <div class="top-links">
                        <?php university_zone_secondary_nav(); ?>
                    </div>
                    <?php if( $ed_social_link ) do_action( 'education_zone_social' ); ?>
                </div>
            </div>
        <?php 
        } ?>
        <div class="header-m">
            <div class="container">
                 <div class="site-branding" itemscope itemtype="https://schema.org/Organization">
                        <?php 
                            if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                                the_custom_logo();
                            } 
                        ?>
                        <div class="text-logo">
                        <?php if ( is_front_page() ) : ?>
                            <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                        <?php else : ?>
                            <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                        <?php endif;
                           $description = get_bloginfo( 'description', 'display' );
                           if ( $description || is_customize_preview() ) : ?>
                               <p class="site-description" itemprop="description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                        <?php
                           endif; 
                        ?>           
                        </div>         
                   </div><!-- .site-branding -->

                     <?php if( $email || $phone || ( $cta_label && $cta_links ) ){ ?>
                        <div class="header-info">
                            <?php if( $email || $phone ){
                                if( $phone ){ ?>
                                   <div class="phone">
                                       <span class="label"><?php esc_html_e( 'Phone Number','university-zone' ); ?></span>
                                       <a href="<?php echo esc_url( 'tel:'. preg_replace('/[^\d+]/', '', $phone ) ); ?>" class="tel-link"><?php echo esc_html( $phone ); ?></a>
                                   </div>
                                <?php } if( $email ){ ?>   
                               <div class="email">
                                   <span class="label"><?php esc_html_e( 'E-Mail','university-zone' ); ?></span>
                                   <a href="<?php echo esc_url( 'mailto:'. $email ); ?>"><?php echo esc_html( $email ); ?></a>
                               </div>
                               <?php } } if( $cta_label && $cta_links ){ ?>
                               <div class="btn-cta">
                                   <a href="<?php echo esc_url( $cta_links ); ?>" <?php if( $cta_newtab ) echo 'target="_blank"'; ?>><?php echo esc_html( $cta_label ); ?></a>
                               </div>
                            <?php } ?>
                        </div>
                    <?php } 
                ?>
            </div>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <?php 
            university_zone_primary_nav();
            
            if( $ed_search_form ){ ?>
                <div class="form-section">
                    <button href="javascript:void(0)" id="search-btn"data-toggle-target=".header-search-modal" data-toggle-body-class="showing-search-modal" aria-expanded="false" data-set-focus=".header-search-modal .search-field"><i class="fa fa-search" aria-hidden="true"></i></button>
                    <div class="example header-searh-wrap header-search-modal cover-modal" data-modal-target-string=".header-search-modal">                       
                        <?php get_search_form(); ?>
                        <button class="btn-form-close" data-toggle-target=".header-search-modal" data-toggle-body-class="showing-search-modal" aria-expanded="false" data-set-focus=".header-search-modal">  </button>
                    </div>
                </div>
             <?php 
            } ?>
        </div>
    </div>
</header>
<?php
}
/*
Parent Theme Function for Mobile header
*/
function education_zone_mobile_header(){
    $phone          = get_theme_mod( 'education_zone_phone' );
    $email          = get_theme_mod( 'education_zone_email' );
    $cta_label      = get_theme_mod( 'university_zone_cta_label', __( 'Apply Now', 'university-zone' ) );
    $cta_links      = get_theme_mod( 'university_zone_cta_url' );
    $cta_newtab     = get_theme_mod( 'university_zone_ed_cta_newtab' );
    $ed_social_link = get_theme_mod( 'education_zone_ed_social');
    ?>
    <div class="mobile-header">
            <div class="container">
                <button class="menu-opener" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button> <!-- menu-opener ends -->

                <div class="site-branding">
                    <?php 
                        if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                            echo '<div class="img-logo">';
                            the_custom_logo();
                            echo '</div><!-- .img-logo -->';
                        } 
                    ?>
                    <div class="text-logo">
                    <?php
                        $site_title =  get_bloginfo( 'name', 'display' );
                        $description = get_bloginfo( 'description', 'display' );

                        if( $site_title ) : ?>
                            <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
                        <?php
                        endif;
                    
                       if ( $description ) : ?>
                           <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
                        <?php
                       endif; 
                    ?>
                    </div>
                </div> <!-- site-branding ends -->
            </div> <!-- container ends -->

            <div class="mobile-menu">
                <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">
                    <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                        <button class="btn-close-menu close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
                        <?php get_search_form(); ?> 
                        <div class="mobile-menu-title" aria-label="<?php esc_attr_e( 'Mobile', 'university-zone' ); ?>">
                            <?php
                                wp_nav_menu( array(
                                    'theme_location' => 'primary',
                                    'menu_id'        => 'mobile-primary-menu',
                                    'menu_class'     => 'nav-menu main-menu-modal',
                                ) );
                            ?>
                        </div>
                        <?php if( has_nav_menu( 'secondary' ) ){ 
                            wp_nav_menu( array( 'theme_location' => 'secondary', 'container' => false, 'menu_id' => 'mobile-secondary-menu', 'fallback_cb' => false ) );
                        } 
                        
                        if( $email || $phone ){ ?>
                           <div class="contact-info">
                            <?php 
                                if( $phone ) echo '<a href="'. esc_url( 'tel:'. preg_replace('/[^\d+]/', '', $phone) ) .'" class="tel-link">'. esc_html( $phone ) .'</a>';
                                if( $email ) echo '<a href="'. esc_url( 'mailto:'. $email ) .'" class="email-link">'. esc_html( $email ) .'</a>';
                            ?>
                            </div> <!-- contact-info ends -->
                        <?php } 
                        if( $ed_social_link ) do_action( 'education_zone_social' );
                        if( $cta_label && $cta_links ){ ?>
                            <div class="btn-cta">
                                <a href="<?php echo esc_url( $cta_links ); ?>" <?php if( $cta_newtab ) echo 'target="_blank"'; ?>><?php echo esc_html( $cta_label ); ?></a>
                            </div>
                        <?php } ?>
                    </div>
                </nav><!-- #mobile-site-navigation -->
            </div>
        </div> <!-- mobile-header ends -->
    <?php
}
/*
University Zone Social Icons
*/
function education_zone_social_cb(){
    
    $facebook  = get_theme_mod( 'education_zone_facebook' );
    $twitter   = get_theme_mod( 'education_zone_twitter' );
    $pinterest = get_theme_mod( 'education_zone_pinterest' );
    $linkedin  = get_theme_mod( 'education_zone_linkedin' );
    $instagram = get_theme_mod( 'education_zone_instagram' );
    $youtube   = get_theme_mod( 'education_zone_youtube' );
    $ok        = get_theme_mod( 'education_zone_ok' );
    $vk        = get_theme_mod( 'education_zone_vk' );
    $xing      = get_theme_mod( 'education_zone_xing' );
    
    if( $facebook || $twitter || $pinterest || $linkedin || $instagram || $youtube || $ok || $vk || $xing ){
    
    ?>
    <ul class="social-networks">
        <?php if( $facebook ){ ?>
        <li><a href="<?php echo esc_url( $facebook ); ?>" target="_blank" title="<?php esc_attr_e( 'Facebook', 'university-zone' );?>"><i class="fa fa-facebook"></i></a></li>
        <?php } if( $twitter ){ ?>
        <li><a href="<?php echo esc_url( $twitter ); ?>" target="_blank" title="<?php esc_attr_e( 'Twitter', 'university-zone' );?>"><i class="fa fa-twitter"></i></a></li>
        <?php } if( $pinterest ){ ?>
        <li><a href="<?php echo esc_url( $pinterest ); ?>" target="_blank" title="<?php esc_attr_e( 'Pinterest', 'university-zone' );?>"><i class="fa fa-pinterest"></i></a></li>
        <?php } if( $linkedin ){ ?>
        <li><a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" title="<?php esc_attr_e( 'LinkedIn', 'university-zone' );?>"><i class="fa fa-linkedin"></i></a></li>
        <?php } if( $instagram ){ ?>
        <li><a href="<?php echo esc_url( $instagram ); ?>" target="_blank" title="<?php esc_attr_e( 'Instagram', 'university-zone' );?>"><i class="fa fa-instagram"></i></a></li>
        <?php } if( $youtube ){ ?>
        <li><a href="<?php echo esc_url( $youtube ); ?>" target="_blank" title="<?php esc_attr_e( 'YouTube', 'university-zone' );?>"><i class="fa fa-youtube"></i></a></li>
        <?php } if( $ok ){ ?>
        <li><a href="<?php echo esc_url( $ok ); ?>" target="_blank" title="<?php esc_attr_e( 'OK', 'university-zone' );?>"><i class="fa fa-odnoklassniki"></i></a></li>
        <?php } if( $vk ){ ?>
        <li><a href="<?php echo esc_url( $vk ); ?>" target="_blank" title="<?php esc_attr_e( 'VK', 'university-zone' );?>"><i class="fa fa-vk"></i></a></li>
        <?php } if( $xing ){ ?>
        <li><a href="<?php echo esc_url( $xing ); ?>" target="_blank" title="<?php esc_attr_e( 'Xing', 'university-zone' ); ?>"><i class="fa fa-xing"></i></a></li>
        <?php } ?>
    </ul>
    <?php
    }    
}
/*
University Zone Theme Info
*/
function education_zone_customizer_theme_info( $wp_customize ) {
    
    $wp_customize->add_section( 'theme_info' , array(
        'title'       => __( 'Demo and Documentation' , 'university-zone' ),
        'priority'    => 6,
        ));

    $wp_customize->add_setting('theme_info_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
        ));
    
    $theme_info = '';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme Documentation', 'university-zone' ) . ': </label><a href="' . esc_url( 'https://docs.rarathemes.com/docs/university-zone/' ) . '" target="_blank">' . __( 'Click here', 'university-zone' ) . '</a></span><br />';
    
    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme Demo', 'university-zone' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/previews/?theme=university-zone' ) . '" target="_blank">' . __( 'Click here', 'university-zone' ) . '</a></span><br />';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Theme info', 'university-zone' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/university-zone/' ) . '" target="_blank">' . __( 'Click here', 'university-zone' ) . '</a></span><br />';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'Support Ticket', 'university-zone' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/support-ticket/' ) . '" target="_blank">' . __( 'Click here', 'university-zone' ) . '</a></span><br />';

    $theme_info .= '<span class="sticky_info_row"><label class="row-element">' . __( 'More WordPress Themes', 'university-zone' ) . ': </label><a href="' . esc_url( 'https://rarathemes.com/wordpress-themes/' ) . '" target="_blank">' . __( 'Click here', 'university-zone' ) . '</a></span><br />';

    $wp_customize->add_control( new education_zone_Theme_Info( $wp_customize ,'theme_info_theme',array(
        'label' => __( 'About University Zone' , 'university-zone' ),
        'section' => 'theme_info',
        'description' => $theme_info
        )));

    $wp_customize->add_setting('theme_info_more_theme',array(
        'default' => '',
        'sanitize_callback' => 'wp_kses_post',
    ));
}
