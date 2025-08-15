<?php
/**
 * Carbon Fields Initialization
 *
 * @package WPThemeStarter
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', 'rgrjnr_crb_load', 1);

/**
 * Load and initialize Carbon Fields
 *
 * @return void
 */
function rgrjnr_crb_load()
{
    // Load Carbon Fields via Composer
    require_once('vendor/autoload.php');
    
    // Boot Carbon Fields
    \Carbon_Fields\Carbon_Fields::boot();
}

// Load all custom components after theme setup but before carbon_fields_register_fields runs
add_action('after_setup_theme', function() {
    // Load custom components after Carbon Fields is loaded
    require_once(get_template_directory() . '/custom/index.php');
}, 10);
