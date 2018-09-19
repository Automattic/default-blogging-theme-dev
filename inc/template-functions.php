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
	// Adds the proper header class to use.
	if ( is_home() || is_front_page() ) {
		$classes[] = 'header-home';
	} else {
		$classes[] = 'header-default';
	}

	if ( is_singular() ) {
		// Adds `singular` to singular pages.
		$classes[] = 'singular';
	} else {
		// Adds `hfeed` to non singular pages.
		$classes[] = 'hfeed';
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
 * Changes comment form default fields.
 */
function ip3_comment_form_defaults( $defaults ) {
	$comment_field = $defaults[ 'comment_field' ];
	
	// Adjust height of comment form.
	$defaults[ 'comment_field' ] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'ip3_comment_form_defaults' );

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

/**
 * Returns the size for avatars used in the theme.
 */
function ip3_get_avatar_size() {
	return 60;
}

/**
 * Returns true if comment is by author of the post.
 *
 * @see get_comment_class()
 */
function ip3_is_comment_by_post_author( $comment=null ) {
	if ( is_object( $comment ) && $comment->user_id > 0 ) {
		$user = get_userdata( $comment->user_id );
		$post = get_post( $comment->comment_post_ID );
		if ( ! empty( $user ) && ! empty( $post ) ) {
			return $comment->user_id === $post->post_author;
		}
	}
	return false;
}

/**
 * Returns information about the current post's discussion, with cache support.
 */
function ip3_get_discussion_data() {
	static $discussion, $post_id;
	$current_post_id = get_the_ID();
	if ( $current_post_id === $post_id ) { /* If we have discussion information for post ID, return cached object */
		return $discussion;
	}
	$authors = array();
	$commenters = array();
	$user_id = is_user_logged_in() ? get_current_user_id() : -1;
	$comments = get_comments( array(
		'post_id' => $current_post_id,
		'orderby' => 'comment_date_gmt',
		'order'   => get_option( 'comment_order', 'asc' ), /* Respect comment order from Settings » Discussion. */
		'status'  => 'approve',
	) );
	foreach( $comments as $comment ) {
		$comment_user_id = (int) $comment->user_id;
		if ( $comment_user_id !== $user_id ) {
			$authors[] = ( $comment_user_id > 0 ) ? $comment_user_id : $comment->comment_author_email;
			$commenters[] = $comment->comment_author_email;
		}
	}
	$authors = array_unique( $authors );
	$responses = count( $commenters );
	$commenters = array_unique( $commenters );
	$post_id = $current_post_id;
	$discussion = (object) array(
		'authors'    => array_slice( $authors, 0, 6 ), /* Unique authors commenting on post (a subset of), excluding current user. */
		'commenters' => count( $commenters ),          /* Number of commenters involved in discussion, excluding current user. */
		'responses'  => $responses,                    /* Number of responses, excluding responses from current user. */
	);
	return $discussion;
}
