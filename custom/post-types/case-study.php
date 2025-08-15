<?php
/**
 * Case Study Custom Post Type
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'rgrjnr_register_case_study_post_type');

/**
 * Register Case Study custom post type
 *
 * @return void
 */
function rgrjnr_register_case_study_post_type()
{
    $labels = array(
        'name'                  => _x('Case Studies', 'Post Type General Name', 'rgrjnr'),
        'singular_name'         => _x('Case Study', 'Post Type Singular Name', 'rgrjnr'),
        'menu_name'             => __('Case Studies', 'rgrjnr'),
        'name_admin_bar'        => __('Case Studies', 'rgrjnr'),
        'archives'              => __('Case Study Archives', 'rgrjnr'),
        'attributes'            => __('Case Study Attributes', 'rgrjnr'),
        'parent_item_colon'     => __('Parent Case Study:', 'rgrjnr'),
        'all_items'             => __('All Case Studies', 'rgrjnr'),
        'add_new_item'          => __('Add New Case Study', 'rgrjnr'),
        'add_new'               => __('Add New', 'rgrjnr'),
        'new_item'              => __('New Case Study', 'rgrjnr'),
        'edit_item'             => __('Edit Case Study', 'rgrjnr'),
        'update_item'           => __('Update Case Study', 'rgrjnr'),
        'view_item'             => __('View Case Study', 'rgrjnr'),
        'view_items'            => __('View Case Studies', 'rgrjnr'),
        'search_items'          => __('Search Case Studies', 'rgrjnr'),
        'not_found'             => __('Not found', 'rgrjnr'),
        'not_found_in_trash'    => __('Not found in Trash', 'rgrjnr'),
        'featured_image'        => __('Case Study Featured Image', 'rgrjnr'),
        'set_featured_image'    => __('Set case study featured image', 'rgrjnr'),
        'remove_featured_image' => __('Remove case study featured image', 'rgrjnr'),
        'use_featured_image'    => __('Use as case study featured image', 'rgrjnr'),
        'insert_into_item'      => __('Insert into case study', 'rgrjnr'),
        'uploaded_to_this_item' => __('Uploaded to this case study', 'rgrjnr'),
        'items_list'            => __('Case studies list', 'rgrjnr'),
        'items_list_navigation' => __('Case studies list navigation', 'rgrjnr'),
        'filter_items_list'     => __('Filter case studies list', 'rgrjnr'),
    );

    $args = array(
        'label'                 => __('Case Study', 'rgrjnr'),
        'description'           => __('Client case studies and project showcases', 'rgrjnr'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('case-study', $args);
}

// Customize title placeholder for case studies
add_filter('enter_title_here', 'rgrjnr_case_study_title_placeholder', 10, 2);
function rgrjnr_case_study_title_placeholder($title, $post) {
    if ($post->post_type === 'case-study') {
        $title = 'Case study title';
    }
    return $title;
}