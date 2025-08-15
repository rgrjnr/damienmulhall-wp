<?php
/**
 * Custom Components Autoloader
 * 
 * This file loads all custom post types, taxonomies, fields, blocks, and theme options.
 * Include this file in your theme to load all Carbon Fields customizations.
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load all custom post types
 */
$post_types_dir = get_template_directory() . '/custom/post-types/';
if (is_dir($post_types_dir)) {
    foreach (glob($post_types_dir . '*.php') as $file) {
        require_once $file;
    }
}

/**
 * Load all custom taxonomies
 */
$taxonomies_dir = get_template_directory() . '/custom/taxonomies/';
if (is_dir($taxonomies_dir)) {
    foreach (glob($taxonomies_dir . '*.php') as $file) {
        require_once $file;
    }
}

/**
 * Load all custom fields
 */
$fields_dir = get_template_directory() . '/custom/fields/';
if (is_dir($fields_dir)) {
    foreach (glob($fields_dir . '*.php') as $file) {
        require_once $file;
    }
}

/**
 * Load all custom blocks
 */
$blocks_dir = get_template_directory() . '/custom/blocks/';
if (is_dir($blocks_dir)) {
    foreach (glob($blocks_dir . '*.php') as $file) {
        require_once $file;
    }
}

/**
 * Load all theme options
 */
$theme_options_dir = get_template_directory() . '/custom/theme-options/';
if (is_dir($theme_options_dir)) {
    foreach (glob($theme_options_dir . '*.php') as $file) {
        require_once $file;
    }
}