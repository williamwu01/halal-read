<?php get_header(); ?>

<div class="container">
    <h1><?php single_term_title(); ?></h1>
    <div class="taxonomy-description"><?php echo term_description(); ?></div>

    <?php if (have_posts()): ?>
        <div class="book-list">
            <?php while (have_posts()):
                the_post(); ?>
                <div class="book-item">

                    <?php
                    if (function_exists('get_field')) {

                        // Define your custom field name
                        $field_name = 'cover_image';
                        $image_url = get_field($field_name);


                        if ($image_url) {
                            echo '<img src="' . esc_url($image_url["url"]) . '" alt="' . esc_attr($term_title) . '"/>';
                        } else {
                            // Field does not exist or is empty
                            echo '<p>No custom field data available.</p>';
                        }
                    }
                    ?>

                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    <div class="book-excerpt"><?php the_excerpt(); ?></div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php the_posts_navigation(); ?>
    <?php else: ?>
        <p><?php _e('No books found in this genre.', 'textdomain'); ?></p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>