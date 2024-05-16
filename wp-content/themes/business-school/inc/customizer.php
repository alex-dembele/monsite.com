<?php
/**
 * Business School Theme Customizer
 *
 * @package Business School
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function business_school_customize_register( $wp_customize ) {

	function business_school_sanitize_dropdown_pages( $page_id, $setting ) {
  		$page_id = absint( $page_id );
  		return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	wp_enqueue_style('business-school-customize-controls', trailingslashit(esc_url(get_template_directory_uri())).'/css/customize-controls.css');

	//Logo
    $wp_customize->add_setting('business_school_logo_width',array(
		'default'=> '',
		'transport' => 'refresh',
		'sanitize_callback' => 'business_school_sanitize_integer'
	));
	$wp_customize->add_control(new Business_School_Slider_Custom_Control( $wp_customize, 'business_school_logo_width',array(
		'label'	=> esc_html__('Logo Width','business-school'),
		'section'=> 'title_tagline',
		'settings'=>'business_school_logo_width',
		'input_attrs' => array(
            'step'             => 1,
			'min'              => 0,
			'max'              => 100,
        ),
	)));

	// color site title
	$wp_customize->add_setting('business_school_sitetitle_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));

	$wp_customize->add_control( 'business_school_sitetitle_color', array(
	   'settings' => 'business_school_sitetitle_color',
	   'section'   => 'title_tagline',
	   'label' => __('Site Title Color', 'business-school'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('business_school_title_enable',array(
		'default' => true,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
	));
	$wp_customize->add_control( 'business_school_title_enable', array(
	   'settings' => 'business_school_title_enable',
	   'section'   => 'title_tagline',
	   'label'     => __('Enable Site Title','business-school'),
	   'type'      => 'checkbox'
	));

	// color site tagline
	$wp_customize->add_setting('business_school_sitetagline_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_sitetagline_color', array(
	   'settings' => 'business_school_sitetagline_color',
	   'section'   => 'title_tagline',
	   'label' => __('Site Tagline Color', 'business-school'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('business_school_tagline_enable',array(
		'default' => false,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
	));
	$wp_customize->add_control( 'business_school_tagline_enable', array(
	   'settings' => 'business_school_tagline_enable',
	   'section'   => 'title_tagline',
	   'label'     => __('Enable Site Tagline','business-school'),
	   'type'      => 'checkbox'
	));

	//Theme Options
	$wp_customize->add_panel( 'business_school_panel_area', array(
		'priority' => 10,
		'capability' => 'edit_theme_options',
		'title' => __( 'Theme Options Panel', 'business-school' ),
	) );

 	// Header Section
	$wp_customize->add_section('business_school_header_section', array(
        'title' => __('Manage Header Section', 'business-school'),
		'description' => __('<p class="sec-title">Manage Header Section</p>','business-school'),
        'priority' => null,
		'panel' => 'business_school_panel_area',
 	));

 	$wp_customize->add_setting('business_school_top_bar',array(
		'default' => false,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
	));	 
	$wp_customize->add_control( 'business_school_top_bar', array(
	   'section'   => 'business_school_header_section',
	   'label'	=> __('Check to show Top Bar','business-school'),
	   'type'      => 'checkbox'
 	)); 

 	$wp_customize->add_setting('business_school_stickyheader',array(
		'default' => false,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
	));
	$wp_customize->add_control( 'business_school_stickyheader', array(
	   'section'   => 'business_school_header_section',
	   'label'	=> __('Check To Show Sticky Header','business-school'),
	   'type'      => 'checkbox'
 	));

	$wp_customize->add_setting('business_school_preloader',array(
		'default' => true,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
	));
	$wp_customize->add_control( 'business_school_preloader', array(
	   'section'   => 'business_school_header_section',
	   'label'	=> __('Check to Show preloader','business-school'),
	   'type'      => 'checkbox'
 	));

 	$wp_customize->add_setting('business_school_phone_number',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_phone_number',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_phone_number', array(
	   'settings' => 'business_school_phone_number',
	   'section'   => 'business_school_header_section',
	   'label' => __('Add Phone Number', 'business-school'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('business_school_email_address',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_email',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_email_address', array(
	   'settings' => 'business_school_email_address',
	   'section'   => 'business_school_header_section',
	   'label' => __('Add Email Address', 'business-school'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('business_school_contact_us_text',array(
		'default' => 'Contact Us',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_contact_us_text', array(
	   'settings' => 'business_school_contact_us_text',
	   'section'   => 'business_school_header_section',
	   'label' => __('Add Button Text', 'business-school'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('business_school_contact_us_url',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_contact_us_url', array(
	   'settings' => 'business_school_contact_us_url',
	   'section'   => 'business_school_header_section',
	   'label' => __('Add Button URL', 'business-school'),
	   'type'      => 'url'
	));

	// Social media Section
	$wp_customize->add_section('business_school_social_media_section', array(
        'title' => __('Manage Social media Section', 'business-school'),
		'description' => __('<p class="sec-title">Manage Social media Section</p>','business-school'),
        'priority' => null,
		'panel' => 'business_school_panel_area',
 	));

	$wp_customize->add_setting('business_school_fb_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_fb_link', array(
	   'settings' => 'business_school_fb_link',
	   'section'   => 'business_school_social_media_section',
	   'label' => __('Facebook Link', 'business-school'),
	   'type'      => 'url'
	));

	$wp_customize->add_setting('business_school_insta_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_insta_link', array(
	   'settings' => 'business_school_insta_link',
	   'section'   => 'business_school_social_media_section',
	   'label' => __('Instagram Link', 'business-school'),
	   'type'      => 'url'
	));

	$wp_customize->add_setting('business_school_googleplus_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_googleplus_link', array(
	   'settings' => 'business_school_googleplus_link',
	   'section'   => 'business_school_social_media_section',
	   'label' => __('Google Plus Link', 'business-school'),
	   'type'      => 'url'
	));

	$wp_customize->add_setting('business_school_youtube_link',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_youtube_link', array(
	   'settings' => 'business_school_youtube_link',
	   'section'   => 'business_school_social_media_section',
	   'label' => __('Youtube Link', 'business-school'),
	   'type'      => 'url'
	));

	// header menu
	$wp_customize->add_setting('business_school_menu_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_menu_color', array(
	   'settings' => 'business_school_menu_color',
	   'section'   => 'business_school_header_section',
	   'label' => __('Menu Color', 'business-school'),
	   'type'      => 'color'
	));

	// header menu hover color
	$wp_customize->add_setting('business_school_menuhrv_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_menuhrv_color', array(
	   'settings' => 'business_school_menuhrv_color',
	   'section'   => 'business_school_header_section',
	   'label' => __('Menu Hover Color', 'business-school'),
	   'type'      => 'color'
	));

	// header sub menu color
	$wp_customize->add_setting('business_school_submenu_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_submenu_color', array(
	   'settings' => 'business_school_submenu_color',
	   'section'   => 'business_school_header_section',
	   'label' => __('SubMenu Color', 'business-school'),
	   'type'      => 'color'
	));

	// header sub menu hover color
	$wp_customize->add_setting('business_school_submenuhrv_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_submenuhrv_color', array(
	   'settings' => 'business_school_submenuhrv_color',
	   'section'   => 'business_school_header_section',
	   'label' => __('SubMenu Hover Color', 'business-school'),
	   'type'      => 'color'
	));

	//Slider
  	$wp_customize->add_section('business_school_slider_section',array(
	    'title' => __('Manage Slider Section','business-school'),
	    'priority'  => null,
	    'description'	=> __('<p class="sec-title">Manage Slider Section</p>','business-school'),
	    'panel' => 'business_school_panel_area',
	));

	$wp_customize->add_setting('business_school_slider',array(
		'default' => false,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_slider', array(
	   'settings' => 'business_school_slider',
	   'section'   => 'business_school_slider_section',
	   'label'     => __('Check To Enable This Section','business-school'),
	   'type'      => 'checkbox'
	));

	$wp_customize->add_setting('business_school_slider_top_text',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('business_school_slider_top_text',array(
		'label'	=> esc_html__('Add Top Slider Text','business-school'),
		'section'=> 'business_school_slider_section',
		'type'=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

    $wp_customize->add_setting('business_school_slider_cat',array(
	    'default' => '0',
	    'sanitize_callback' => 'business_school_sanitize_choices',
  	));
  	$wp_customize->add_control('business_school_slider_cat',array(
	    'type'    => 'select',
	    'choices' => $cat_post,
	    'label' => __('Select Category to display Slider','business-school'),
	    'section' => 'business_school_slider_section',
	));

	$wp_customize->add_setting('business_school_button_text',array(
		'default' => 'Get Started',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_button_text', array(
	   'settings' => 'business_school_button_text',
	   'section'   => 'business_school_slider_section',
	   'label' => __('Add Button Text', 'business-school'),
	   'type'      => 'text'
	));

	$wp_customize->add_setting('business_school_button_link_slider',array(
        'default'=> '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('business_school_button_link_slider',array(
        'label' => esc_html__('Add Button Link','business-school'),
        'section'=> 'business_school_slider_section',
        'type'=> 'url'
    ));

	// about Section 
	$wp_customize->add_section('business_school_below_banner_section', array(
		'title'	=> __('Manage About Section','business-school'),
		'description'	=> __('<p class="sec-title">Manage About Section Section</p>','business-school'),
		'priority'	=> null,
		'panel' => 'business_school_panel_area',
	));
	
	$wp_customize->add_setting('business_school_disabled_pgboxes',array(
		'default' => false,
		'sanitize_callback' => 'business_school_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_disabled_pgboxes', array(
	   'settings' => 'business_school_disabled_pgboxes',
	   'section'   => 'business_school_below_banner_section',
	   'label'     => __('Check To Enable This Section','business-school'),
	   'type'      => 'checkbox'
	));

	$wp_customize->add_setting('business_school_about_title',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_about_title', array(
	   'settings' => 'business_school_about_title',
	   'section'   => 'business_school_below_banner_section',
	   'label' => __('Add Title', 'business-school'),
	   'type'      => 'text'
	));
	
	$wp_customize->add_setting('business_school_about_pageboxes',array(
		'default'	=> '0',
		'capability' => 'edit_theme_options',
		'sanitize_callback'	=> 'business_school_sanitize_dropdown_pages'
	));
	$wp_customize->add_control(	'business_school_about_pageboxes',array(
		'type' => 'dropdown-pages',
	   'label'     => __('Select Page to display About','business-school'),
		'section' => 'business_school_below_banner_section',
	));	

	$wp_customize->add_setting('business_school_abt_image_first',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'business_school_abt_image_first',array(
	    'label' => __('Select First About Image','business-school'),
	     'section' => 'business_school_below_banner_section'
	)));

	$wp_customize->add_setting('business_school_abt_image_second',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw',
	));
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize,'business_school_abt_image_second',array(
	    'label' => __('Select Second About Image','business-school'),
	     'section' => 'business_school_below_banner_section'
	)));

	for($i=1;$i<=3;$i++) {

	    $wp_customize->add_setting('business_school_about_sentence'.$i,array(
	        'default'=> '',
	        'sanitize_callback' => 'sanitize_text_field',
			'capability' => 'edit_theme_options',
	    ));
	    $wp_customize->add_control('business_school_about_sentence'.$i,array(
	        'label' => __('Add About Text ','business-school').$i,
	        'section'=> 'business_school_below_banner_section',
	        'settings'=> 'business_school_about_sentence'.$i,
	        'type'=> 'text'
	    ));

	 }

	//Blog post
	$wp_customize->add_section('business_school_blog_post_settings',array(
        'title' => __('Manage Post Section', 'business-school'),
        'priority' => null,
        'panel' => 'business_school_panel_area'
    ) );

   // Add Settings and Controls for Post Layout
	$wp_customize->add_setting('business_school_sidebar_post_layout',array(
     'default' => 'right',
     'sanitize_callback' => 'business_school_sanitize_choices'
	));
	$wp_customize->add_control('business_school_sidebar_post_layout',array(
     'type' => 'radio',
     'label'     => __('Theme Post Sidebar Position', 'business-school'),
     'description'   => __('This option work for blog page, archive page and search page.', 'business-school'),
     'section' => 'business_school_blog_post_settings',
     'choices' => array(
         'full' => __('Full','business-school'),
         'left' => __('Left','business-school'),
         'right' => __('Right','business-school'),
         'three-column' => __('Three Columns','business-school'),
         'four-column' => __('Four Columns','business-school'),
         'grid' => __('Grid Layout','business-school')
     ),
	) );

	$wp_customize->add_setting('business_school_blog_post_description_option',array(
    	'default'   => 'Excerpt Content', 
        'sanitize_callback' => 'business_school_sanitize_choices'
	));
	$wp_customize->add_control('business_school_blog_post_description_option',array(
        'type' => 'radio',
        'label' => __('Post Description Length','business-school'),
        'section' => 'business_school_blog_post_settings',
        'choices' => array(
            'No Content' => __('No Content','business-school'),
            'Excerpt Content' => __('Excerpt Content','business-school'),
            'Full Content' => __('Full Content','business-school'),
        ),
	) );

	// Footer Section
	$wp_customize->add_section('business_school_footer', array(
		'title'	=> __('Manage Footer Section','business-school'),
		'description'	=> __('<p class="sec-title">Manage Footer Section</p>','business-school'),
		'priority'	=> null,
		'panel' => 'business_school_panel_area',
	));

	$wp_customize->add_setting('business_school_copyright_line',array(
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control( 'business_school_copyright_line', array(
	   'section' 	=> 'business_school_footer',
	   'label'	 	=> __('Copyright Line','business-school'),
	   'type'    	=> 'text',
	   'priority' 	=> null,
    ));

	//  footer coypright color
	$wp_customize->add_setting('business_school_footercoypright_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_footercoypright_color', array(
	   'settings' => 'business_school_footercoypright_color',
	   'section'   => 'business_school_footer',
	   'label' => __('Coypright Color', 'business-school'),
	   'type'      => 'color'
	));

	//  footer bg color
	$wp_customize->add_setting('business_school_footerbg_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_footerbg_color', array(
	   'settings' => 'business_school_footerbg_color',
	   'section'   => 'business_school_footer',
	   'label' => __('BG Color', 'business-school'),
	   'type'      => 'color'
	));

	//  footer title color
	$wp_customize->add_setting('business_school_footertitle_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_footertitle_color', array(
	   'settings' => 'business_school_footertitle_color',
	   'section'   => 'business_school_footer',
	   'label' => __('Title Color', 'business-school'),
	   'type'      => 'color'
	));

	//  footer description color
	$wp_customize->add_setting('business_school_footerdescription_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_footerdescription_color', array(
	   'settings' => 'business_school_footerdescription_color',
	   'section'   => 'business_school_footer',
	   'label' => __('Description Color', 'business-school'),
	   'type'      => 'color'
	));

	//  footer list color
	$wp_customize->add_setting('business_school_footerlist_color',array(
		'default' => '',
		'sanitize_callback' => 'business_school_sanitize_hex_color',
		'capability' => 'edit_theme_options',
	));
	$wp_customize->add_control( 'business_school_footerlist_color', array(
	   'settings' => 'business_school_footerlist_color',
	   'section'   => 'business_school_footer',
	   'label' => __('List Color', 'business-school'),
	   'type'      => 'color'
	));

	$wp_customize->add_setting('business_school_scroll_hide', array(
        'default' => false,
        'sanitize_callback' => 'business_school_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'business_school_scroll_hide',array(
        'label'          => __( 'Check To Show Scroll To Top', 'business-school' ),
        'section'        => 'business_school_footer',
        'settings'       => 'business_school_scroll_hide',
        'type'           => 'checkbox',
    )));

}
add_action( 'customize_register', 'business_school_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function business_school_customize_preview_js() {
	wp_enqueue_script( 'business_school_customizer', esc_url(get_template_directory_uri()) . '/js/customize-preview.js', array( 'customize-preview' ), '20161510', true );
}
add_action( 'customize_preview_init', 'business_school_customize_preview_js' );
