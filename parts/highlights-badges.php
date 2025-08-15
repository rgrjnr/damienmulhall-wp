<?php
/**
 * Highlights Badges Component
 * Displays highlight taxonomy terms with their custom colors and icons
 *
 * @package WPThemeStarter
 * 
 * @param int $post_id The ID of the case study post
 * @param string $size Size of badges: 'small' (16/20), 'medium' (20/24) - default is 'small'
 */

// Get the post ID from passed parameter or use current post
$post_id = isset($args['post_id']) ? $args['post_id'] : get_the_ID();
$size = isset($args['size']) ? $args['size'] : 'small';

// Size classes based on parameter
$container_sizes = [
    'small' => 'w-16 h-16 lg:w-20 lg:h-20',
    'medium' => 'w-20 h-20 lg:w-24 lg:h-24'
];

$icon_sizes = [
    'small' => 'w-8 h-8 lg:w-10 lg:h-10',
    'medium' => 'w-12 h-12 lg:w-14 lg:h-14'
];

$container_class = isset($container_sizes[$size]) ? $container_sizes[$size] : $container_sizes['small'];
$icon_class = isset($icon_sizes[$size]) ? $icon_sizes[$size] : $icon_sizes['small'];

// Get highlights for the case study - try both taxonomy names for compatibility
$highlights = wp_get_post_terms($post_id, 'highlights');
if (empty($highlights) || is_wp_error($highlights)) {
    $highlights = wp_get_post_terms($post_id, 'highlight');
}

if (!empty($highlights) && !is_wp_error($highlights)) : ?>
    <div class="flex gap-3 mt-4 md:mt-0">
        <?php 
        $count = 0;
        foreach ($highlights as $highlight) :
            if ($count >= 3) break; // Show maximum 3 badges
            
            // Get custom fields for the highlight
            $color = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_color');
            $icon_url = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_icon');
            
            // Set default color if none is set
            if (empty($color)) {
                $color = '#201a1e'; // Default to black
            }
            
            // Determine if we need to invert the icon color
            $needs_invert = !in_array($color, ['#e1dfd0', '#e3bf30']); // Don't invert for white/yellow
            $count++;
        ?>
            <div 
                class="<?php echo esc_attr($container_class); ?> rounded-full flex items-center justify-center"
                style="background-color: <?php echo esc_attr($color); ?>;"
                title="<?php echo esc_attr($highlight->name); ?>">
                <?php if (!empty($icon_url)) : ?>
                    <?php 
                    // Check if it's an SVG file
                    if (pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
                        // Try to load and inline the SVG
                        $svg_content = @file_get_contents($icon_url);
                        if ($svg_content) {
                            $text_color = $needs_invert ? 'text-white' : 'text-black';
                            echo '<div class="' . esc_attr($icon_class) . ' ' . $text_color . '">';
                            // Add classes to the SVG element
                            $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                            echo $svg_content;
                            echo '</div>';
                        } else {
                            // Fallback to img tag if can't load SVG
                            ?>
                            <img 
                                src="<?php echo esc_url($icon_url); ?>" 
                                alt="<?php echo esc_attr($highlight->name); ?>" 
                                class="<?php echo esc_attr($icon_class); ?> object-contain"
                                style="<?php echo $needs_invert ? 'filter: brightness(0) invert(1);' : ''; ?>">
                            <?php
                        }
                    } else {
                        // For non-SVG images
                        ?>
                        <img 
                            src="<?php echo esc_url($icon_url); ?>" 
                            alt="<?php echo esc_attr($highlight->name); ?>" 
                            class="<?php echo esc_attr($icon_class); ?> object-contain"
                            style="<?php echo $needs_invert ? 'filter: brightness(0) invert(1);' : ''; ?>">
                        <?php
                    }
                    ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>