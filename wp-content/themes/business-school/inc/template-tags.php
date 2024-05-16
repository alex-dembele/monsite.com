<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Business School
 */

if ( ! function_exists( 'business_school_the_attached_image' ) ) :
/**
 * Prints the attached image with a link to the next attached image.
 */
function business_school_the_attached_image() {
	$post                = get_post();
	$attachment_size     = apply_filters( 'business_school_attachment_size', array( 1200, 1200 ) );
	$next_attachment_url = wp_get_attachment_url();
	$attachment_ids 	 = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID'
	) );

	wp_reset_postdata();

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id )
			$next_attachment_url = get_attachment_link( $next_id );

		// or get the URL of the first image attachment.
		else
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 */
function business_school_categorized_blog() {
	if ( false === ( $business_school_all_the_cool_cats = get_transient( 'business_school_all_the_cool_cats' ) ) ) {
		$business_school_all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		$business_school_all_the_cool_cats = count( $business_school_all_the_cool_cats );

		set_transient( 'business_school_all_the_cool_cats', $business_school_all_the_cool_cats );
	}

	if ( '1' != $business_school_all_the_cool_cats ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Function that returns if the menu is sticky
 */
if (!function_exists('business_school_sticky_menu')):
    function business_school_sticky_menu()
    {
        $is_sticky = get_theme_mod('business_school_stickyheader', false);

        if ($is_sticky == false):
            return 'not-sticky';
        else:
            return 'is-sticky-on main';
        endif;
    }
endif;

/**
 * Flush out the transients used in business_school_categorized_blog
 */
function business_school_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'business_school_all_the_cool_cats' );
}
add_action( 'edit_category', 'business_school_category_transient_flusher' );
add_action( 'save_post',     'business_school_category_transient_flusher' );