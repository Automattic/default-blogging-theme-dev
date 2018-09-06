<div id="page-wrapper" class="layout-wrap">

<?php if ( has_custom_logo() ) : ?>
	<div class="site-logo"><?php the_custom_logo(); ?></div>
<?php endif; ?>

<div id="content" class="site-content">
	
	<header id="masthead" class="site-header">
		<?php get_template_part( 'template-parts/header/site', 'branding' ) ?>
	</header><!-- #masthead -->