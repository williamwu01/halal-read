<?php
/**
 * Template Name: New Event Lounge
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

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>
		<section class="featured-books">
        <?php
        // Custom WP_Query to get books with the most comments
        $args = array(
            'post_type' => 'wp-event',        // Your custom post type
            'posts_per_page' => 4,             // Limit to 4 books
            'orderby' => 'comment_count', // Order by number of comments
            'order' => 'DESC',        // Highest comment count first
        );

        $most_commented_books = new WP_Query($args);

        if ($most_commented_books->have_posts()): ?>
            <div class="event-list">
                <?php while ($most_commented_books->have_posts()):
                    $most_commented_books->the_post(); ?>
                    <div class="event-item">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="event-cover">
                                <?php the_post_thumbnail('large'); // Display book cover ?>
                            </div>
                        <?php endif; ?>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <div class="event-excerpt"><?php the_excerpt(); ?></div>
                        <div class="comment-count">
                            <?php comments_number('No Comments', '1 Comment', '% Comments'); ?>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </div>
        <?php else: ?>
            <p><?php _e('No events found.', 'textdomain'); ?></p>
        <?php endif; ?>

    </section>
    <section class="awards">
        <h2>Social</h2>
        <div class="awards-wrap">
            <?php
            // Function to get SVG content
            function get_svg_content($filename) {
                $file_path = get_template_directory() . '/svg/' . $filename;
                if (file_exists($file_path)) {
                    return file_get_contents($file_path);
                }
                return '';
            }

            echo get_svg_content('social1.svg');
            echo get_svg_content('social2.svg');
            echo get_svg_content('social3.svg');
            echo get_svg_content('social4.svg');
            echo get_svg_content('social5.svg');
            ?>
        </div>
    </section>
	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
