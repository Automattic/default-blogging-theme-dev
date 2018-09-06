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

get_template_part( 'template-parts/footer/site', 'footer' );

get_template_part( 'template-parts/footer/footer', is_singular() ? 'singular' : 'home' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
