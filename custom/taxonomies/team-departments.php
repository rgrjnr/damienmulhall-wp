<?php
/**
 * Team Departments Taxonomy
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'rgrjnr_register_team_departments_taxonomy');

/**
 * Register Team Departments taxonomy
 *
 * @return void
 */
function rgrjnr_register_team_departments_taxonomy()
{
    $labels = [
        'name'              => _x('Departments', 'taxonomy general name', 'rgrjnr'),
        'singular_name'     => _x('Department', 'taxonomy singular name', 'rgrjnr'),
        'search_items'      => __('Search Departments', 'rgrjnr'),
        'all_items'         => __('All Departments', 'rgrjnr'),
        'parent_item'       => __('Parent Department', 'rgrjnr'),
        'parent_item_colon' => __('Parent Department:', 'rgrjnr'),
        'edit_item'         => __('Edit Department', 'rgrjnr'),
        'update_item'       => __('Update Department', 'rgrjnr'),
        'add_new_item'      => __('Add New Department', 'rgrjnr'),
        'new_item_name'     => __('New Department Name', 'rgrjnr'),
        'menu_name'         => __('Departments', 'rgrjnr'),
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'department'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('team_department', ['team'], $args);
}