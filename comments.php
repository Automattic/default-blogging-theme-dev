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
	
	<div class="comments-title-flex">
		<h2 class="comments-title"><?php esc_html_e( 'Join the Conversation', 'independent-publisher-3' ) ?></h2>
		<?php get_template_part( 'template-parts/post/discussion', 'meta' ); ?>
	</div><!-- .comments-title-flex -->

	<?php
	
	// Show comment form at top if showing newest comments at the top.
	ip3_comment_form( 'desc' );
	
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'walker'      => new Independent_Publisher_3_Walker_Comment(),
				'avatar_size' => ip3_get_avatar_size(),
				'short_ping'  => true,
				'style'       => 'ol',
			) );
			?>
		</ol><!-- .comment-list -->

		<?php
		
		// Show comment form at bottom if showing newest comments at the bottom.
		if ( 'asc' === strtolower( get_option( 'comment_order', 'asc' ) ) ) : ?>
			<div class="comment-form-flex">
				<?php ip3_comment_form( 'asc' ); ?>
				<h2 class="comments-title"><?php esc_html_e( 'Leave a comment', 'independent-publisher-3' ) ?></h2>
			</div>
		<?php endif;
		
		$prev_icon = ip3_get_icon_svg( 'chevron_left',  22 );
		$next_icon = ip3_get_icon_svg( 'chevron_right', 22 );
		$comments_text = __( 'Comments', 'independent-publisher-3' );

		the_comments_navigation( array(
			'prev_text' => sprintf( '%s <span class="nav-prev-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span>', $prev_icon, __( 'Previous', 'independent-publisher-3' ), __( 'Comments', 'independent-publisher-3' ) ),
			'next_text' => sprintf( '<span class="nav-next-text"><span class="primary-text">%s</span> <span class="secondary-text">%s</span></span> %s', __( 'Next', 'independent-publisher-3' ), __( 'Comments', 'independent-publisher-3' ), $next_icon ),
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
