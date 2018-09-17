<?php $discussion = ip3_get_discussion_data(); ?>
<?php ip3_posted_on(); ?>
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<div class="<?php echo count( $discussion->authors ) > 0 ? 'meta-info has-discussion' : 'meta-info'; ?>">
	<?php ip3_posted_by(); ?>
	<?php ip3_estimated_read_time(); ?>
	<span class="comment-count">
		<?php ip3_discussion_avatars_list( $discussion->authors ); ?>
		<?php ip3_comment_count(); ?>
	</span>
</div><!-- .meta-info -->