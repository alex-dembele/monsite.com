<?php
/**
 * @package Business School
 * Setup the WordPress core custom header feature.
 *
 * @uses business_school_header_style()
 */
function business_school_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'business_school_custom_header_args', array(
		'default-text-color'     => 'fff',
		'width'                  => 2500,
		'height'                 => 400,
		'wp-head-callback'       => 'business_school_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'business_school_custom_header_setup' );

if ( ! function_exists( 'business_school_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see business_school_custom_header_setup().
 */
function business_school_header_style() {
	$business_school_header_text_color = get_header_textcolor();

	?>
	<style type="text/css">
	<?php
		//Check if user has defined any header image.
		if ( get_header_image() || get_header_textcolor() ) :
	?>
		.menuitem {
			background: url(<?php echo esc_url( get_header_image() ); ?>) no-repeat !important;
			background-position: center top;
			background-size: cover !important;
		}

	<?php endif; ?>	

	.page-template-template-home-page .site-title a, .page-template-template-home-page p.site-title a, h1.site-title a, p.site-title a{
		color: <?php echo esc_attr(get_theme_mod('business_school_sitetitle_color')); ?> !important;
	}

	.page-template-template-home-page .site-description, .site-description{
		color: <?php echo esc_attr(get_theme_mod('business_school_sitetagline_color')); ?> !important;
	}

	.main-nav ul li a {
		color: <?php echo esc_attr(get_theme_mod('business_school_menu_color')); ?> !important;
	}

	.main-nav a:hover{
		color: <?php echo esc_attr(get_theme_mod('business_school_menuhrv_color')); ?> !important;
	}

	.main-nav ul ul a{
		color: <?php echo esc_attr(get_theme_mod('business_school_submenu_color')); ?> !important;
	}

	.main-nav ul ul a:hover {
		color: <?php echo esc_attr(get_theme_mod('business_school_submenuhrv_color')); ?> !important;
	}

	.copywrap p {
		color: <?php echo esc_attr(get_theme_mod('business_school_footercoypright_color')); ?> !important;
	}
	#footer h6 {
		color: <?php echo esc_attr(get_theme_mod('business_school_footertitle_color')); ?> !important;

	}
	#footer p {
		color: <?php echo esc_attr(get_theme_mod('business_school_footerdescription_color')); ?>;
	}
	#footer ul li a {
		color: <?php echo esc_attr(get_theme_mod('business_school_footerlist_color')); ?>;

	}
	#footer {
		background-color: <?php echo esc_attr(get_theme_mod('business_school_footerbg_color')); ?>;
	}
	

	</style>
	<?php 
}
endif;