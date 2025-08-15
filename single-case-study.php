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

// Get highlights for the case study - try both taxonomy names for compatibility
$highlights = get_the_terms(get_the_ID(), 'highlights');
if (!$highlights || is_wp_error($highlights)) {
    $highlights = get_the_terms(get_the_ID(), 'highlight');
}
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
                        <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
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
                        <?php 
                        // Include highlights badges component with medium size for single case study
                        get_template_part('parts/highlights-badges', null, ['post_id' => get_the_ID(), 'size' => 'medium']); 
                        ?>
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

        <!-- Main Content -->
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Content Area -->
                <div class="lg:col-span-2">
                    <div class="prose prose-lg max-w-none">
                        <blockquote>
                            <p>
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        </blockquote>
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-dm-black p-card sticky top-6">
                        <h3 class="font-haas-display font-bold text-heading-sm text-dm-white mb-6">
                            <div>Project Details</div>
                            <div>
                                <?php 
                        $short_title = carbon_get_post_meta(get_the_ID(), 'rgrjnr_short_title');
                        if ($short_title) : 
                        echo esc_html($short_title);  endif; ?>
                            </div>
                        </h3>

                        <!-- Meta Information -->
                        <div class="space-y-4">
                            <?php 
                            $client = carbon_get_post_meta(get_the_ID(), 'rgrjnr_client');
                            $duration = carbon_get_post_meta(get_the_ID(), 'rgrjnr_duration');
                            ?>

                            <?php if ($client) : ?>
                            <div>
                                <p class="font-haas-text text-body-sm text-dm-white/60">Client</p>
                                <p class="font-haas-text text-body-md text-dm-white">
                                    <?php echo esc_html($client); ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <?php if ($duration) : ?>
                            <div>
                                <p class="font-haas-text text-body-sm text-dm-white/60">Duration</p>
                                <p class="font-haas-text text-body-md text-dm-white">
                                    <?php echo esc_html($duration); ?>
                                </p>
                            </div>
                            <?php endif; ?>

                            <div>
                                <p class="font-haas-text text-body-sm text-dm-white/60">Date</p>
                                <p class="font-haas-text text-body-md text-dm-white">
                                    <?php echo get_the_date('Y'); ?>
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
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
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
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" />
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