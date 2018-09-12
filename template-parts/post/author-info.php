<div class="author-description">
	<h2 class="author-title">
		<span class="author-heading"><?php _e( 'Published by', 'independent-publisher-3' ); ?></span>
		<?php echo get_the_author(); ?>
	</h2>
	<p class="author-bio">
		<?php the_author_meta( 'description' ); ?>
		<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
			<?php _e( 'View more posts ', 'independent-publisher-3' ) ?>
		</a>
	</p><!-- .author-bio -->
<div><!-- .author-description -->