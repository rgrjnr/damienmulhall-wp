<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'rgrjnr_attach_theme_options');

function rgrjnr_attach_theme_options()
{
    return;
}

add_action('after_setup_theme', 'rgrjnr_crb_load');

function rgrjnr_crb_load()
{
    require_once('vendor/autoload.php');
    \Carbon_Fields\Carbon_Fields::boot();
}
