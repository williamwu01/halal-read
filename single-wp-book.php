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
    $error_message = '';
    $buy_points_url = '/buy-points'; // Replace this with the actual URL for purchasing points

    if ( isset( $_POST['buy_book'] ) && isset( $_POST['book_id'] ) ) {
        $user_id = get_current_user_id();
        $book_id = intval( $_POST['book_id'] );
        $price = get_field('book_price', $book_id);

        if ( $user_id && $price ) {
            $mycred = mycred();
            $user_balance = $mycred->get_users_balance( $user_id );

            // Check if the user has enough points
            if ( $user_balance >= $price ) {
                // Deduct points and mark as purchased
                $mycred->add_creds(
                    'buy_book',
                    $user_id,
                    -$price,
                    'Purchased book: ' . get_the_title( $book_id ),
                    $book_id
                );

                // Mark the book as purchased (you can store this information in user meta or a custom table)
                update_user_meta( $user_id, 'purchased_book_' . $book_id, 1 );

                // Redirect to avoid resubmission
                wp_redirect( get_permalink( $book_id ) );
                exit;
            } else {
                // Store the error message if the user does not have enough points
                $error_message = esc_html__( 'You do not have enough points to purchase this book.', 'halal' );
            }
        }
    }

    while ( have_posts() ) :
        
    ?>
    <?php
    $book_id = get_the_ID();
    ?><h2><?php echo get_the_title($book_id); ?></h2> <?php
    the_post();

    get_template_part( 'template-parts/content', get_post_type() );

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

        // Get the book file and price
        $file = get_field('book'); 
        $price = get_field('book_price'); 
        if ( $file ):
            $file_url = $file['url'];
            $file_title = $file['title'];

            
            // Check if the user has paid for the book
            $user_id = get_current_user_id();
            $book_id = get_the_ID();
            $has_paid = mycred_has_paid($user_id, $book_id);

            if ( $has_paid ) {
    ?>
    <div class="acf-file-download">
        <a class="download-button" href="<?php echo esc_url( $file_url ); ?>"
            download><?php echo esc_html( 'Download File' ); ?></a>
    </div>
    <?php
            } else {
                // Display the payment button
                if ( is_user_logged_in() ) {
    ?>
    <div class="acf-file-payment">
        <form method="post" action="">
            <input type="hidden" name="book_id" value="<?php echo esc_attr( $book_id ); ?>">
            <button type="submit" name="buy_book"
                value="1"><?php printf( esc_html__( 'Buy for %d Points', 'halal' ), $price ); ?></button>
        </form>
        <?php if ( $error_message ): ?>
        <p class="error-message"><?php echo $error_message; ?></p>
        <a href="<?php echo esc_url( $buy_points_url ); ?>"
            class="buy-points-button"><?php esc_html_e( 'Buy Points', 'halal' ); ?></a>
        <?php endif; ?>
    </div>
    <?php
                } else {
    ?>
    <p><?php esc_html_e( 'Please log in to purchase the book.', 'halal' ); ?></p>
    <?php
                }
            }
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

    endwhile; 
    ?>
</main><!-- #main -->

<?php
get_sidebar();
get_footer();
?>

<?php
// Function to check if the user has paid for the book
function mycred_has_paid( $user_id, $book_id ) {
    return get_user_meta( $user_id, 'purchased_book_' . $book_id, true ) == 1;
}
?>