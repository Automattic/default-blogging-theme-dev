<?php
/**
 * Custom template tags for this theme
 *
 * @package Independent_Publisher_3
 */

if ( ! function_exists( 'ip3_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function ip3_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<span class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a></span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ip3_posted_by' ) ) :
	/**
	 * Prints HTML with meta information about theme author.
	 */
	function ip3_posted_by() {
		printf( '<span class="byline">%1$s<span class="screen-reader-text">%2$s</span><span class="author vcard"><a class="url fn n" href="%3$s">%4$s</a></span></span>',
			/* translators: 1: SVG icon. 2: post author, only visible to screen readers. 3: author link. */
			ip3_get_icon_svg( 'person', 16 ),
			esc_html__( 'Posted by', 'independent-publisher-3' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() ) );
	}
endif;

if ( ! function_exists( 'ip3_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function ip3_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo ip3_get_icon_svg( 'comment', 16 );
			
			/* translators: %s: Name of current post. Only visible to screen readers. */
			comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'independent-publisher-3' ), get_the_title() ) );

			echo '</span>';
		}
	}
endif;

if ( ! function_exists( 'ip3_comment_avatars' ) ) :
	/**
	 * Prints HTML with avatars for the latest commenters.
	 */
	function ip3_comment_avatars() {

	}
endif;

if ( ! function_exists( 'ip3_estimated_read_time' ) ) :
	/**
	 * Prints HTML with the estimated reading time.
	 */
	function ip3_estimated_read_time() {
		$minutes = ip3_get_estimated_reading_time();
		$datetime_attr = sprintf( '%dm 0s', $minutes );
		$read_time_text = sprintf( _nx( '%s Minute', '%s Minutes', $minutes, 'Time to read', 'independent-publisher-3' ), $minutes );
		/* translators: 1: SVG icon. 2: Reading time label, only visible to screen readers. 3: The [datetime] attribute for the <time> tag. 4: Estimated reading time text, in minutes. */
		printf ( '<span class="est-reading-time">%1$s<span class="screen-reader-text">%2$s</span><time datetime="%3$s">%4$s</time></span>',
			ip3_get_icon_svg( 'watch', 16 ),
			__( 'Estimated reading time', 'independent-publisher-3' ),
			$datetime_attr,
			$read_time_text );
	}
endif;
	
if ( ! function_exists( 'ip3_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ip3_entry_footer() {
		
		// Posted by
		ip3_posted_by();
		
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma. */
			$categories_list = get_the_category_list( esc_html__( ', ', 'independent-publisher-3' ) );
			if ( $categories_list ) {
				/* translators: 1: SVG icon. 2: posted in label, only visible to screen readers. 3: list of categories. */
				printf( '<span class="cat-links">%1$s<span class="screen-reader-text">%2$s</span>%3$s</span>',
					ip3_get_icon_svg( 'archive', 16 ),
					esc_html__( 'Posted in', 'independent-publisher-3' ),
					$categories_list
				); // WPCS: XSS OK.
			}
		}
		
		// Comment count.
		if ( ! is_singular() ) {
			ip3_comment_count();
		}

		// Edit post link.
		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers. */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'independent-publisher-3' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">' . ip3_get_icon_svg( 'edit', 16 ) ,
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'ip3_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function ip3_post_thumbnail() {
		if ( ! ip3_can_show_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else :
			$post_thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
		?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<span class="post-thumbnail-inner" style="background-image: url(<?php echo esc_url($post_thumbnail) ?>);">
				<?php
				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				?>
			</span>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'ip3_header_cover_image_css' ) ) :
	/**
	 * Documentation for function.
	 */
	function ip3_header_cover_image_css() {
		$img_url = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
		return sprintf( 'body.single .site-header.cover-image .site-branding-container:before { background-image: url(%s); }', esc_url( $img_url ) );
	}
endif;