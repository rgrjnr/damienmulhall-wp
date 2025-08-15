<?php
/**
 * Highlights Circles Component
 * 
 * Displays circular highlight badges with colors and icons
 * 
 * @package WPThemeStarter
 * 
 * Usage:
 * $highlights_data = [
 *     [
 *         'color' => 'dm-cyan',      // Tailwind color class
 *         'icon_url' => '',           // URL to icon (SVG or image)
 *         'icon_html' => '',          // Direct HTML/SVG content (optional, overrides icon_url)
 *         'title' => '',              // Alt text/title for the icon
 *     ]
 * ];
 * 
 * rgrjnr_display_highlight_circles($highlights_data);
 */

/**
 * Display highlight circles
 * 
 * @param array $highlights Array of highlight data
 * @param array $args Optional arguments for customization
 */
function rgrjnr_display_highlight_circles($highlights = [], $args = []) {
    // Default arguments
    $defaults = [
        'size' => 'default',           // 'small', 'default', 'large'
        'max_circles' => 3,             // Maximum number of circles to display
        'show_black_first' => true,     // Show black circle as first one
        'gap' => '3',                   // Tailwind gap class
        'container_class' => '',        // Additional container classes
    ];
    
    $args = wp_parse_args($args, $defaults);
    
    // Size classes
    $size_classes = [
        'small' => 'w-12 h-12 lg:w-16 lg:h-16',
        'default' => 'w-16 h-16 lg:w-20 lg:h-20',
        'large' => 'w-20 h-20 lg:w-24 lg:h-24',
    ];
    
    $icon_size_classes = [
        'small' => 'w-6 h-6 lg:w-8 lg:h-8',
        'default' => 'w-10 h-10 lg:w-12 lg:h-12',
        'large' => 'w-12 h-12 lg:w-14 lg:h-14',
    ];
    
    $circle_class = isset($size_classes[$args['size']]) ? $size_classes[$args['size']] : $size_classes['default'];
    $icon_class = isset($icon_size_classes[$args['size']]) ? $icon_size_classes[$args['size']] : $icon_size_classes['default'];
    
    // Start output
    ?>
    <div class="flex gap-<?php echo esc_attr($args['gap']); ?> <?php echo esc_attr($args['container_class']); ?>">
        <?php 
        // Show black circle first if enabled
        if ($args['show_black_first']) : 
            $first_highlight = !empty($highlights[0]) ? $highlights[0] : null;
        ?>
        <div class="<?php echo esc_attr($circle_class); ?> bg-dm-black rounded-full flex items-center justify-center">
            <?php if ($first_highlight) : ?>
                <?php rgrjnr_render_highlight_icon($first_highlight, $icon_class, 'text-dm-white'); ?>
            <?php endif; ?>
        </div>
        <?php 
            // Remove first item from array if we've used it
            if ($first_highlight) {
                array_shift($highlights);
            }
        endif; 
        
        // Display remaining circles
        $count = $args['show_black_first'] ? 1 : 0;
        foreach ($highlights as $highlight) :
            if ($count >= $args['max_circles']) break;
            
            $color = !empty($highlight['color']) ? $highlight['color'] : 'dm-cyan';
            $text_color = rgrjnr_get_contrast_text_color($color);
            $count++;
        ?>
        <div class="<?php echo esc_attr($circle_class); ?> bg-<?php echo esc_attr($color); ?> rounded-full flex items-center justify-center">
            <?php rgrjnr_render_highlight_icon($highlight, $icon_class, $text_color); ?>
        </div>
        <?php endforeach; ?>
        
        <?php 
        // Add empty circles if needed to reach max_circles
        while ($count < $args['max_circles']) : 
            $default_colors = ['dm-cyan', 'dm-purple', 'dm-yellow'];
            $color_index = ($count - ($args['show_black_first'] ? 1 : 0)) % count($default_colors);
            $color = $default_colors[$color_index];
            $count++;
        ?>
        <div class="<?php echo esc_attr($circle_class); ?> bg-<?php echo esc_attr($color); ?> rounded-full"></div>
        <?php endwhile; ?>
    </div>
    <?php
}

/**
 * Render a single highlight icon
 * 
 * @param array $highlight Highlight data
 * @param string $icon_class Size classes for the icon
 * @param string $text_color Text color class
 */
function rgrjnr_render_highlight_icon($highlight, $icon_class, $text_color) {
    // Check for direct HTML/SVG content first
    if (!empty($highlight['icon_html'])) {
        echo '<div class="' . esc_attr($icon_class . ' ' . $text_color) . '">';
        echo $highlight['icon_html']; // Already sanitized SVG content
        echo '</div>';
        return;
    }
    
    // Check for icon URL
    if (!empty($highlight['icon_url'])) {
        $icon_url = $highlight['icon_url'];
        $title = !empty($highlight['title']) ? $highlight['title'] : '';
        
        // Check if it's an SVG
        if (pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
            // Try to get SVG content for inline rendering
            $svg_content = @file_get_contents($icon_url);
            if ($svg_content) {
                echo '<div class="' . esc_attr($icon_class . ' ' . $text_color) . '">';
                // Clean and output SVG with currentColor
                $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                // Remove any hardcoded fill colors to use currentColor
                $svg_content = preg_replace('/fill="[^"]*"/', 'fill="currentColor"', $svg_content);
                echo $svg_content;
                echo '</div>';
            } else {
                // Fallback to img tag if we can't read the SVG
                echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($title) . '" class="' . esc_attr($icon_class) . ' object-contain">';
            }
        } else {
            // Regular image
            $filter = ($text_color === 'text-dm-black') ? '' : 'filter invert';
            echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($title) . '" class="' . esc_attr($icon_class) . ' object-contain ' . $filter . '">';
        }
    }
}

/**
 * Get appropriate text color based on background color
 * 
 * @param string $bg_color Background color class
 * @return string Text color class
 */
function rgrjnr_get_contrast_text_color($bg_color) {
    $light_backgrounds = ['dm-white', 'dm-yellow'];
    return in_array($bg_color, $light_backgrounds) ? 'text-dm-black' : 'text-dm-white';
}

/**
 * Convert highlights taxonomy terms to highlight data array
 * 
 * @param array $terms Array of WP_Term objects from highlights taxonomy
 * @return array Formatted highlights data
 */
function rgrjnr_format_highlight_terms($terms) {
    if (!$terms || is_wp_error($terms)) {
        return [];
    }
    
    $highlights = [];
    $theme_colors = [
        'primary' => 'dm-cyan',
        'secondary' => 'dm-purple',
        'accent' => 'dm-yellow',
        'success' => 'dm-green',
        'warning' => 'dm-orange',
        'danger' => 'dm-red',
        'info' => 'dm-blue',
        'light' => 'dm-white',
        'dark' => 'dm-black'
    ];
    
    foreach ($terms as $term) {
        $theme_color = carbon_get_term_meta($term->term_id, 'rgrjnr_highlight_theme_color');
        $color = isset($theme_colors[$theme_color]) ? $theme_colors[$theme_color] : 'dm-cyan';
        
        $icon_id = carbon_get_term_meta($term->term_id, 'rgrjnr_highlight_icon');
        $icon_url = $icon_id ? wp_get_attachment_url($icon_id) : '';
        
        $highlights[] = [
            'color' => $color,
            'icon_url' => $icon_url,
            'title' => $term->name,
            'description' => $term->description,
        ];
    }
    
    return $highlights;
}