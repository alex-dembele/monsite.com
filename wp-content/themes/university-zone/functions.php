<?php
/**
 * Theme functions and definitions
 *
 * @package University_Zone
 */

/**
 * After setup theme hook
 */
function university_zone_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'university-zone', get_stylesheet_directory() . '/languages' );

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support( 'custom-logo', array(
        'header-text' => array( 'site-title', 'site-description' ),
    ) );
    
    $header_args = array(
        'default-image'    => get_stylesheet_directory_uri().'/images/banner.jpg',
        'width'            => 1920,
        'height'           => 800,
        'header-text'      => false,
        'video'            => true,
    );

    add_theme_support( 'custom-header', $header_args );

    /**
     * Register a selection of default headers to be displayed by the custom header admin UI.
     *
     * @link https://codex.wordpress.org/Function_Reference/register_default_headers
     */
    register_default_headers( array(
        'child' => array(
            'url'           => '%2$s/images/banner.jpg',
            'thumbnail_url' => '%2$s/images/banner.jpg',
            'description'   => __( 'Default Header Image', 'university-zone' ),
        ),
    ) );

    add_image_size( 'university-zone-info-thumb', 767, 950, true ); //adjust in mobile responsiveness
    add_image_size( 'university-zone-welcome-thumb', 570, 500, true );
    add_image_size( 'university-zone-featured-course', 370, 247, true );
}
add_action( 'after_setup_theme', 'university_zone_theme_setup' );

/**
 * Load assets.
 */
function university_zone_enqueue_styles() {
    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
    
    wp_enqueue_style( 'education-zone-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'university-zone-style', get_stylesheet_directory_uri() . '/style.css', array( 'education-zone-style' ), $version );

    wp_enqueue_script( 'university-zone-custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), $version, true );

    $query_args = array(
        'family' => 'Quicksand:300,400,500,700|Muli:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        'subset' => 'latin,latin-ext',
    );
    wp_enqueue_style( 'university-zone-google-fonts', add_query_arg( $query_args, "//fonts.googleapis.com/css" ), array(), null );
}
add_action( 'wp_enqueue_scripts', 'university_zone_enqueue_styles' );

//Remove a function from the parent theme
function university_zone_remove_parent_filters(){ 
    remove_filter( 'body_class', 'education_zone_body_classes');
}
add_action( 'init', 'university_zone_remove_parent_filters' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function universal_zone_body_classes( $classes ) {

    $page_class        = education_zone_sidebar_layout_class();
    $ed_banner_section = get_theme_mod( 'university_zone_ed_slider_section', 'post_banner' );

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if( 'no_banner' == $ed_banner_section || !( has_custom_header() && 'static_banner_cta' == $ed_banner_section ) ){
        $classes[] = 'no-banner';
    }
    
    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }
    
    if( ! is_active_sidebar( 'right-sidebar' ) || is_page_template( 'template-home.php' ) || $page_class == 'no-sidebar' ){
        $classes[] = 'full-width';
    }

    if( education_zone_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || 'product' === get_post_type() ) && ! is_active_sidebar( 'shop-sidebar' ) ){
        $classes[] = 'full-width';
    }
 
    return $classes;
}
add_filter( 'body_class', 'universal_zone_body_classes' );

/**
 * Add custom image size to media library.
 */
function university_zone_media_library_custom_image_size( $sizes ) {  
    return array_merge( $sizes, array(
        'university-zone-featured-course' => __( 'Gallery Image', 'university-zone' ),
    ) );
}
add_filter( 'image_size_names_choose', 'university_zone_media_library_custom_image_size' );

/**
 * Implementing parent theme functions to the child theme.
 */
require get_stylesheet_directory() . '/inc/parent-functions.php';
/**
 * Implementing new child theme functions to the child theme.
 */
require get_stylesheet_directory() . '/inc/child-functions.php';