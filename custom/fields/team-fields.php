<?php
/**
 * Team Member Custom Fields
 *
 * @package WPThemeStarter
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('carbon_fields_register_fields', 'rgrjnr_attach_team_fields');

/**
 * Attach custom fields to Team post type
 *
 * @return void
 */
function rgrjnr_attach_team_fields()
{
    Container::make('post_meta', __('Team Member Details', 'rgrjnr'))
        ->where('post_type', '=', 'team')
        ->add_fields(array(
            Field::make('text', 'rgrjnr_team_position', __('Position/Title', 'rgrjnr'))
                ->set_attribute('placeholder', __('e.g., Senior Developer, Project Manager', 'rgrjnr'))
                ->set_help_text(__('The team member\'s job title or position within the company.', 'rgrjnr')),
            
            Field::make('textarea', 'rgrjnr_team_bio', __('Biography', 'rgrjnr'))
                ->set_rows(4)
                ->set_help_text(__('A brief biography or description of the team member.', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_team_email', __('Email Address', 'rgrjnr'))
                ->set_attribute('type', 'email')
                ->set_attribute('placeholder', __('email@example.com', 'rgrjnr'))
                ->set_help_text(__('Team member\'s email address (optional).', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_team_phone', __('Phone Number', 'rgrjnr'))
                ->set_attribute('placeholder', __('(555) 123-4567', 'rgrjnr'))
                ->set_help_text(__('Team member\'s phone number (optional).', 'rgrjnr')),
        ));

    Container::make('post_meta', __('Social Media Links', 'rgrjnr'))
        ->where('post_type', '=', 'team')
        ->add_fields(array(
            Field::make('text', 'rgrjnr_team_linkedin', __('LinkedIn URL', 'rgrjnr'))
                ->set_attribute('placeholder', __('https://linkedin.com/in/username', 'rgrjnr'))
                ->set_help_text(__('Link to LinkedIn profile.', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_team_twitter', __('Twitter/X URL', 'rgrjnr'))
                ->set_attribute('placeholder', __('https://twitter.com/username', 'rgrjnr'))
                ->set_help_text(__('Link to Twitter/X profile.', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_team_facebook', __('Facebook URL', 'rgrjnr'))
                ->set_attribute('placeholder', __('https://facebook.com/username', 'rgrjnr'))
                ->set_help_text(__('Link to Facebook profile.', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_team_instagram', __('Instagram URL', 'rgrjnr'))
                ->set_attribute('placeholder', __('https://instagram.com/username', 'rgrjnr'))
                ->set_help_text(__('Link to Instagram profile.', 'rgrjnr')),
            
            Field::make('text', 'rgrjnr_team_website', __('Personal Website', 'rgrjnr'))
                ->set_attribute('placeholder', __('https://example.com', 'rgrjnr'))
                ->set_help_text(__('Link to personal website or portfolio.', 'rgrjnr')),
        ));

    Container::make('post_meta', __('Additional Information', 'rgrjnr'))
        ->where('post_type', '=', 'team')
        ->add_fields(array(
            Field::make('select', 'rgrjnr_team_status', __('Employment Status', 'rgrjnr'))
                ->set_options(array(
                    'full-time' => __('Full-time', 'rgrjnr'),
                    'part-time' => __('Part-time', 'rgrjnr'),
                    'contractor' => __('Contractor', 'rgrjnr'),
                    'consultant' => __('Consultant', 'rgrjnr'),
                    'intern' => __('Intern', 'rgrjnr'),
                ))
                ->set_default_value('full-time')
                ->set_help_text(__('The team member\'s employment status.', 'rgrjnr')),
            
            Field::make('date', 'rgrjnr_team_start_date', __('Start Date', 'rgrjnr'))
                ->set_help_text(__('When the team member joined the company.', 'rgrjnr')),
            
            Field::make('checkbox', 'rgrjnr_team_featured', __('Featured Team Member', 'rgrjnr'))
                ->set_option_value('yes')
                ->set_help_text(__('Check to feature this team member prominently on the website.', 'rgrjnr')),
            
            Field::make('complex', 'rgrjnr_team_skills', __('Skills & Expertise', 'rgrjnr'))
                ->set_layout('tabbed-horizontal')
                ->add_fields(array(
                    Field::make('text', 'skill_name', __('Skill/Technology', 'rgrjnr'))
                        ->set_width(70)
                        ->set_required(true),
                    Field::make('select', 'skill_level', __('Proficiency Level', 'rgrjnr'))
                        ->set_width(30)
                        ->set_options(array(
                            'beginner' => __('Beginner', 'rgrjnr'),
                            'intermediate' => __('Intermediate', 'rgrjnr'),
                            'advanced' => __('Advanced', 'rgrjnr'),
                            'expert' => __('Expert', 'rgrjnr'),
                        ))
                        ->set_default_value('intermediate'),
                ))
                ->set_header_template('<%- skill_name %> <% if (skill_level) { %>(<%= skill_level %>)<% } %>')
                ->set_help_text(__('Add skills and technologies the team member is proficient in.', 'rgrjnr')),
        ));
}