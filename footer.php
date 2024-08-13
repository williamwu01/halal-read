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
		<div class="footer-wrapper">
			<div class="footer-left">
				<?php
					// Specify the sidebar ID or name where the widget is registered
					$sidebar_id = 'footer-sidebar';

					// Check if the specified sidebar is active and has widgets
					if (is_active_sidebar($sidebar_id)) {
						// Display the widgets in the specified sidebar
						dynamic_sidebar($sidebar_id);
					}
				?>
			</div>

			<div class="footer-middle"> 
				<nav>
					<?php wp_nav_menu(
						array(
							'theme_location' => 'footer-middle',
							'menu_id' => 'footer-menu',
							'items_wrap' => '<ul id="%1$s" class="footer-menu %2$s">%3$s</ul>'
						)
					); ?>

				</nav>
			</div>

			<div class="footer-right">
				<button class="cta-btn" onclick="window.location.href='https://williamwu.tech/strange-inc/register/'">
					Sign up here!
				</button>
				<p class="footer-social">Subscribe for newsletter</p>
				<?php
					// Specify the sidebar ID or name where the widget is registered
					$sidebar_id = 'footer-subscribe';

					// Check if the specified sidebar is active and has widgets
					if (is_active_sidebar($sidebar_id)) {
						// Display the widgets in the specified sidebar
						dynamic_sidebar($sidebar_id);
					}
				?>
			</div>
		</div>
		<div class="site-info">
				<span>&copy;Halal read. All rights reserved.</span>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
