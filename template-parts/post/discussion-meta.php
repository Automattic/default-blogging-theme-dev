<?php

/* Get data from current discussion on post. */
$discussion = ip3_get_discussion_data();

$comments_number = get_comments_number();
$has_responses   = $discussion->responses > 0;

if ( $has_responses ) {
	/* translators: %1(X responses)$s from %2(X others)$s */
	$meta_label = sprintf( '%1$s from %2$s.',
		sprintf( _n( '%d response', '%d responses', $discussion->responses, 'independent-publisher-3' ), $discussion->responses ),
		sprintf( _n( '%d other', '%d others', $discussion->commenters, 'independent-publisher-3' ), $discussion->commenters ) );
} else if ( $comments_number > 0 ) {
	/* Show comment count if not enough discussion information */
	$meta_label = sprintf( _n( '%d Comment', '%d Comments', $comments_number, 'independent-publisher-3' ), $comments_number );
} else {
	$meta_label = __( 'No comments', 'independent-publisher-3' );
}

?>

<div class="discussion-meta">
	<?php if ( $has_responses ) ip3_discussion_avatars_list( $discussion->authors ); ?>
	<p class="discussion-meta-info">
		<?php echo ip3_get_icon_svg( 'comment', 24 ); ?>
		<span><?php echo esc_html( $meta_label ); ?></span>
	</p>
</div><!-- .discussion-meta -->
