
<header id="masthead" class="site-header">
	<div class="layout-wrap">
		<?php if ( has_custom_logo() ) : ?>
			<div class="site-logo"><?php the_custom_logo(); ?></div>
		<?php endif; ?>
		
		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
	</div><!-- .layout-wrap -->
	<?php get_template_part( 'template-parts/header/singular', 'post-meta' ); ?>
</header><!-- #masthead -->

<div id="page-wrapper" class="layout-wrap">

<div id="content" class="site-content">