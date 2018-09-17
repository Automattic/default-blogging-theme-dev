<?php

/* Get data from current discussion on post. */
$discussion = ip3_get_discussion_data();

if ( $discussion->responses > 0 ) :

/* Format these strings separatedly, then join later using `printf`. */
$responses = sprintf( _n( '%d response', '%d responses', $discussion->responses, 'independent-publisher-3' ), $discussion->responses );
$from_others = sprintf( _n( '%d other', '%d others', $discussion->commenters, 'independent-publisher-3' ), $discussion->commenters );

?>

<div class="discussion-meta">
	<?php ip3_discussion_avatars_list( $discussion->authors ); ?>
	<p class="discussion-meta-info">
		<?php echo ip3_get_icon_svg( 'comment', 24 ); ?>
		<span><?php
			/* translators: %1(16 responses)$s from %2(4 others)$s */
			printf( '%1$s from %2$s.', $responses, $from_others );
		?></span>
	</p>
</div><!-- .discussion-meta -->

<?php endif; ?>