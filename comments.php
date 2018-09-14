<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Independent_Publisher_3
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="comments-area">
	
	<h2 class="comments-title"><?php esc_html_e( 'Join the Conversation', 'independent-publisher-3' ) ?></h2>

	<?php comment_form( array(
		'title_reply_before' => ip3_get_user_avatar_markup(),
		'logged_in_as'       => null,
		'title_reply'        => null,
	) ); ?>

	<?php
	
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'walker'      => new Independent_Publisher_3_Walker_Comment(),
				'avatar_size' => 60,
				'short_ping'  => true,
				'style'       => 'ol',
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		
		$prev_icon = ip3_get_icon_svg( 'chevron_left',  22 );
		$next_icon = ip3_get_icon_svg( 'chevron_right', 22 );
		
		the_comments_navigation( array(
			'prev_text' => sprintf( '%s <span class="nav-prev-text">%s</span>', $prev_icon, __( 'Previous', 'independent-publisher-3' ) ),
			'next_text' => sprintf( '<span class="nav-next-text">%s</span> %s', __( 'Next', 'independent-publisher-3' ), $next_icon ),
		) );

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments">
				<?php esc_html_e( 'Comments are closed.', 'independent-publisher-3' ); ?>
			</p>
			<?php
		endif;

	endif; // if have_comments().

	?>

</div><!-- #comments -->
