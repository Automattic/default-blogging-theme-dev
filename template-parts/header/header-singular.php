<header id="masthead" class="<?php echo ip3_can_show_post_thumbnail() ? 'site-header cover-image' : 'site-header' ?>">
	<div class="site-branding-container layout-wrap">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
	</div><!-- .layout-wrap -->

	<?php if ( ip3_can_show_post_thumbnail() ) : ?>

	<div class="singular-post-meta layout-wrap">
		<?php the_post(); ?>
		<div class="content-wrap">
			<?php get_template_part( 'template-parts/header/entry', 'header' ); ?>
		</div><!-- .content-wrap -->
		<?php rewind_posts(); ?>
	</div><!-- .singular-post-meta -->

	<?php endif; ?>
</header><!-- #masthead -->

<div class="layout-wrap">
	
<div id="content" class="site-content">