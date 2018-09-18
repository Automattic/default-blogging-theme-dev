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

if ( ! function_exists( 'ip3_estimated_read_time' ) ) :
	/**
	 * Prints HTML with the estimated reading time. Does not display when time to read is zero.
	 */
	function ip3_estimated_read_time() {
		$minutes = ip3_get_estimated_reading_time();
		if ( 0 === $minutes ) return null;
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
	 * Returns the CSS for the header cover image background.
	 */
	function ip3_header_cover_image_css() {
		$img_url = get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' );
		return sprintf( 'body.singular .site-header.cover-image .site-branding-container:before { background-image: url(%s); }', esc_url( $img_url ) );
	}
endif;

if ( ! function_exists( 'ip3_human_time_diff' ) ) :
/**
 * Same as core's human_time_diff(), only in the "ago" context,
 * which is different for some languages.
 *
 * @param int $from Unix timestamp from which the difference begins.
 * @param int $to Optional Unix timestamp to end the time difference. Defaults to time() if not set.
 * @return string Human readable time difference.
 */
	function ip3_human_time_diff( $from, $to = '' ) {
		if ( empty( $to ) ) {
			$to = time(); 
		}

		$diff = (int) abs( $to - $from );

		if ( $diff < HOUR_IN_SECONDS ) {
			$mins = round( $diff / MINUTE_IN_SECONDS );
			if ( $mins <= 1 ) {
				$mins = 1;
			}
			/* translators: min=minute */
			$since = sprintf( _n( '%s min ago', '%s mins ago', $mins, 'independent-publisher-3' ), $mins );
		} elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
			$hours = round( $diff / HOUR_IN_SECONDS );
			if ( $hours <= 1 ) {
				$hours = 1;
			}
			$since = sprintf( _n( '%s hour ago', '%s hours ago', $hours, 'independent-publisher-3' ), $hours );
		} elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
			$days = round( $diff / DAY_IN_SECONDS );
			if ( $days <= 1 ) {
				$days = 1;
			}
			$since = sprintf( _n( '%s day ago', '%s days ago', $days, 'independent-publisher-3' ), $days );
		} elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
			$weeks = round( $diff / WEEK_IN_SECONDS );
			if ( $weeks <= 1 ) {
				$weeks = 1;
			}
			$since = sprintf( _n( '%s week ago', '%s weeks ago', $weeks, 'independent-publisher-3' ), $weeks );
		} elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {
			$months = round( $diff / ( 30 * DAY_IN_SECONDS ) );
			if ( $months <= 1 ) {
				$months = 1;
			}
			$since = sprintf( _n( '%s month ago', '%s months ago', $months, 'independent-publisher-3' ), $months );
		} elseif ( $diff >= YEAR_IN_SECONDS ) {
			$years = round( $diff / YEAR_IN_SECONDS );
			if ( $years <= 1 ) {
				$years = 1;
			}
			$since = sprintf( _n( '%s year ago', '%s years ago', $years, 'independent-publisher-3' ), $years );
		}

		return $since;
	}
endif;

if ( ! function_exists( 'ip3_comment_avatar' ) ) :
	/**
	 * Returns the HTML markup to generate a user avatar.
	 */
	function ip3_get_user_avatar_markup( $id_or_email=null ) {
		if ( ! isset( $id_or_email ) ) {
			$id_or_email = get_current_user_id();
		}
		
		$classes = array( 'comment-author', 'vcard' );
		
		return sprintf( '<div class="comment-user-avatar comment-author vcard">%s</div>', get_avatar( $id_or_email, ip3_get_avatar_size() ) );
	}
endif;

if ( ! function_exists( 'ip3_discussion_avatars_list' ) ) :
	/**
	 * Displays a list of avatars involved in a discussion for a given post.
	 */
	function ip3_discussion_avatars_list( $comment_authors ) {
		if ( ! empty( $comment_authors ) ) {
			$out = array('<ol class="discussion-avatar-list">');
			foreach( $comment_authors as $id_or_email ) {
				$out[] = sprintf( '<li>%s</li>', ip3_get_user_avatar_markup( $id_or_email ) );
			}
			$out[] = '</ol><!-- .discussion-avatar-list -->';
			echo implode( "\n", $out );
		}
		return null;
	}
endif;

if ( ! function_exists( 'ip3_comment_form' ) ) :
	/**
	 * Documentation for function.
	 */
	function ip3_comment_form( $order ) {
		if ( strtolower( $order ) === strtolower( get_option( 'comment_order', 'asc' ) ) ) {
			comment_form( array(
				'title_reply_before' => ip3_get_user_avatar_markup(),
				'logged_in_as'       => null,
				'title_reply'        => null,
			) );
		}
	}
endif;