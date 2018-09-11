<?php
/**
 * Functions which enhance the theme by hooking into WordPress.
 *
 * @package Independent_Publisher_3
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ip3_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	
	// Adds a class if image filters are enabled.
	if ( ip3_image_filters_enabled() ) {
		$classes[] = 'image-filters-enabled';
	}

	return $classes;
}
add_filter( 'body_class', 'ip3_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function ip3_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ip3_pingback_header' );

/**
 * Determines if post thumbnail can be displayed.
 */
function ip3_can_show_post_thumbnail() {
	return ! post_password_required() && ! is_attachment() && has_post_thumbnail();
}

/**
 * Determines the estimated time to read a post, in minutes.
 */
function ip3_get_estimated_reading_time() {
	$content = get_post_field( 'post_content', get_the_ID() );
	$count = str_word_count( strip_tags( $content ) );
	return (int) round( $count / 250 ); // Assuming 250 words per minute reading speed.
}

/**
 * Returns true if image filters are enabled on the theme options.
 */
function ip3_image_filters_enabled() {
	return true;
}