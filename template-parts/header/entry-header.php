<?php ip3_posted_on(); ?>
<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
<div class="meta-info">
	<?php ip3_posted_by(); ?>
	<?php ip3_estimated_read_time(); ?>
	<span class="comment-count">
		<?php ip3_comment_avatars(); ?>
		<?php ip3_comment_count(); ?>
	</span>
</div><!-- .meta-info -->