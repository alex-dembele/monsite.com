<?php
/*
Added new Child Theme functions from here.
*/
function university_zone_primary_nav(){ 
	?>
	 <nav id="site-navigation" class="main-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">                        
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
    </nav><!-- #site-navigation -->
	<?php
}


function university_zone_secondary_nav(){
	if( has_nav_menu( 'secondary' ) ){ ?>
        <nav class="secondary-navigation" role="navigation"> 
            <?php wp_nav_menu( array( 'theme_location' => 'secondary', 'menu_id' => 'secondary-menu', 'fallback_cb' => false ) ); ?>
        </nav><!-- #site-navigation -->
    <?php
	}
}

function university_zone_get_sections(){
    $sections = array(
        'slider-section' => array(
           'id'    => 'slider',
           'class' => 'banner'
        ),
        'info-section' => array(
           'id'    => 'info',
           'class' => 'information'
        ),
         'welcome-section' => array(
          'id'    => 'welcome',
          'class' => 'welcome-note'
        ),
         'courses-section' => array(
          'id'    => 'courses',
          'class' => 'featured-courses'
        ),
         'extra-info-section' => array(
          'id'    => 'extra_info',
          'class' => 'theme'
        ),
        'choose-section' => array(
          'id'    => 'choose',
          'class' => 'choose-us'
        ),
        'testimonial-section' => array(
          'id'    => 'testimonials',
          'class' => 'student-stories'
        ),
        'blog-section' => array(
          'id'    => 'blog',
          'class' => 'latest-events'
        ),
        'gallery-section'=> array(
          'id'    => 'gallery',
          'class' => 'photos-gallery'
        ),
        'search-section' => array(
          'id'    => 'search',
          'class' => 'search-section'
        ),
    );

    $enabled_section = array();

    if ( get_theme_mod( 'university_zone_ed_slider_section' ) != 'no_banner' ){
            $enabled_section[] = array(
                'id'    => 'slider',
                'class' => 'banner'
            );
    }

    foreach ( $sections as $section ) {
        if ( get_theme_mod( 'education_zone_ed_' . $section['id'] . '_section' ) == 1 ){
            $enabled_section[] = array(
                'id'    => $section['id'],
                'class' => $section['class']
            );
        }
    }
    return $enabled_section;
}

function university_zone_customizer_register_cta_header( $wp_customize ){

    $wp_customize->get_section( 'education_zone_top_header_settings' )->title  = __( 'Header Settings', 'university-zone' );
    $wp_customize->remove_setting( 'education_zone_top_menu_label' );
    $wp_customize->remove_control( 'education_zone_top_menu_label' );

    /** Note */
    $wp_customize->add_setting(
        'cta_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new University_Zone_Note_Control( 
            $wp_customize,
            'cta_note_text',
            array(
                'section'     => 'education_zone_top_header_settings',
                'description' => sprintf( __( '%s You can edit the Button with below settings.', 'university-zone' ), '<hr/>' ),
            )
        )
    );

    /** CTA label */
    $wp_customize->add_setting(
        'university_zone_cta_label',
        array(
            'default'           => __( 'Apply Now','university-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );

     // Selective referesh for header address
    $wp_customize->selective_refresh->add_partial( 'university_zone_cta_label', array(
        'selector'        => '.header-info .btn-cta a',
        'render_callback' => 'university_zone_cta_label',
    ) );

    $wp_customize->add_control(
        'university_zone_cta_label',
        array(
            'label'   => __( 'CTA Label', 'university-zone' ),
            'section' => 'education_zone_top_header_settings',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'university_zone_cta_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'university_zone_cta_url',
        array(
            'label'   => __( 'CTA URL', 'university-zone' ),
            'section' => 'education_zone_top_header_settings',
            'type'    => 'text',
        )
    );

    $wp_customize->add_setting(
        'university_zone_ed_cta_newtab',
        array(
            'default'           => '',
            'sanitize_callback' => 'education_zone_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'university_zone_ed_cta_newtab',
        array(
            'label'   => __( 'Open In New Tab', 'university-zone' ),
            'section' => 'education_zone_top_header_settings',
            'type'    => 'checkbox',
        )
    );

     /** Note */
    $wp_customize->add_setting(
        'search_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new University_Zone_Note_Control( 
            $wp_customize,
            'search_note_text',
            array(
                'section'     => 'education_zone_top_header_settings',
                'description' => sprintf( __( '%s You can edit the Header Search Settings from here', 'university-zone' ), '<hr/>' ),
            )
        )
    );

     $wp_customize->add_setting(
        'university_zone_ed_search_form',
        array(
            'default'           => '',
            'sanitize_callback' => 'education_zone_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        'university_zone_ed_search_form',
        array(
            'label'   => __( 'Enable Search Form', 'university-zone' ),
            'section' => 'education_zone_top_header_settings',
            'type'    => 'checkbox',
        )
    );
}
add_action( 'customize_register','university_zone_customizer_register_cta_header',11 );

function university_zone_banner_section( $wp_customize ){

    $wp_customize->remove_setting( 'education_zone_ed_slider_section' );
    $wp_customize->remove_control( 'education_zone_ed_slider_section' );

    // Move default section
    $wp_customize->get_section( 'header_image' )->panel    = 'education_zone_home_page_settings';
    $wp_customize->get_section( 'header_image' )->title    = __( 'Banner Section', 'university-zone' );
    $wp_customize->get_section( 'header_image' )->priority = 10;
    $wp_customize->get_control( 'header_image' )->active_callback = 'university_zone_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback = 'university_zone_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'university_zone_banner_ac';
    $wp_customize->get_section( 'header_image' )->description = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport = 'refresh';

    $wp_customize->get_control( 'education_zone_banner_post' )->section = 'header_image';
    $wp_customize->get_control( 'education_zone_banner_read_more' )->section = 'header_image';
    $wp_customize->get_control( 'education_zone_banner_post' )->active_callback = 'university_zone_banner_ac';
    $wp_customize->get_control( 'education_zone_banner_read_more' )->active_callback = 'university_zone_banner_ac';

    /** Banner Options */
    $wp_customize->add_setting(
        'university_zone_ed_slider_section',
        array(
            'default'           => 'static_banner_cta',
            'sanitize_callback' => 'education_zone_sanitize_select'
        )
    );

    $wp_customize->add_control(
        'university_zone_ed_slider_section',
        array(
            'label'       => __( 'Banner Options', 'university-zone' ),
            'description' => __( 'Choose banner as static image/video.', 'university-zone' ),
            'section'     => 'header_image',
            'choices'     => array(
                'no_banner'         => __( 'Disable Banner Section', 'university-zone' ),
                'static_banner_cta' => __( 'Static/Video CTA Banner', 'university-zone' ),
                'post_banner'       => __( 'Post Banner', 'university-zone' ),
            ),
            'priority'    => 5,
            'type'        => 'select'
        )            
    );

    /** Banner title */
    $wp_customize->add_setting(
        'university_zone_banner_title',
        array(
            'default'           => __( 'Better Education for a Better World', 'university-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'university_zone_banner_title', array(
        'selector'        => '.banner .banner-text .title',
        'render_callback' => 'university_zone_banner_title',
    ) );

    $wp_customize->add_control(
        'university_zone_banner_title',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Banner Title', 'university-zone' ),
            'active_callback' => 'university_zone_banner_ac'
        )
    );

    /** Banner link one label */
    $wp_customize->add_setting(
        'university_zone_banner_link_label',
        array(
            'default'           => __( 'Apply Now', 'university-zone' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'university_zone_banner_link_label',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Link Label', 'university-zone' ),
            'active_callback' => 'university_zone_banner_ac'
        )
    );

     /** Banner link one url */
    $wp_customize->add_setting(
        'university_zone_banner_link_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'university_zone_banner_link_url',
        array(
            'section'         => 'header_image',
            'label'           => __( 'Link Url', 'university-zone' ),
            'type'            => 'url',
            'active_callback' => 'university_zone_banner_ac'
        )
    );
}
add_action( 'customize_register','university_zone_banner_section',11 );

function university_zone_featured_courses_section( $wp_customize ){

    /** Featured Course Post Fourth */
    $wp_customize->add_setting(
        'university_zone_featured_courses_post_five',
        array(
            'default' => '',
            'sanitize_callback' => 'education_zone_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'university_zone_featured_courses_post_five',
        array(
            'label'   => __( 'Featured Course Post Five', 'university-zone' ),
            'section' => 'education_zone_featured_courses_section_settings',
            'type'    => 'select',
            'choices' => university_zone_get_posts('post'),
    ));

     $wp_customize->add_setting(
        'university_zone_featured_courses_post_six',
        array(
            'default' => '',
            'sanitize_callback' => 'education_zone_sanitize_select',
        ));
    
    $wp_customize->add_control(
        'university_zone_featured_courses_post_six',
        array(
            'label'   => __( 'Featured Course Post Six', 'university-zone' ),
            'section' => 'education_zone_featured_courses_section_settings',
            'type'    => 'select',
            'choices' => university_zone_get_posts('post'),
    ));
}
add_action( 'customize_register','university_zone_featured_courses_section',11 );

/**
 * Active Callback
 */
function university_zone_banner_ac( $control ){
    $banner      = $control->manager->get_setting( 'university_zone_ed_slider_section' )->value();
    $control_id  = $control->id;
    
    // static banner controls
    if ( $control_id == 'header_image' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'header_video' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'external_header_video' && $banner == 'static_banner_cta' ) return true;

    // banner title and description controls
    if ( $control_id == 'university_zone_banner_title' && $banner == 'static_banner_cta' ) return true;

    // Link button controls
    if ( $control_id == 'university_zone_banner_link_label' && $banner == 'static_banner_cta' ) return true;
    if ( $control_id == 'university_zone_banner_link_url' && $banner == 'static_banner_cta' ) return true;

    // Post banner controls
    if ( $control_id == 'education_zone_banner_post' && $banner == 'post_banner' ) return true;
    if ( $control_id == 'education_zone_banner_read_more' && $banner == 'post_banner' ) return true;

    return false;
}


function university_zone_get_posts( $post_type = 'post', $slug = false ){    
    $args = array(
    	'posts_per_page'   => -1,
    	'post_type'        => $post_type,
    	'post_status'      => 'publish',
    	'suppress_filters' => true 
    );
    $posts_array = get_posts( $args );
    
    // Initiate an empty array
    $post_options = array();
    $post_options[''] = __( ' -- Choose -- ', 'university-zone' );
    if ( ! empty( $posts_array ) ) {
        foreach ( $posts_array as $posts ) {
            if( $slug ){
                $post_options[ $posts->post_title ] = $posts->post_title;
            }else{
                $post_options[ $posts->ID ] = $posts->post_title;    
            }
        }
    }
    return $post_options;
    wp_reset_postdata();
}

/**
 * Partial refresh functions for headers
 */
function university_zone_cta_label(){
    return esc_html( get_theme_mod( 'university_zone_cta_label',__( 'Apply Now','university-zone' ) ) );
}

function university_zone_banner_title(){
    return esc_html( get_theme_mod( 'university_zone_banner_title',__( 'Better Education for a Better World','university-zone' ) ) );
}

/**
 * Register Note Controls
*/
function university_zone_register_note_controls( $wp_customize ){    
    // Exit if accessed directly.
    if ( ! defined( 'ABSPATH' ) ) {
      exit;
    }

    if( ! class_exists( 'University_Zone_Note_Control' ) ){

      class University_Zone_Note_Control extends WP_Customize_Control {
        
        public function render_content(){ ?>
              <span class="customize-control-title">
              <?php echo esc_html( $this->label ); ?>
            </span>
        
            <?php if( $this->description ){ ?>
              <span class="description customize-control-description">
              <?php echo wp_kses_post( $this->description ); ?>
              </span>
            <?php }
            }
      }
    }
}
add_action( 'customize_register', 'university_zone_register_note_controls' );