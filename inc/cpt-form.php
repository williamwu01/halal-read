<?php
function create_service_post_type() {
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
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'template' => array(
            array('core/paragraph'),
            // array('core/button'),
        ),
				'template_lock'=>'all',
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
			'menu_icon' => 'dashicons-admin-tools',
			'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
			'template' => array(
					array('core/paragraph'),
					array('core/heading'),
			),
	);

	register_post_type('wp-testimonial', $args);
}
add_action('init', 'create_service_post_type');
