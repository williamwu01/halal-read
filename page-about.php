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
    while (have_posts()):
        the_post();

        get_template_part('template-parts/content', 'page');


    endwhile; // End of the loop.
    ?>

    <h2>Testimonial</h2>

    <?php
    $args = array(
        'post_type' => 'wp-testimonial',
        'posts_per_page' => 4
    );
    $testimonials = new WP_Query($args);

    if ($testimonials->have_posts()):
        while ($testimonials->have_posts()):
            $testimonials->the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h2 class="entry-title"><?php the_title(); ?></h2>
                </header>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>

        <?php endwhile;
        wp_reset_postdata();
    else: ?>
        <p><?php _e('No testimonials found.', 'textdomain'); ?></p>
    <?php endif; ?>


</main><!-- #main -->