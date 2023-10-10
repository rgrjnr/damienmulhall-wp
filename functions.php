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
