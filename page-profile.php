<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package halal
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			// Ensure myCRED plugin is active
			if ( function_exists('mycred_get_users_balance') ) {
				// Get current user ID
				$user_id = get_current_user_id();

				// Get user's points balance
				$balance = mycred_get_users_balance( $user_id );

				// Display the balance
				echo '<div class="user-points">Your Points: ' . esc_html( $balance ) . '</div>';
			} else {
				echo '<div class="user-points">myCRED plugin is not active.</div>';
			}

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		
	</main><!-- #main -->
		
<?php
get_footer();
?>
