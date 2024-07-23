<?php
/**
 * The template for displaying the front page
 *
 * @package halal
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    while (have_posts()):
        the_post();
        get_template_part('template-parts/content', 'page');
    endwhile; // End of the loop.
    ?>

    <section class="featured-books">
        <?php
        // Custom WP_Query to get books with the most comments
        $args = array(
            'post_type' => 'wp-book',        // Your custom post type
            'posts_per_page' => 4,           // Limit to 4 books
            'orderby' => 'comment_count',    // Order by number of comments
            'order' => 'DESC',               // Highest comment count first
        );

        $most_commented_books = new WP_Query($args);

        if ($most_commented_books->have_posts()): ?>
        <div class="book-list">
            <?php while ($most_commented_books->have_posts()):
                    $most_commented_books->the_post(); ?>
            <div class="book-item">
                <div class="book-cover">
                    <?php
                    // Fetch the ACF field
                    $cover_image = get_field('cover_image');

                    // Check if the cover_image field has a value
                    if ($cover_image) {
                        // Display the cover_image
                        echo '<img src="' . esc_url($cover_image['url']) . '" alt="' . esc_attr($cover_image['alt']) . '">';
                    } elseif (has_post_thumbnail()) {
                        // Display the post thumbnail if cover_image is not available
                        the_post_thumbnail();
                    }
                    ?>
                </div>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="book-excerpt"><?php the_excerpt(); ?></div>
                <div class="comment-count">
                    <?php comments_number('No Comments', '1 Comment', '% Comments'); ?>
                </div>
            </div>
            <?php endwhile;
                wp_reset_postdata(); ?>
        </div>
        <?php else: ?>
        <p><?php _e('No featured books found.', 'textdomain'); ?></p>
        <?php endif; ?>

    </section>

    <section class="new-books">
        <?php
        // Custom WP_Query to get new books
        $args = array(
            'post_type' => 'wp-book',        // Your custom post type
            'posts_per_page' => 4,           // Limit to 4 books
            'orderby' => 'date',            // Order by date
            'order' => 'DESC',              // Most recent first
        );

        $most_commented_books = new WP_Query($args);

        if ($most_commented_books->have_posts()): ?>

        <h2>New Books on the Shelf</h2>
        <div class="book-list">
            <?php while ($most_commented_books->have_posts()):
                    $most_commented_books->the_post(); ?>
            <div class="book-item">
                <div class="book-cover">
                    <?php
                    // Display the post thumbnail
                    $cover_image = get_field('cover_image');

                    // Check if the cover_image field has a value
                    if ($cover_image) {
                        // Display the cover_image
                        echo '<img src="' . esc_url($cover_image['url']) . '" alt="' . esc_attr($cover_image['alt']) . '">';
                    } elseif (has_post_thumbnail()) {
                        // Display the post thumbnail if cover_image is not available
                        the_post_thumbnail();
                    }
                    ?>
                </div>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <div class="book-excerpt"><?php the_excerpt(); ?></div>
            </div>
            <?php endwhile;
                wp_reset_postdata(); ?>
        </div>
        <?php else: ?>
        <p><?php _e('No new books found.', 'textdomain'); ?></p>
        <?php endif; ?>

    </section>

    <section class="why-halal">
        <h2>Why Halalreads?</h2>
    </section>

    <section class="awards">
        <h2>Awards</h2>
        <div class="awards-wrap"></div>
    </section>

    <section class="social-media">
        <h2>Join us on our social media to keep up!</h2>
        <div class="social-icon"></div>
    </section>

</main><!-- #main -->

<?php
get_footer();