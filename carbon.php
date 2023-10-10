<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'rgrjnr_attach_theme_options');
function rgrjnr_attach_theme_options()
{
    Container::make('theme_options', __('Theme Options'))
        ->add_fields(array(
            Field::make('text', 'theme_copyright', 'Theme Color'),
        ))
        ->add_fields(array(
            Field::make('text', 'theme_whatsapp', 'Theme Color'),
        ))
        ->add_fields(array(
            Field::make('text', 'theme_address', 'Theme Color'),
        ))
        ->add_fields(array(
            Field::make('text', 'theme_x', 'Theme Color'),
        ))
        ->add_fields(array(
            Field::make('color', 'theme_color', 'Theme Color'),
        ));
}

add_action('after_setup_theme', 'rgrjnr_crb_load');
function rgrjnr_crb_load()
{
    require_once('vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}