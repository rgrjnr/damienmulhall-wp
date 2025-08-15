<?php
/**
 * Highlights Taxonomy
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'rgrjnr_register_highlights_taxonomy');

/**
 * Register Highlights taxonomy for Case Study post type
 *
 * @return void
 */
function rgrjnr_register_highlights_taxonomy()
{
    $labels = [
        'name'              => _x('Highlights', 'taxonomy general name', 'rgrjnr'),
        'singular_name'     => _x('Highlight', 'taxonomy singular name', 'rgrjnr'),
        'search_items'      => __('Search Highlights', 'rgrjnr'),
        'all_items'         => __('All Highlights', 'rgrjnr'),
        'parent_item'       => __('Parent Highlight', 'rgrjnr'),
        'parent_item_colon' => __('Parent Highlight:', 'rgrjnr'),
        'edit_item'         => __('Edit Highlight', 'rgrjnr'),
        'update_item'       => __('Update Highlight', 'rgrjnr'),
        'add_new_item'      => __('Add New Highlight', 'rgrjnr'),
        'new_item_name'     => __('New Highlight Name', 'rgrjnr'),
        'menu_name'         => __('Highlights', 'rgrjnr'),
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'highlight'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('highlights', ['case-study'], $args);
}