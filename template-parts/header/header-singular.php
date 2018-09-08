<?php
$background_image_style = has_post_thumbnail()
	? sprintf( ' style="background-image: url(%s);"', esc_url( get_the_post_thumbnail_url( get_the_ID(), 'post-thumbnail' ) ) )
	: null;
?>
<header id="masthead" class="<?php echo has_post_thumbnail() ? 'site-header cover-image' : 'site-header' ?>"<?php echo $background_image_style; ?>>
	<div class="layout-wrap">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>

		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
	</div><!-- .layout-wrap -->

	<?php if ( has_post_thumbnail() ) : ?>

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