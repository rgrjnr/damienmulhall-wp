<?php
/**
 * Homepage Content Theme Options
 *
 * @package WPThemeStarter
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('carbon_fields_register_fields', 'rgrjnr_attach_homepage_options');

/**
 * Attach homepage content fields
 *
 * @return void
 */
function rgrjnr_attach_homepage_options()
{
    Container::make('theme_options', __('Theme Options', 'rgrjnr'))
        ->set_page_parent('themes.php')
        ->add_tab(__('Homepage Content', 'rgrjnr'), [
            
            // About Section
            Field::make('separator', 'rgrjnr_about_separator', __('About Section', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_about_main_text', __('Main About Text', 'rgrjnr'))
                ->set_help_text(__('The main paragraph in the cyan block.', 'rgrjnr'))
                ->set_default_value('My background is in media production, so I naturally gravitate toward structure, story, and the bigger picture. I\'m not tied to a single methodology or buzzword. What matters is making things happen—and making the process easier for everyone involved.'),
            
            Field::make('textarea', 'rgrjnr_about_secondary_text', __('Secondary About Text', 'rgrjnr'))
                ->set_help_text(__('The secondary paragraph in the second cyan block.', 'rgrjnr'))
                ->set_default_value('I\'ve helped launch podcasts with 100,000+ downloads, built internal playbooks that actually get used, and run campaigns across formats, teams, and time zones. But this isn\'t about the biggest project or the flashiest brand.'),
            
            // What I Do
            Field::make('separator', 'rgrjnr_what_i_do_separator', __('What I Do Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_what_i_do_title', __('What I Do Title', 'rgrjnr'))
                ->set_default_value('What I Do'),
            
            Field::make('text', 'rgrjnr_what_i_do_line1', __('What I Do - Line 1', 'rgrjnr'))
                ->set_default_value('Lead Creative Projects End-to-End'),
            
            Field::make('text', 'rgrjnr_what_i_do_line2', __('What I Do - Line 2', 'rgrjnr'))
                ->set_default_value('Translate Strategy into Execution'),
            
            Field::make('text', 'rgrjnr_what_i_do_line3', __('What I Do - Line 3', 'rgrjnr'))
                ->set_default_value('Align Stakeholders & Deliver Results'),
            
            // What I Deliver
            Field::make('separator', 'rgrjnr_what_i_deliver_separator', __('What I Deliver Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_what_i_deliver_title', __('What I Deliver Title', 'rgrjnr'))
                ->set_default_value('What I Deliver'),
            
            Field::make('text', 'rgrjnr_what_i_deliver_line1', __('What I Deliver - Line 1', 'rgrjnr'))
                ->set_default_value('Content That Performs'),
            
            Field::make('text', 'rgrjnr_what_i_deliver_line2', __('What I Deliver - Line 2', 'rgrjnr'))
                ->set_default_value('Projects On Time & On Budget'),
            
            Field::make('text', 'rgrjnr_what_i_deliver_line3', __('What I Deliver - Line 3', 'rgrjnr'))
                ->set_default_value('Clear, Actionable Comms'),
            
            // What To Expect
            Field::make('separator', 'rgrjnr_what_to_expect_separator', __('What To Expect Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_what_to_expect_title', __('What To Expect Title', 'rgrjnr'))
                ->set_default_value('What To Expect'),
            
            Field::make('text', 'rgrjnr_what_to_expect_line1', __('What To Expect - Line 1', 'rgrjnr'))
                ->set_default_value('Sharp Thinking'),
            
            Field::make('text', 'rgrjnr_what_to_expect_line2', __('What To Expect - Line 2', 'rgrjnr'))
                ->set_default_value('Calm Leadership'),
            
            Field::make('text', 'rgrjnr_what_to_expect_line3', __('What To Expect - Line 3', 'rgrjnr'))
                ->set_default_value('No-Fluff Delivery'),
            
            // Tools Block
            Field::make('separator', 'rgrjnr_tools_block_separator', __('Tools Block', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_tools_block_text', __('Tools Block Text', 'rgrjnr'))
                ->set_help_text(__('The text that appears in the tools block.', 'rgrjnr'))
                ->set_default_value('I\'m not the designer or the developer. I\'m just the project manager who clears the path so they can do their best work—on time, on budget, and without the chaos.'),
            
            // Skills Section
            Field::make('separator', 'rgrjnr_skills_separator', __('Skills Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_skills_title', __('Skills Title', 'rgrjnr'))
                ->set_default_value('Skills'),
            
            Field::make('textarea', 'rgrjnr_skills_text', __('Skills Text', 'rgrjnr'))
                ->set_default_value('Waterfall / Budgeting / Planning / Client & Stakeholder Management / Creative Studio Management'),
            
            // Certifications Section
            Field::make('separator', 'rgrjnr_certifications_separator', __('Certifications Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_certifications_title', __('Certifications Title', 'rgrjnr'))
                ->set_default_value('Certifications'),
            
            Field::make('textarea', 'rgrjnr_certifications_text', __('Certifications Text', 'rgrjnr'))
                ->set_default_value('PMP / Google Project Management / Agile Project Management / Project Planning / Project Execution'),
            
            // Expertise Section
            Field::make('separator', 'rgrjnr_expertise_separator', __('Expertise Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_expertise_title', __('Expertise Title', 'rgrjnr'))
                ->set_default_value('Expertise'),
            
            Field::make('textarea', 'rgrjnr_expertise_text', __('Expertise Text', 'rgrjnr'))
                ->set_default_value('Sales Enablement / Webinars & Live Events / Podcasts / Product Launches / Community Events / Demand Generation Campaigns / Rich Media Content'),
            
            // Tools Section
            Field::make('separator', 'rgrjnr_tools_separator', __('Tools Section', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_tools_title', __('Tools Title', 'rgrjnr'))
                ->set_default_value('Tools'),
            
            Field::make('textarea', 'rgrjnr_tools_text', __('Tools Text', 'rgrjnr'))
                ->set_default_value('Google Workspace / Office 365 / Sharepoint / Adobe CC / Riverside FM / Trello'),
            
            // CTA Section
            Field::make('separator', 'rgrjnr_cta_separator', __('CTA Section', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_cta_heading', __('CTA Heading', 'rgrjnr'))
                ->set_help_text(__('The main heading in the CTA section.', 'rgrjnr'))
                ->set_default_value('Work with me, and see how smooth, focused projects really feel.'),
            
            Field::make('text', 'rgrjnr_cta_button_text', __('CTA Button Text', 'rgrjnr'))
                ->set_default_value('Let\'s work'),
            
            Field::make('text', 'rgrjnr_cta_button_link', __('CTA Button Link', 'rgrjnr'))
                ->set_default_value('mailto:contact@damienmulhall.com'),
        ]);
}