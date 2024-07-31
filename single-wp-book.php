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
    while (have_posts()):
        the_post();

        get_template_part('template-parts/content', get_post_type());

        $post_id = get_the_ID();

        // Check if the user has access using MyCred
        $user_id = get_current_user_id();


        $access = mycred_user_paid_for_content($user_id, $post_id);

        echo $access;

        if ($access) {

            // User has access, display the PDF download link
            $pdf_file = get_field('book', $post_id);
            if ($pdf_file) {
                $pdf_url = $pdf_file['url'];
                echo '<a href="' . esc_url($pdf_url) . '" download>Download PDF</a>';
            } else {
                echo 'No PDF available.';
            }
        } else {
            // User doesn't have access, display the buy button
            // echo do_shortcode('[mycred_buy_this id="' . $post_id . '"]');
        }

        // Display ACF Image Field
        $cover_image = get_field('cover_image');
        if ($cover_image):
            $cover_image_url = $cover_image['url'];
            $cover_image_alt = $cover_image['alt'];
            ?>
            <div class="acf-cover-image">
                <img src="<?php echo esc_url($cover_image_url); ?>" alt="<?php echo esc_attr($cover_image_alt); ?>" />
            </div>
            <?php
        endif;

        the_post_navigation(
            array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Previous:', 'halal') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__('Next:', 'halal') . '</span> <span class="nav-title">%title</span>',
            )
        );

        //ACF section button to copy link to navigate to goodread and amazon
        /**
         * Template part for displaying a copy link button for an ACF field.
         */
        function display_acf_copy_link_button()
        {
            // Retrieve the file URL from ACF field.
            $file_url = get_field('goodread'); // Replace with your actual ACF field name for the URL.
    
            // Check if the file URL exists.
            if ($file_url): ?>
                <div class="acf-file-copy">
                    <input type="text" value="<?php echo esc_url($file_url); ?>" id="acfFileUrl" readonly
                        style="opacity: 0; position: absolute; left: -9999px;">
                    <a href="<?php echo esc_url($file_url) ?>" target="_blank">Copy Link</a>
                </div>
            <?php endif;
        }


        // Use this function where you need to display the copy link button, for example in a template file:
        display_acf_copy_link_button();
        if (comments_open() || get_comments_number()):
            comments_template();
        endif;

    endwhile; // End of the loop.
    ?>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>