<?php

add_theme_support('post-thumbnails');
add_theme_support('custom-logo');

/**
 * Proper way to enqueue scripts and styles
 */
function wpdocs_theme_name_scripts()
{
    wp_enqueue_style('design', get_template_directory_uri() . '/assets/css/stylesheet.css');
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}

add_action('wp_enqueue_scripts', 'wpdocs_theme_name_scripts');
