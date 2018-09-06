<div class="site-branding">
	<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	<?php
		// Only show description on front page.
		$description = ( is_home() || is_front_page() ) ? get_bloginfo( 'description', 'display' ) : null;

		// Add a period to the end of the description sentence, if not available.
		if ( ! empty( $description ) ) {
			if ( ! preg_match( '/\.\s*$/', $description )  ) $description .= '.';
		}
	?>
	<span class="site-description">
		<span class="separator">&mdash;</span>
		<?php echo $description; ?>
	</span>
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