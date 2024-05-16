<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Business School
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ( function_exists( 'wp_body_open' ) ) {
  wp_body_open();
} else {
  do_action( 'wp_body_open' );
} ?>

<?php if ( get_theme_mod('business_school_preloader',true) != "") { ?>
  <div id="preloader">
    <div id="status">&nbsp;</div>
  </div>
<?php } ?>

<a class="screen-reader-text skip-link" href="#content"><?php esc_html_e( 'Skip to content', 'business-school' ); ?></a>

  <?php if ( get_theme_mod('business_school_top_bar', false) != "") { ?>
    <div class="contact-box py-2">
      <div class="container">
        <div class="row">
          <div class="col-lg-2">
          </div>
          <div class="col-lg-6 col-md-7 p-0 align-self-center text-center">
            <div class="info-box text-md-center py-1">
              <?php if ( get_theme_mod('business_school_email_address') != "") { ?>
                <a class="mail py-md-0 py-2" href="mailto:<?php echo esc_attr( get_theme_mod('business_school_email_address','') ); ?>"><i class="far fa-envelope"></i><?php echo esc_html(get_theme_mod ('business_school_email_address','')); ?></a>
              <?php } ?>
              <?php if ( get_theme_mod('business_school_phone_number') != "") { ?>
                <a class="phn ms-md-4 py-md-0 py-2" href="tel:<?php echo esc_url( get_theme_mod('business_school_phone_number','' )); ?>"><i class="fas fa-phone"></i><?php echo esc_html(get_theme_mod ('business_school_phone_number','')); ?></a>
              <?php } ?>
            </div>
          </div>
          <div class="col-lg-3 col-md-5 align-self-center text-center text-md-end">
            <span class="social-icons me-md-1 me-3">
              <?php if ( get_theme_mod('business_school_fb_link') != "") { ?>
                <a title="<?php echo esc_attr('facebook', 'business-school'); ?>" target="_blank" href="<?php echo esc_url(get_theme_mod('business_school_fb_link')); ?>"><i class="fab fa-facebook-f"></i></a> 
              <?php } ?>
              <?php if ( get_theme_mod('business_school_insta_link') != "") { ?> 
                <a title="<?php echo esc_attr('instagram', 'business-school'); ?>" target="_blank" href="<?php echo esc_url(get_theme_mod('business_school_insta_link')); ?>"><i class="fab fa-instagram"></i></a>
              <?php } ?>
              <?php if ( get_theme_mod('business_school_googleplus_link') != "") { ?>
                <a title="<?php echo esc_attr('google plus', 'business-school'); ?>" target="_blank" href="<?php echo esc_url(get_theme_mod('business_school_googleplus_link')); ?>"><i class="fab fa-google-plus-g"></i></a>
              <?php } ?>
              <?php if ( get_theme_mod('business_school_youtube_link') != "") { ?> 
                <a title="<?php echo esc_attr('youtube', 'business-school'); ?>" target="_blank" href="<?php echo esc_url(get_theme_mod('business_school_youtube_link')); ?>"><i class="fab fa-youtube"></i></a>
              <?php } ?>
            </span>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>

  <div class="mainhead <?php echo esc_attr(business_school_sticky_menu()); ?>">
    <div class="header-top">
      <div class="row m-0">
        <div class="col-lg-3 col-md-3 col-12 px-0 logo-col">
          <div class="logo py-2">
            <?php business_school_the_custom_logo(); ?>
            <div class="site-branding-text">
              <?php if ( get_theme_mod('business_school_title_enable',true) != "") { ?>
                <?php if ( is_front_page() && is_home() ) : ?>
                  <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
                <?php else : ?>
                  <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
                <?php endif; ?>
              <?php } ?>
              <?php $business_school_description = get_bloginfo( 'description', 'display' );
              if ( $business_school_description || is_customize_preview() ) : ?>
                <?php if ( get_theme_mod('business_school_tagline_enable',false) != "") { ?>
                <span class="site-description"><?php echo esc_html( $business_school_description ); ?></span>
                <?php } ?>
              <?php endif; ?>
            </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-12 p-0 menubox">
          <div class="row m-0 menuitem">
            <div class="col-lg-7 col-md-3 col-12 align-self-center">
              <div class="toggle-nav my-md-0 mb-4 mobile-stick text-center">
                  <button role="tab"><?php esc_html_e('Menu','business-school'); ?></button>
              </div>
              <div id="mySidenav" class="nav sidenav">
                <nav id="site-navigation" class="main-nav" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu','business-school' ); ?>">
                  <ul class="mobile_nav">
                    <?php
                      wp_nav_menu( array( 
                        'theme_location' => 'primary',
                        'container_class' => 'main-menu' ,
                        'items_wrap' => '%3$s',
                        'fallback_cb' => 'wp_page_menu',
                      ) ); 
                     ?>
                  </ul>
                  <a href="javascript:void(0)" class="close-button"><?php esc_html_e('CLOSE','business-school'); ?></a>
                </nav>
              </div>
            </div>
            <div class="col-lg-5 col-md-9 col-12 align-self-center text-center">
              <span class="search-box text-center">
                <?php if(get_theme_mod('business_school_search_option',true) != ''){ ?>
                  <button type="button" class="search-open"><i class="fas fa-search"></i></button>
                <?php }?>
              </span>
              <?php if ( get_theme_mod('business_school_contact_us_text', 'Contact Us') != "" && get_theme_mod('business_school_contact_us_url') != "") { ?> 
                <span class="contact-us text-center ms-4">
                  <a href="<?php echo esc_url(get_theme_mod ('business_school_contact_us_url','')); ?>"><?php echo esc_html(get_theme_mod ('business_school_contact_us_text','Contact Us','business-school')); ?></a>
                </span>
              <?php }?>
            </div>
          </div>
        </div>
        <div class="search-outer">
          <div class="serach_inner w-100 h-100">
            <?php get_search_form(); ?>
          </div>
          <button type="button" class="search-close"><?php esc_html_e('X', 'business-school'); ?></button>
        </div>
      </div>
    </div>
  </div>
