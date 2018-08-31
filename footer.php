<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Independent_Publisher_3
 */

?>
			<footer id="colophon" class="site-footer">
				<div class="site-info">
					<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>,</span>
					<?php
					if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
					}
					?>
					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'independent-publisher-3' ) ); ?>" class="imprint">
						<?php printf( __( 'Proudly powered by %s', 'twentysixteen' ), 'WordPress' ); ?>.
					</a>
				</div><!-- .site-info -->
			</footer><!-- #colophon -->

		</div><!-- #content -->
	</div><!-- #page-wrapper -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
