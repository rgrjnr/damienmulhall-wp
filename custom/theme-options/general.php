<?php
/**
 * General Theme Options
 *
 * @package WPThemeStarter
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('carbon_fields_register_fields', 'rgrjnr_attach_theme_options');

/**
 * Attach theme options fields
 *
 * @return void
 */
function rgrjnr_attach_theme_options()
{
    Container::make('theme_options', __('Theme Options', 'rgrjnr'))
        ->set_page_parent('themes.php')
        ->add_tab(__('General', 'rgrjnr'), [
            Field::make('text', 'rgrjnr_site_tagline', __('Site Tagline', 'rgrjnr'))
                ->set_help_text(__('A short tagline for your website.', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_footer_text', __('Footer Copyright Text', 'rgrjnr'))
                ->set_help_text(__('Text to display in the website footer.', 'rgrjnr')),
            
            Field::make('image', 'rgrjnr_site_logo', __('Site Logo', 'rgrjnr'))
                ->set_help_text(__('Upload a logo for your website.', 'rgrjnr')),
        ])
        ->add_tab(__('Contact Information', 'rgrjnr'), [
            Field::make('text', 'rgrjnr_contact_phone', __('Phone Number', 'rgrjnr'))
                ->set_attribute('placeholder', '(555) 123-4567'),
            
            Field::make('text', 'rgrjnr_contact_email', __('Email Address', 'rgrjnr'))
                ->set_attribute('type', 'email')
                ->set_attribute('placeholder', 'info@example.com'),
            
            Field::make('textarea', 'rgrjnr_contact_address', __('Business Address', 'rgrjnr'))
                ->set_help_text(__('Physical address of your business.', 'rgrjnr')),
        ])
        ->add_tab(__('Social Media', 'rgrjnr'), [
            Field::make('text', 'rgrjnr_social_facebook', __('Facebook URL', 'rgrjnr'))
                ->set_attribute('placeholder', 'https://facebook.com/yourpage'),
            
            Field::make('text', 'rgrjnr_social_twitter', __('Twitter/X URL', 'rgrjnr'))
                ->set_attribute('placeholder', 'https://twitter.com/youraccount'),
            
            Field::make('text', 'rgrjnr_social_linkedin', __('LinkedIn URL', 'rgrjnr'))
                ->set_attribute('placeholder', 'https://linkedin.com/company/yourcompany'),
            
            Field::make('text', 'rgrjnr_social_instagram', __('Instagram URL', 'rgrjnr'))
                ->set_attribute('placeholder', 'https://instagram.com/youraccount'),
            
            Field::make('text', 'rgrjnr_social_youtube', __('YouTube URL', 'rgrjnr'))
                ->set_attribute('placeholder', 'https://youtube.com/c/yourchannel'),
        ])
        ->add_tab(__('Analytics & Scripts', 'rgrjnr'), [
            Field::make('textarea', 'rgrjnr_google_analytics', __('Google Analytics Code', 'rgrjnr'))
                ->set_help_text(__('Paste your Google Analytics tracking code here.', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_header_scripts', __('Header Scripts', 'rgrjnr'))
                ->set_help_text(__('Scripts to be added to the &lt;head&gt; section.', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_footer_scripts', __('Footer Scripts', 'rgrjnr'))
                ->set_help_text(__('Scripts to be added before the closing &lt;/body&gt; tag.', 'rgrjnr')),
        ]);
}