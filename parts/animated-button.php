<?php
/**
 * Animated Button Part
 * 
 * @param string $label The button label text
 * @param string $link The button link URL
 * @param string $classes Additional CSS classes (optional)
 */

// Set default values if not provided
$label = $label ?? 'Let\'s work';
$link = $link ?? '#';
$classes = $classes ?? '';
?>

<a href="<?php echo esc_url($link); ?>" class="btn-animated <?php echo esc_attr($classes); ?>">
    <div class="btn-labels">
        <span class="font-haas-display font-medium text-display-sm text-dm-black btn-label">
            <?php echo esc_html($label); ?>
        </span>
        <span class="font-haas-display font-medium text-display-sm text-dm-black btn-label">
            <?php echo esc_html($label); ?>
        </span>
    </div>

    <div class="btn-arrows">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-arrow">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M4.45022 0H23.1835V18.7332L18.1881 18.7329L18.1878 8.52735L3.53134 23.1844L0 19.6513L14.655 4.99572L4.45054 4.99538L4.45022 0Z"
                fill="black" />
        </svg>
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-arrow">
            <path fill-rule="evenodd" clip-rule="evenodd"
                d="M4.45022 0H23.1835V18.7332L18.1881 18.7329L18.1878 8.52735L3.53134 23.1844L0 19.6513L14.655 4.99572L4.45054 4.99538L4.45022 0Z"
                fill="black" />
        </svg>
    </div>
</a>
