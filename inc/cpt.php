<?php
function wcss_register_custom_post_types() {
    
    // Register Instructors
    $labels = array(
        'name'                  => _x( 'Instructors', 'post type general name' ),
        'singular_name'         => _x( 'Instructor', 'post type singular name'),
        'menu_name'             => _x( 'Instructors', 'admin menu' ),
        'name_admin_bar'        => _x( 'Instructor', 'add new on admin bar' ),
        'add_new'               => _x( 'Add New', 'instructor' ),
        'add_new_item'          => __( 'Add New Instructor' ),
        'new_item'              => __( 'New Instructor' ),
        'edit_item'             => __( 'Edit Instructor' ),
        'view_item'             => __( 'View Instructor' ),
        'all_items'             => __( 'All Instructors' ),
        'search_items'          => __( 'Search Instructors' ),
        'parent_item_colon'     => __( 'Parent Instructors:' ),
        'not_found'             => __( 'No instructors found.' ),
        'not_found_in_trash'    => __( 'No instructors found in Trash.' ),
        'archives'              => __( 'Instructor Archives'),
        'insert_into_item'      => __( 'Insert into instructor'),
        'uploaded_to_this_item' => __( 'Uploaded to this instructor'),
        'filter_item_list'      => __( 'Filter instructors list'),
        'items_list_navigation' => __( 'Instructors list navigation'),
        'items_list'            => __( 'Instructors list'),
        'featured_image'        => __( 'Instructor featured image'),
        'set_featured_image'    => __( 'Set instructor featured image'),
        'remove_featured_image' => __( 'Remove instructor featured image'),
        'use_featured_image'    => __( 'Use as featured image'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'instructors' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-businessperson',
        'supports'           => array( 'title', 'thumbnail', 'editor' ),
    );

    register_post_type( 'wcss-instructors', $args );


    // Register Testimonials

    $labels = array(
        'name'               => _x( 'Testimonials', 'post type general name'  ),
        'singular_name'      => _x( 'Testimonial', 'post type singular name'  ),
        'menu_name'          => _x( 'Testimonials', 'admin menu'  ),
        'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar' ),
        'add_new'            => _x( 'Add New', 'testimonial' ),
        'add_new_item'       => __( 'Add New Testimonial' ),
        'new_item'           => __( 'New Testimonial' ),
        'edit_item'          => __( 'Edit Testimonial' ),
        'view_item'          => __( 'View Testimonial'  ),
        'all_items'          => __( 'All Testimonials' ),
        'search_items'       => __( 'Search Testimonials' ),
        'parent_item_colon'  => __( 'Parent Testimonials:' ),
        'not_found'          => __( 'No testimonials found.' ),
        'not_found_in_trash' => __( 'No testimonials found in Trash.' ),
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_rest'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'testimonials' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 7,
        'menu_icon'          => 'dashicons-heart',
        'supports'           => array( 'title', 'editor' ),
        'template'           => array( array( 'core/pullquote' ) ),
        'template_lock'      => 'all'
    );
    
    register_post_type( 'wcss-testimonial', $args );
}
add_action( 'init', 'wcss_register_custom_post_types' );