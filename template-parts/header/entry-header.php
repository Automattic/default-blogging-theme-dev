<?php if ( ! is_page() ) : ?>
<?php $discussion = ip3_can_show_post_thumbnail() ? ip3_get_discussion_data() : null; ?>
<?php ip3_posted_on(); ?>
<?php endif; ?>
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<?php if ( ! is_page() ) : ?>
<div class="<?php echo ( ! empty( $discussion ) && count( $discussion->authors ) > 0 ) ? 'meta-info has-discussion' : 'meta-info'; ?>">
	<?php ip3_posted_by(); ?>
	<?php ip3_estimated_read_time(); ?>
	<span class="comment-count">
		<?php if ( ! empty( $discussion ) ) ip3_discussion_avatars_list( $discussion->authors ); ?>
		<?php ip3_comment_count(); ?>
	</span>
</div><!-- .meta-info -->
<?php endif; ?>