<?php
/**
 * Case Study Custom Fields
 *
 * @package WPThemeStarter
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('carbon_fields_register_fields', 'rgrjnr_attach_case_study_fields');

/**
 * Attach custom fields to Case Study post type
 *
 * @return void
 */
function rgrjnr_attach_case_study_fields()
{
    Container::make('post_meta', __('Case Study Details', 'rgrjnr'))
        ->where('post_type', '=', 'case-study')
        ->add_fields(array(
            Field::make('text', 'rgrjnr_short_title', __('Short Title', 'rgrjnr'))
                ->set_help_text(__('A brief version of the title for use in lists or cards', 'rgrjnr')),
            Field::make('text', 'rgrjnr_client', __('Client', 'rgrjnr'))
                ->set_help_text(__('The name of the client or company', 'rgrjnr')),
            Field::make('text', 'rgrjnr_duration', __('Duration', 'rgrjnr'))
                ->set_help_text(__('e.g., "3 months" or "Jan 2024 - Mar 2024"', 'rgrjnr')),
            Field::make('image', 'rgrjnr_client_logo', __('Client Logo', 'rgrjnr'))
                ->set_help_text(__('Upload the client logo', 'rgrjnr'))
        ));
}