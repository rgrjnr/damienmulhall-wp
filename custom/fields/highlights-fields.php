<?php
/**
 * Highlights Taxonomy Custom Fields
 *
 * @package WPThemeStarter
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

add_action('carbon_fields_register_fields', 'rgrjnr_attach_highlights_fields');

/**
 * Attach custom fields to Highlights taxonomy
 *
 * @return void
 */
function rgrjnr_attach_highlights_fields()
{
    Container::make('term_meta', __('Highlight Settings', 'rgrjnr'))
        ->where('term_taxonomy', '=', 'highlights')
        ->add_fields(array(
            Field::make('image', 'rgrjnr_highlight_icon', __('Highlight Icon', 'rgrjnr'))
                ->set_help_text(__('Upload an icon for this highlight. SVG files are recommended for best quality and scalability.', 'rgrjnr'))
                ->set_value_type('url'),

            
            Field::make('select', 'rgrjnr_highlight_color', __('Highlight Color', 'rgrjnr'))
                ->set_options(array(
                    '#201a1e' => __('Black', 'rgrjnr'),
                    '#33a199' => __('Cyan', 'rgrjnr'),
                    '#e1dfd0' => __('White', 'rgrjnr'),
                    '#85316d' => __('Purple', 'rgrjnr'),
                    '#bf4c31' => __('Red', 'rgrjnr'),
                    '#68882a' => __('Green', 'rgrjnr'),
                    '#e3bf30' => __('Yellow', 'rgrjnr'),
                ))
                ->set_default_value('#201a1e')
                ->set_help_text(__('Select a color for this highlight category.', 'rgrjnr')),
        ));
}

/**
 * Allow SVG uploads for highlight icons
 * This function enables SVG upload support specifically for highlight icons
 */
add_filter('upload_mimes', 'rgrjnr_allow_svg_uploads');
function rgrjnr_allow_svg_uploads($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

/**
 * Fix SVG display in media library and admin
 */
add_filter('wp_check_filetype_and_ext', 'rgrjnr_fix_svg_mime_type', 10, 5);
function rgrjnr_fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '') {
    if (version_compare(get_bloginfo('version'), '5.1.0', '>=')) {
        $do_validation = in_array(strtolower(wp_get_current_user()->user_login), ['admin'], true);
        if ($do_validation) {
            if (! $data['ext'] && ! $data['type']) {
                $wp_file_type = wp_check_filetype($filename, $mimes);
                if ('svg' === $wp_file_type['ext']) {
                    $data['ext'] = 'svg';
                    $data['type'] = 'image/svg+xml';
                }
            }
        }
    }
    return $data;
}

/**
 * Add SVG thumbnail support in admin
 */
add_filter('wp_prepare_attachment_for_js', 'rgrjnr_svg_response_for_svg', 10, 3);
function rgrjnr_svg_response_for_svg($response, $attachment, $meta) {
    if ($response['mime'] === 'image/svg+xml' && empty($response['sizes'])) {
        $svg_path = get_attached_file($attachment->ID);
        if ($svg_path) {
            $svg = simplexml_load_file($svg_path);
            if ($svg !== false) {
                $width = 150;
                $height = 150;
                
                if (isset($svg['width']) && isset($svg['height'])) {
                    $width = intval((string) $svg['width']);
                    $height = intval((string) $svg['height']);
                }
                
                $response['sizes'] = array(
                    'full' => array(
                        'url' => $response['url'],
                        'width' => $width,
                        'height' => $height,
                        'orientation' => $height > $width ? 'portrait' : 'landscape'
                    )
                );
                $response['icon'] = $response['url'];
            }
        }
    }
    return $response;
}