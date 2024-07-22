<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package halal
 */

?>

	<footer id="colophon" class="site-footer">
		
		<div class="footer-menus"> <!-- .footer-menus -->
			<nav id="footer-navigation" class="footer-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'footer') ); ?>
			</nav>
    	</div>
		
		<div class="site-info">
			<span>Proudly developed by Baagii, Ritesh, William, Nikko</span>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
