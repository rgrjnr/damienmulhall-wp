<?php

require "carbon.php";

add_theme_support('post-thumbnails');
add_theme_support('custom-logo');


/**
 * Register menu
 */

function rgrjnr_register_my_menus()
{
    register_nav_menus(
        array(
            'header-menu' => __('Header Menu')
        )
    );
}

add_action('init', 'rgrjnr_register_my_menus');



function remove_admin_login_header()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}

add_action('get_header', 'remove_admin_login_header');

add_filter('xmlrpc_enabled', '__return_false');

/**
 * Enqueue scripts and styles
 */
function rgrjnr_enqueue_assets()
{
    // Enqueue compiled CSS files
    wp_enqueue_style('theme-main-style', get_template_directory_uri() . '/assets/dist/css/stylesheet.css', array(), '1.0.0');
    wp_enqueue_style('theme-tailwind', get_template_directory_uri() . '/assets/dist/css/tailwind.css', array(), '1.0.0');
    
    // Enqueue compiled JavaScript
    wp_enqueue_script('theme-main-script', get_template_directory_uri() . '/assets/dist/js/bundle.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'rgrjnr_enqueue_assets');
