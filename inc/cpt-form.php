<?php
function create_service_post_type()
{
    $labels = array(
        'name' => __('Books', 'post type general name'),
        'singular_name' => __('Book', 'post type singular name'),
        'add_new' => __('Add New', 'Specialty'),
        'add_new_item' => __('Add New Book'),
        'edit_item' => __('Edit Book'),
        'new_item' => __('New Book'),
        'view_item' => __('View Book'),
        'search_items' => __('Search Books'),
        'not_found' => __('No books found'),
        'not_found_in_trash' => __('No books found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Books'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'book'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'comments'),
        'template' => array(
            array('core/paragraph'),
            // array('core/button'),
        ),
        'template_lock' => "all"
    );

    register_post_type('wp-book', $args);


    $labels = array(
        'name' => __('Testimonials', 'post type testimonial name'),
        'singular_name' => __('Testimonial', 'post type testimonial name'),
        'add_new' => __('Add New', 'Specialty'),
        'add_new_item' => __('Add New Testimonial'),
        'edit_item' => __('Edit Testimonial'),
        'new_item' => __('New Testimonial'),
        'view_item' => __('View Testimonial'),
        'search_items' => __('Search Testimonials'),
        'not_found' => __('No Testimonials found'),
        'not_found_in_trash' => __('No Testimonials found in Trash'),
        'parent_item_colon' => '',
        'menu_name' => 'Testimonials'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'testimonial'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-admin-users',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'template' => array(
            array('core/paragraph'),
        ),
        'template_lock' => "all"
    );

    register_post_type('wp-testimonial', $args);
}
add_action('init', 'create_service_post_type');


function create_book_taxonomies()
{
    // Genres (Hierarchical)
    $genre_labels = array(
        'name' => _x('Genres', 'Taxonomy General Name', 'textdomain'),
        'singular_name' => _x('Genre', 'Taxonomy Singular Name', 'textdomain'),
        'menu_name' => __('Genres', 'textdomain'),
        'all_items' => __('All Genres', 'textdomain'),  // Label for the "All items" page
        'edit_item' => __('Edit Genre', 'textdomain'),  // Label for the "Edit item" page
        'view_item' => __('View Genre', 'textdomain'),  // Label for the "View item" page
        'update_item' => __('Update Genre', 'textdomain'),  // Label for the "Update item" page
        'add_new_item' => __('Add New Genre', 'textdomain'),  // Label for the "Add new item" page
        'new_item_name' => __('New Genre Name', 'textdomain'),  // Label for the "New item name" field
        'parent_item' => __('Parent Genre', 'textdomain'),  // Label for the "Parent item" field (if hierarchical)
        'parent_item_colon' => __('Parent Genre:', 'textdomain'),  // Label for the "Parent item" field with colon (if hierarchical)
        'search_items' => __('Search Genres', 'textdomain'),  // Label for the "Search items" field
        'popular_items' => __('Popular Genres', 'textdomain'),  // Label for the "Popular items" section (if non-hierarchical)
        'separate_items_with_commas' => __('Separate genres with commas', 'textdomain'),  // Instruction for the "Separate items with commas" field
        'add_or_remove_items' => __('Add or remove genres', 'textdomain'),  // Instruction for the "Add or remove items" field
        'choose_from_most_used' => __('Choose from the most used genres', 'textdomain'),  // Instruction for the "Choose from most used" field
        'not_found' => __('No genres found.', 'textdomain'),  // Message when no items are found
    );

    $genre_args = array(
        'labels' => $genre_labels,
        'hierarchical' => true,  // Hierarchical taxonomy for genres
        'public' => true,
        'show_admin_column' => true,
        'rewrite' => array('slug' => 'genre'),
    );

    register_taxonomy('genre', array('wp-book'), $genre_args);

}

add_action('init', 'create_book_taxonomies');
