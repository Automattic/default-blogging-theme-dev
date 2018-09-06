<footer id="colophon" class="site-footer">
	<div class="site-info">
		<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>,</span>
		<?php
		if ( function_exists( 'the_privacy_policy_link' ) ) {
			the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
		}
		?>
		<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'independent-publisher-3' ) ); ?>" class="imprint">
			<?php printf( __( 'Proudly powered by %s', 'independent-publisher-3' ), 'WordPress' ); ?>.
		</a>
	</div><!-- .site-info -->
</footer><!-- #colophon -->