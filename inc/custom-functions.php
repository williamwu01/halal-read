<?php
function update_comments_table_schema()
{
    global $wpdb;

    // Check if the column already exists
    $column_exists = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}comments LIKE 'rating'");

    if (empty($column_exists)) {
        // Add the new column with a default value
        $wpdb->query("ALTER TABLE {$wpdb->prefix}comments ADD COLUMN rating TINYINT(1) NOT NULL DEFAULT 0");
    }
}
add_action('init', 'update_comments_table_schema');

function save_comment_rating($comment_id)
{
    // Check if the rating field is set
    if (isset($_POST['rating'])) {
        $rating = intval($_POST['rating']);

        // Update the comment meta with the rating value
        add_comment_meta($comment_id, 'rating', $rating, true);
    }
}
add_action('comment_post', 'save_comment_rating');

function rating_comment($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 64); ?>
                    <b class="fn"><?php comment_author(); ?></b> <span
                        class="says"><?php esc_html_e('says:', 'halal'); ?></span>
                </div><!-- .comment-author -->

                <div class="comment-metadata">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                        <time datetime="<?php comment_time('c'); ?>"><?php comment_date(); ?> at
                            <?php comment_time(); ?></time>
                    </a>
                    <?php edit_comment_link(esc_html__('Edit', 'halal'), '<span class="edit-link">', '</span>'); ?>
                </div><!-- .comment-metadata -->
            </footer><!-- .comment-meta -->

            <div class="comment-content">
                <?php comment_text(); ?>
                <?php
                // Retrieve and display the rating
                $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                if ($rating) {
                    echo '
                        <div class="rating">
                            <label class="' . ($rating >= 5 ? 'rated' : '') . '" for="star5" title="5 stars">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21 16.54 14.85 22 9.27 15.81 8.63 12 2 8.19 8.63 2 9.27 7.46 14.85 5.82 21 12 17.27z"></path></svg>
                            </label>

                            <label class="' . ($rating >= 4 ? 'rated' : '') . '" for="star4" title="4 stars">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21 16.54 14.85 22 9.27 15.81 8.63 12 2 8.19 8.63 2 9.27 7.46 14.85 5.82 21 12 17.27z"></path></svg>
                            </label>

                            <label class="' . ($rating >= 3 ? 'rated' : '') . '" for="star3" title="3 stars">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21 16.54 14.85 22 9.27 15.81 8.63 12 2 8.19 8.63 2 9.27 7.46 14.85 5.82 21 12 17.27z"></path></svg>
                            </label>

                            <label class="' . ($rating >= 2 ? 'rated' : '') . '" for="star2" title="2 stars">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21 16.54 14.85 22 9.27 15.81 8.63 12 2 8.19 8.63 2 9.27 7.46 14.85 5.82 21 12 17.27z"></path></svg>
                            </label>

                            <label class="' . ($rating >= 1 ? 'rated' : '') . '" for="star1" title="1 star">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21 16.54 14.85 22 9.27 15.81 8.63 12 2 8.19 8.63 2 9.27 7.46 14.85 5.82 21 12 17.27z"></path></svg>
                            </label>
                        </div>';
                }
                ?>
            </div><!-- .comment-content -->

            <div class="reply">
                <?php comment_reply_link(array_merge($args, array('reply_text' => esc_html__('Reply', 'halal'), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
            </div><!-- .reply -->
        </article><!-- .comment-body -->
    </li>
    <?php
}


// remove menu stuffs
function restrict_admin_menu()
{
    if (current_user_can('um_writer')) {
        // Remove menu items
        remove_menu_page('index.php');                   // Dashboard
        remove_menu_page('edit.php');                    // Posts
        remove_menu_page('upload.php');                  // Media
        remove_menu_page('edit.php?post_type=page');     // Pages
        remove_menu_page('edit-comments.php');           // Comments
        remove_menu_page('themes.php');                  // Appearance
        remove_menu_page('plugins.php');                 // Plugins
        remove_menu_page('users.php');                   // Users
        remove_menu_page('tools.php');                   // Tools
        remove_menu_page('options-general.php');         // Settings

        // Remove Contact Form 7 menu item
        remove_menu_page('wpcf7'); // 'wpcf7' is the menu slug for Contact Form 7

        // Remove custom post type 'testimonials' menu item
        remove_menu_page('edit.php?post_type=wp-testimonial'); // Replace 'testimonials' with your CPT slug

    }
}
add_action('admin_menu', 'restrict_admin_menu');

// Hide the top menu bar items
function hide_admin_bar_items($wp_admin_bar)
{
    if (current_user_can('um_writer')) {
        $wp_admin_bar->remove_node('wp-logo'); // WordPress logo
        // $wp_admin_bar->remove_node('site-name'); // Site Name
        $wp_admin_bar->remove_node('updates'); // Updates
        $wp_admin_bar->remove_node('comments'); // Comments
        $wp_admin_bar->remove_node('new-content'); // New Content
        // Add more as needed
    }
}
add_action('admin_bar_menu', 'hide_admin_bar_items', 999);

function customize_books_views($views)
{
    $screen = get_current_screen();
    if ($screen->post_type === 'wp-book') {
        $user_id = get_current_user_id();

        // Query counts for the current user
        $args = array(
            'post_type' => 'wp-book',
            'author' => $user_id,
            'fields' => 'ids',
            'posts_per_page' => -1
        );

        // Query for all books by the current user
        $all_books = new WP_Query($args);
        $all_count = $all_books->found_posts;

        // Query for published books by the current user
        $args['post_status'] = 'publish';
        $published_books = new WP_Query($args);
        $published_count = $published_books->found_posts;

        // Query for pending books by the current user
        $args['post_status'] = 'pending';
        $pending_books = new WP_Query($args);
        $pending_count = $pending_books->found_posts;

        // Customize the view counts
        $views['all'] = '<a href="' . admin_url('edit.php?post_type=wp-book') . '">All (' . $all_count . ')</a>';
        $views['publish'] = '<a href="' . admin_url('edit.php?post_type=wp-book&post_status=publish') . '">Published (' . $published_count . ')</a>';
        $views['pending'] = '<a href="' . admin_url('edit.php?post_type=wp-book&post_status=pending') . '">Pending (' . $pending_count . ')</a>';

        return $views;
    }

    return $views;
}
add_filter('views_edit-wp-book', 'customize_books_views');