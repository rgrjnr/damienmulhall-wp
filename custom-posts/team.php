<?php

// Register Custom Post Type
function rgrjnr_team_post_type()
{

    $labels = array(
        'name'                  => _x('Team Members', 'Post Type General Name', 'rgrjnr'),
        'singular_name'         => _x('Team Member', 'Post Type Singular Name', 'rgrjnr'),
        'menu_name'             => __('Team Member', 'rgrjnr'),
        'name_admin_bar'        => __('Team Members', 'rgrjnr'),
        'archives'              => __('Item Archives', 'rgrjnr'),
        'attributes'            => __('Item Attributes', 'rgrjnr'),
        'parent_item_colon'     => __('Parent Item:', 'rgrjnr'),
        'all_items'             => __('All Items', 'rgrjnr'),
        'add_new_item'          => __('Add New Item', 'rgrjnr'),
        'add_new'               => __('Add New', 'rgrjnr'),
        'new_item'              => __('New Item', 'rgrjnr'),
        'edit_item'             => __('Edit Item', 'rgrjnr'),
        'update_item'           => __('Update Item', 'rgrjnr'),
        'view_item'             => __('View Item', 'rgrjnr'),
        'view_items'            => __('View Items', 'rgrjnr'),
        'search_items'          => __('Search Item', 'rgrjnr'),
        'not_found'             => __('Not found', 'rgrjnr'),
        'not_found_in_trash'    => __('Not found in Trash', 'rgrjnr'),
        'featured_image'        => __('Featured Image', 'rgrjnr'),
        'set_featured_image'    => __('Set featured image', 'rgrjnr'),
        'remove_featured_image' => __('Remove featured image', 'rgrjnr'),
        'use_featured_image'    => __('Use as featured image', 'rgrjnr'),
        'insert_into_item'      => __('Insert into item', 'rgrjnr'),
        'uploaded_to_this_item' => __('Uploaded to this item', 'rgrjnr'),
        'items_list'            => __('Items list', 'rgrjnr'),
        'items_list_navigation' => __('Items list navigation', 'rgrjnr'),
        'filter_items_list'     => __('Filter items list', 'rgrjnr'),
    );
    $args = array(
        'label'                 => __('Team Member', 'rgrjnr'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'custom-fields'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
    );
    register_post_type('team', $args);
}
add_action('init', 'rgrjnr_team_post_type', 0);