<?php
/**
 * Team Showcase Block
 *
 * @package WPThemeStarter
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get team departments for select field
 */
function rgrjnr_get_team_departments() {
    $options = [];
    $terms = get_terms([
        'taxonomy' => 'team_department',
        'hide_empty' => false,
    ]);
    
    if (!is_wp_error($terms) && !empty($terms)) {
        foreach ($terms as $term) {
            $options[$term->term_id] = $term->name;
        }
    }
    
    return $options;
}

add_action('carbon_fields_register_fields', 'rgrjnr_register_team_showcase_block');

/**
 * Register Team Showcase block
 *
 * @return void
 */
function rgrjnr_register_team_showcase_block()
{
    Block::make(__('Team Showcase', 'rgrjnr'))
        ->add_fields([
            Field::make('text', 'heading', __('Block Heading', 'rgrjnr'))
                ->set_default_value(__('Meet Our Team', 'rgrjnr')),
            
            Field::make('textarea', 'description', __('Description', 'rgrjnr'))
                ->set_help_text(__('Optional description text to display above the team members.', 'rgrjnr')),
            
            Field::make('select', 'display_style', __('Display Style', 'rgrjnr'))
                ->add_options([
                    'grid' => __('Grid Layout', 'rgrjnr'),
                    'carousel' => __('Carousel/Slider', 'rgrjnr'),
                    'list' => __('List Layout', 'rgrjnr'),
                ])
                ->set_default_value('grid'),
            
            Field::make('select', 'columns', __('Columns (Grid Only)', 'rgrjnr'))
                ->add_options([
                    '2' => __('2 Columns', 'rgrjnr'),
                    '3' => __('3 Columns', 'rgrjnr'),
                    '4' => __('4 Columns', 'rgrjnr'),
                ])
                ->set_default_value('3')
                ->set_conditional_logic([
                    [
                        'field' => 'display_style',
                        'value' => 'grid',
                    ]
                ]),
            
            Field::make('select', 'team_filter', __('Filter Team Members', 'rgrjnr'))
                ->add_options([
                    'all' => __('Show All', 'rgrjnr'),
                    'featured' => __('Featured Only', 'rgrjnr'),
                    'department' => __('By Department', 'rgrjnr'),
                ])
                ->set_default_value('all'),
            
            Field::make('multiselect', 'selected_departments', __('Select Departments', 'rgrjnr'))
                ->add_options('rgrjnr_get_team_departments')
                ->set_conditional_logic([
                    [
                        'field' => 'team_filter',
                        'value' => 'department',
                    ]
                ]),
            
            Field::make('text', 'max_posts', __('Maximum Team Members', 'rgrjnr'))
                ->set_attribute('type', 'number')
                ->set_attribute('min', '1')
                ->set_default_value('6')
                ->set_help_text(__('Maximum number of team members to display. Leave empty for no limit.', 'rgrjnr')),
            
            Field::make('checkbox', 'show_social_links', __('Show Social Media Links', 'rgrjnr'))
                ->set_default_value('yes'),
        ])
        ->set_category('widgets')
        ->set_icon('groups')
        ->set_keywords([__('team', 'rgrjnr'), __('staff', 'rgrjnr'), __('members', 'rgrjnr')])
        ->set_render_callback('rgrjnr_render_team_showcase_block');
}

/**
 * Render callback for Team Showcase block
 *
 * @param array $fields Block fields
 * @param array $attributes Block attributes
 * @param string $inner_blocks Inner blocks content
 * @return string
 */
function rgrjnr_render_team_showcase_block($fields)
{
    $heading = $fields['heading'] ?? __('Meet Our Team', 'rgrjnr');
    $description = $fields['description'] ?? '';
    $display_style = $fields['display_style'] ?? 'grid';
    $columns = $fields['columns'] ?? '3';
    $team_filter = $fields['team_filter'] ?? 'all';
    $max_posts = $fields['max_posts'] ?? 6;
    $show_social_links = $fields['show_social_links'] ?? false;
    
    // Build query arguments
    $query_args = [
        'post_type' => 'team',
        'post_status' => 'publish',
        'posts_per_page' => $max_posts ? intval($max_posts) : -1,
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ];
    
    // Apply filters
    if ($team_filter === 'featured') {
        $query_args['meta_query'] = [
            [
                'key' => '_rgrjnr_team_featured',
                'value' => 'yes',
                'compare' => '=',
            ]
        ];
    } elseif ($team_filter === 'department' && !empty($fields['selected_departments'])) {
        $department_ids = array_map(function($dept) {
            return $dept['id'];
        }, $fields['selected_departments']);
        
        $query_args['tax_query'] = [
            [
                'taxonomy' => 'team_department',
                'field' => 'term_id',
                'terms' => $department_ids,
            ]
        ];
    }
    
    $team_query = new WP_Query($query_args);
    
    if (!$team_query->have_posts()) {
        return '<p>' . __('No team members found.', 'rgrjnr') . '</p>';
    }
    
    ob_start();
    ?>
    <div class="team-showcase team-showcase--<?php echo esc_attr($display_style); ?>">
        <?php if ($heading): ?>
            <h2 class="team-showcase__heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        
        <?php if ($description): ?>
            <div class="team-showcase__description">
                <?php echo wp_kses_post(wpautop($description)); ?>
            </div>
        <?php endif; ?>
        
        <div class="team-showcase__grid team-showcase__grid--<?php echo esc_attr($columns); ?>-cols">
            <?php while ($team_query->have_posts()): $team_query->the_post(); ?>
                <div class="team-member">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="team-member__photo">
                            <?php the_post_thumbnail('medium'); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="team-member__content">
                        <h3 class="team-member__name"><?php the_title(); ?></h3>
                        
                        <?php 
                        $position = carbon_get_the_post_meta('rgrjnr_team_position');
                        if ($position): 
                        ?>
                            <p class="team-member__position"><?php echo esc_html($position); ?></p>
                        <?php endif; ?>
                        
                        <?php if (has_excerpt()): ?>
                            <div class="team-member__excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($show_social_links): ?>
                            <div class="team-member__social">
                                <?php
                                $social_links = [
                                    'linkedin' => carbon_get_the_post_meta('rgrjnr_team_linkedin'),
                                    'twitter' => carbon_get_the_post_meta('rgrjnr_team_twitter'),
                                    'facebook' => carbon_get_the_post_meta('rgrjnr_team_facebook'),
                                    'instagram' => carbon_get_the_post_meta('rgrjnr_team_instagram'),
                                    'website' => carbon_get_the_post_meta('rgrjnr_team_website'),
                                ];
                                
                                foreach ($social_links as $platform => $url):
                                    if ($url):
                                ?>
                                    <a href="<?php echo esc_url($url); ?>" class="team-member__social-link team-member__social-link--<?php echo esc_attr($platform); ?>" target="_blank" rel="noopener">
                                        <?php echo esc_html(ucfirst($platform)); ?>
                                    </a>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php
    wp_reset_postdata();
    
    return ob_get_clean();
}