<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package halal
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while ( have_posts() ) :
        the_post();

        get_template_part( 'template-parts/content', get_post_type() );

        // Display ACF File Field
        $file = get_field('book'); // Replace with your actual ACF field name
        if ( $file ):
            $file_url = $file['url'];
            $file_title = $file['title'];
    ?>
            <div class="acf-file-download">
                <a href="<?php echo esc_url( $file_url ); ?>" download><?php echo esc_html( $file_title ? $file_title : 'Download File' ); ?></a>
            </div>
    <?php
        endif;

        // Display ACF Image Field
        $cover_image = get_field('cover_image'); // Replace with your actual ACF image field name
        if ( $cover_image ):
            $cover_image_url = $cover_image['url'];
            $cover_image_alt = $cover_image['alt'];
    ?>
            <div class="acf-cover-image">
                <img src="<?php echo esc_url( $cover_image_url ); ?>" alt="<?php echo esc_attr( $cover_image_alt ); ?>" />
            </div>
    <?php
        endif;

        the_post_navigation(
            array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'halal' ) . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'halal' ) . '</span> <span class="nav-title">%title</span>',
            )
        );

        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>
