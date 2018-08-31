<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Independent_Publisher_3
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'independent-publisher-3' ); ?></a>
	<div id="page-wrapper">

	<?php if ( has_custom_logo() ) : ?>
		<div class="site-logo"><?php the_custom_logo(); ?></div>
	<?php endif; ?>

	<div id="content" class="site-content">
		
		<header id="masthead" class="site-header">
			<div class="site-branding">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php $description = get_bloginfo( 'description', 'display' ); ?>
				<?php
					if ( ! empty( $description ) ) : 
						if ( ! preg_match( '/\.\s*$/', $description )  ) $description .= '.'; // Add period if not present.
				?>
				<span class="site-description">
					<span class="separator">&mdash;</span>
					<?php echo $description; ?></span>
				<?php endif; ?>
				<?php if ( has_nav_menu( 'menu-1' ) ) : ?>
					<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'twentyseventeen' ); ?>">
						<?php wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_class'     => 'main-menu',
					) ); ?>
					</nav><!-- #site-navigation -->
				<?php endif; ?>
				<?php if ( has_nav_menu( 'social' ) ) : ?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'independent-publisher-3' ); ?>">
						<?php wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_class'     => 'social-links-menu',
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>' . ip3_get_icon_svg( 'link' ),
							'depth'          => 1,
						) ); ?>
					</nav><!-- .social-navigation -->
				<?php endif; ?>
			</div><!-- .site-branding -->
		</header><!-- #masthead -->
