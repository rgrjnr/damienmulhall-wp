<?php
/**
 * Team Custom Post Type
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('init', 'rgrjnr_register_team_post_type');

/**
 * Register Team custom post type
 *
 * @return void
 */
function rgrjnr_register_team_post_type()
{
    $labels = array(
        'name'                  => _x('Team Members', 'Post Type General Name', 'rgrjnr'),
        'singular_name'         => _x('Team Member', 'Post Type Singular Name', 'rgrjnr'),
        'menu_name'             => __('Team Members', 'rgrjnr'),
        'name_admin_bar'        => __('Team Members', 'rgrjnr'),
        'archives'              => __('Team Archives', 'rgrjnr'),
        'attributes'            => __('Team Attributes', 'rgrjnr'),
        'parent_item_colon'     => __('Parent Team Member:', 'rgrjnr'),
        'all_items'             => __('All Team Members', 'rgrjnr'),
        'add_new_item'          => __('Add New Team Member', 'rgrjnr'),
        'add_new'               => __('Add New', 'rgrjnr'),
        'new_item'              => __('New Team Member', 'rgrjnr'),
        'edit_item'             => __('Edit Team Member', 'rgrjnr'),
        'update_item'           => __('Update Team Member', 'rgrjnr'),
        'view_item'             => __('View Team Member', 'rgrjnr'),
        'view_items'            => __('View Team Members', 'rgrjnr'),
        'search_items'          => __('Search Team Members', 'rgrjnr'),
        'not_found'             => __('Not found', 'rgrjnr'),
        'not_found_in_trash'    => __('Not found in Trash', 'rgrjnr'),
        'featured_image'        => __('Team Member Photo', 'rgrjnr'),
        'set_featured_image'    => __('Set team member photo', 'rgrjnr'),
        'remove_featured_image' => __('Remove team member photo', 'rgrjnr'),
        'use_featured_image'    => __('Use as team member photo', 'rgrjnr'),
        'insert_into_item'      => __('Insert into team member', 'rgrjnr'),
        'uploaded_to_this_item' => __('Uploaded to this team member', 'rgrjnr'),
        'items_list'            => __('Team members list', 'rgrjnr'),
        'items_list_navigation' => __('Team members list navigation', 'rgrjnr'),
        'filter_items_list'     => __('Filter team members list', 'rgrjnr'),
    );

    $args = array(
        'label'                 => __('Team Member', 'rgrjnr'),
        'description'           => __('Team member profiles and information', 'rgrjnr'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 25,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
    );

    register_post_type('team', $args);
}