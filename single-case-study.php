<?php
/**
 * Single Case Study Template
 *
 * @package WPThemeStarter
 */

get_header(); 

// Get custom fields
$short_title = carbon_get_post_meta(get_the_ID(), 'short_title');
$display_title = !empty($short_title) ? $short_title : get_the_title();

// Get highlights
$highlights = get_the_terms(get_the_ID(), 'highlight');

// Theme color mapping
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
?>

<main id="content" class="bg-dm-white">
    <div class="py-12 lg:py-12">
        <?php while (have_posts()) : the_post(); ?>
        
        <!-- Hero Section -->
        <section class="w-full max-w-page mx-auto px-6">
            <div class="flex flex-col gap-8">
                <!-- Back Link -->
                <a href="<?php echo home_url('/#work'); ?>" 
                   class="inline-flex items-center gap-2 font-haas-display font-medium text-body-lg text-dm-black hover:text-dm-cyan transition-colors group">
                    <svg class="w-5 h-5 transform rotate-180 group-hover:-translate-x-1 transition-transform" 
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Back to Work</span>
                </a>
                
                <!-- Title with Highlights -->
                <div class="border-b-[3px] border-dm-black pb-8">
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                        <div>
                            <h1 class="font-haas-display font-medium text-display-xl text-dm-black leading-none mb-4">
                                <?php the_title(); ?>
                            </h1>
                            <?php if (!empty($short_title)) : ?>
                            <p class="font-haas-text font-medium text-heading-md text-dm-black/60">
                                <?php echo esc_html($short_title); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Highlight Circles -->
                        <div class="flex gap-3">
                            <?php if ($highlights && !is_wp_error($highlights)) : ?>
                                <!-- Black circle with icon -->
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-dm-black rounded-full flex items-center justify-center">
                                    <?php 
                                    if (!empty($highlights[0])) {
                                        $icon_id = carbon_get_term_meta($highlights[0]->term_id, 'rgrjnr_highlight_icon');
                                        if ($icon_id) {
                                            $icon_url = wp_get_attachment_url($icon_id);
                                            if ($icon_url && pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
                                                $svg_content = file_get_contents($icon_url);
                                                if ($svg_content) {
                                                    echo '<div class="w-12 h-12 lg:w-14 lg:h-14 text-dm-white">';
                                                    $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                                                    echo $svg_content;
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo '<img src="' . esc_url($icon_url) . '" alt="" class="w-12 h-12 lg:w-14 lg:h-14 object-contain filter invert">';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <?php 
                                $count = 0;
                                foreach ($highlights as $highlight) : 
                                    if ($count >= 2) break;
                                    $theme_color = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_theme_color');
                                    $color_class = isset($theme_colors[$theme_color]) ? $theme_colors[$theme_color] : 'dm-cyan';
                                    $count++;
                                ?>
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-<?php echo esc_attr($color_class); ?> rounded-full flex items-center justify-center">
                                    <?php 
                                    $icon_id = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_icon');
                                    if ($icon_id) {
                                        $icon_url = wp_get_attachment_url($icon_id);
                                        if ($icon_url && pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
                                            $svg_content = file_get_contents($icon_url);
                                            if ($svg_content) {
                                                $text_color = ($color_class === 'dm-white' || $color_class === 'dm-yellow') ? 'text-dm-black' : 'text-dm-white';
                                                echo '<div class="w-12 h-12 lg:w-14 lg:h-14 ' . $text_color . '">';
                                                $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                                                echo $svg_content;
                                                echo '</div>';
                                            }
                                        } else {
                                            $filter = ($color_class === 'dm-white' || $color_class === 'dm-yellow') ? '' : 'filter invert';
                                            echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($highlight->name) . '" class="w-12 h-12 lg:w-14 lg:h-14 object-contain ' . $filter . '">';
                                        }
                                    }
                                    ?>
                                </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <!-- Default circles -->
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-dm-black rounded-full"></div>
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-dm-cyan rounded-full"></div>
                                <div class="w-20 h-20 lg:w-24 lg:h-24 bg-dm-purple rounded-full"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="bg-dm-black p-3">
                <?php the_post_thumbnail('full', ['class' => 'w-full h-auto']); ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Highlights Section -->
        <?php if ($highlights && !is_wp_error($highlights) && count($highlights) > 0) : ?>
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="bg-dm-cyan p-content">
                <h2 class="font-haas-display font-bold text-heading-md text-dm-white mb-8">Project Highlights</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($highlights as $highlight) : 
                        $theme_color = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_theme_color');
                        $color_class = isset($theme_colors[$theme_color]) ? $theme_colors[$theme_color] : 'dm-cyan';
                        $description = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_description');
                        $icon_id = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_icon');
                    ?>
                    <div class="flex flex-col gap-4">
                        <div class="w-16 h-16 bg-<?php echo esc_attr($color_class); ?> rounded-full flex items-center justify-center">
                            <?php 
                            if ($icon_id) {
                                $icon_url = wp_get_attachment_url($icon_id);
                                if ($icon_url && pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
                                    $svg_content = file_get_contents($icon_url);
                                    if ($svg_content) {
                                        $text_color = ($color_class === 'dm-white' || $color_class === 'dm-yellow') ? 'text-dm-black' : 'text-dm-white';
                                        echo '<div class="w-10 h-10 ' . $text_color . '">';
                                        $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                                        echo $svg_content;
                                        echo '</div>';
                                    }
                                } else {
                                    $filter = ($color_class === 'dm-white' || $color_class === 'dm-yellow') ? '' : 'filter invert';
                                    echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($highlight->name) . '" class="w-10 h-10 object-contain ' . $filter . '">';
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <h3 class="font-haas-display font-bold text-heading-sm text-dm-white mb-2">
                                <?php echo esc_html($highlight->name); ?>
                            </h3>
                            <?php if ($description) : ?>
                            <p class="font-haas-text text-body-md text-dm-white/90">
                                <?php echo esc_html($description); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Main Content -->
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Content Area -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>
                
                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-dm-black p-card sticky top-6">
                        <h3 class="font-haas-display font-bold text-heading-sm text-dm-white mb-6">Project Details</h3>
                        
                        <!-- Meta Information -->
                        <div class="space-y-4">
                            <?php if ($highlights && !is_wp_error($highlights)) : ?>
                            <div>
                                <p class="font-haas-text text-body-sm text-dm-white/60 mb-2">Services</p>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach ($highlights as $highlight) : 
                                        $theme_color = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_theme_color');
                                        $color_class = isset($theme_colors[$theme_color]) ? $theme_colors[$theme_color] : 'dm-cyan';
                                    ?>
                                    <span class="inline-block bg-<?php echo esc_attr($color_class); ?> text-dm-white px-3 py-1 rounded-full font-haas-text text-body-sm">
                                        <?php echo esc_html($highlight->name); ?>
                                    </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <div>
                                <p class="font-haas-text text-body-sm text-dm-white/60 mb-2">Date</p>
                                <p class="font-haas-text text-body-md text-dm-white">
                                    <?php echo get_the_date('F Y'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Navigation -->
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="border-t-[3px] border-dm-black pt-8">
                <div class="flex justify-between items-center">
                    <?php
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    ?>
                    
                    <?php if ($prev_post) : 
                        $prev_short_title = carbon_get_post_meta($prev_post->ID, 'short_title');
                        $prev_display = !empty($prev_short_title) ? $prev_short_title : $prev_post->post_title;
                    ?>
                    <a href="<?php echo get_permalink($prev_post); ?>" 
                       class="group flex items-center gap-3 font-haas-display font-medium text-heading-sm text-dm-black hover:text-dm-cyan transition-colors">
                        <svg class="w-6 h-6 transform rotate-180 group-hover:-translate-x-2 transition-transform" 
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span><?php echo esc_html($prev_display); ?></span>
                    </a>
                    <?php else : ?>
                    <div></div>
                    <?php endif; ?>
                    
                    <?php if ($next_post) : 
                        $next_short_title = carbon_get_post_meta($next_post->ID, 'short_title');
                        $next_display = !empty($next_short_title) ? $next_short_title : $next_post->post_title;
                    ?>
                    <a href="<?php echo get_permalink($next_post); ?>" 
                       class="group flex items-center gap-3 font-haas-display font-medium text-heading-sm text-dm-black hover:text-dm-cyan transition-colors">
                        <span><?php echo esc_html($next_display); ?></span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" 
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="bg-dm-cyan p-content">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div>
                        <h2 class="font-haas-display font-bold text-heading-lg text-dm-white mb-3">
                            Ready to start your project?
                        </h2>
                        <p class="font-haas-text text-body-lg text-dm-white/90">
                            Let's discuss how I can help bring your ideas to life.
                        </p>
                    </div>
                    <a href="mailto:contact@damienmulhall.com"
                        class="bg-dm-yellow rounded-full px-9 py-3 flex items-center gap-4 hover:bg-opacity-90 transition-all group flex-shrink-0">
                        <span class="font-haas-display font-medium text-display-sm text-dm-black">Get in touch</span>
                        <svg class="w-16 h-16 text-dm-black group-hover:translate-x-2 transition-transform"
                            viewBox="0 0 64 64" fill="none">
                            <circle cx="32" cy="32" r="31" stroke="currentColor" stroke-width="2" />
                            <path d="M22 32H42M42 32L34 24M42 32L34 40" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>