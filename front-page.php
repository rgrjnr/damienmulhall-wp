<?php
/**
 * Homepage Template
 *
 * @package WPThemeStarter
 */

get_header(); ?>

<main id="content" class="bg-dm-white">
    <div class="py-12 lg:py-12">
        <!-- Header Section -->
        <?php get_template_part('parts/header', 'home'); ?>

        <!-- About Section -->
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="flex flex-col gap-3">
                <!-- Main About Block -->
                <div class="bg-dm-cyan p-content">
                    <p class="font-haas-text font-medium text-heading-lg text-dm-white leading-normal">
                        My background is in media production, so I naturally gravitate toward structure, story, and the
                        bigger picture.
                        I'm not tied to a single methodology or buzzword. What matters is making things happen—and
                        making the
                        process easier for everyone involved.
                    </p>
                </div>

                <!-- Secondary About Block -->
                <div class="bg-dm-cyan p-content flex items-end justify-between relative">
                    <p class="font-haas-text font-medium text-body-lg text-dm-white max-w-md leading-normal">
                        I've helped launch podcasts with 100,000+ downloads, built internal playbooks that actually get
                        used,
                        and run campaigns across formats, teams, and time zones. But this isn't about the biggest
                        project or the
                        flashiest brand.
                    </p>
                    <div class="hidden lg:block absolute right-16 bottom-16">
                        <svg class="w-24 h-20 text-dm-white" viewBox="0 0 102 77" fill="none">
                            <path d="M5 72L51 5L97 72" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- What I Do -->
                    <div class="bg-dm-cyan p-card flex flex-col gap-3">
                        <h3 class="font-haas-display font-bold text-heading-xs text-dm-white">What I Do</h3>
                        <ul class="flex flex-col gap-2">
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Lead Creative Projects End-to-End
                            </li>
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Translate Strategy into Execution
                            </li>
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Align Stakeholders & Deliver Results
                            </li>
                        </ul>
                    </div>

                    <!-- What I Deliver -->
                    <div class="bg-dm-cyan p-card flex flex-col gap-3">
                        <h3 class="font-haas-display font-bold text-heading-xs text-dm-white">What I Deliver</h3>
                        <ul class="flex flex-col gap-2">
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Content That Performs
                            </li>
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Projects On Time & On Budget
                            </li>
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Clear, Actionable Comms
                            </li>
                        </ul>
                    </div>

                    <!-- What To Expect -->
                    <div class="bg-dm-cyan p-card flex flex-col gap-3">
                        <h3 class="font-haas-display font-bold text-heading-xs text-dm-white">What To Expect</h3>
                        <ul class="flex flex-col gap-2">
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Sharp Thinking
                            </li>
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                Calm Leadership
                            </li>
                            <li class="font-haas-display font-medium text-heading-xs text-dm-white leading-none">
                                No-Fluff Delivery
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tools Block -->
                <div class="bg-dm-cyan p-content flex flex-col lg:flex-row items-center justify-between gap-8">
                    <div class="flex gap-4 items-center">
                        <!-- Tool Icons Placeholder -->
                        <div class="flex gap-3">
                            <div class="w-16 h-16 bg-dm-white/20 rounded"></div>
                            <div class="w-16 h-16 bg-dm-white/20 rounded"></div>
                            <div class="w-16 h-16 bg-dm-white/20 rounded"></div>
                            <div class="w-16 h-16 bg-dm-white/20 rounded"></div>
                        </div>
                    </div>
                    <p class="font-haas-text font-medium text-body-lg text-dm-white max-w-md leading-normal">
                        I'm not the designer or the developer. I'm just the project manager who clears the path so they
                        can do
                        their best work—on time, on budget, and without the chaos.
                    </p>
                </div>
            </div>
        </section>

        <!-- Work Section -->
        <section id="work" class="w-full max-w-page mx-auto px-6 mt-section pt-section relative">
            <!-- Background Text -->
            <div class="absolute -right-12 top-0 opacity-10 pointer-events-none">
                <span class="font-haas-display font-medium text-[174px] text-dm-black whitespace-nowrap">Selected
                    Work</span>
            </div>

            <!-- Case Studies List -->
            <div class="relative z-10">
                <?php
                // Query Case Study posts
                $case_studies = new WP_Query([
                    'post_type' => 'case-study',
                    'posts_per_page' => -1,
                    'orderby' => 'menu_order date',
                    'order' => 'ASC'
                ]);
                
                if ($case_studies->have_posts()) :
                    while ($case_studies->have_posts()) : $case_studies->the_post();
                        // Get the short title from Carbon Fields
                        $short_title = carbon_get_post_meta(get_the_ID(), 'short_title');
                        // Use short title if available, otherwise fall back to regular title
                        $display_title = !empty($short_title) ? $short_title : get_the_title();
                        
                        // Get highlights for this case study
                        $highlights = get_the_terms(get_the_ID(), 'highlight');
                        
                        // Define theme color mapping for Tailwind classes
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
                <div
                    class="border-b-[3px] border-dm-black py-6 flex flex-col md:flex-row items-start md:items-center justify-between group cursor-pointer hover:px-4 transition-all">
                    <a href="<?php the_permalink(); ?>"
                        class="font-haas-display font-medium text-display-lg text-dm-black group-hover:text-dm-cyan transition-colors">
                        <?php echo esc_html($display_title); ?>
                    </a>
                    <div class="flex gap-3 mt-4 md:mt-0">
                        <?php if ($highlights && !is_wp_error($highlights)) : ?>
                            <!-- Always show black circle first -->
                            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-dm-black rounded-full flex items-center justify-center">
                                <?php 
                                // Get the first highlight's icon if available
                                if (!empty($highlights[0])) {
                                    $icon_id = carbon_get_term_meta($highlights[0]->term_id, 'rgrjnr_highlight_icon');
                                    if ($icon_id) {
                                        $icon_url = wp_get_attachment_url($icon_id);
                                        if ($icon_url && pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
                                            // For SVG, we can embed it directly
                                            $svg_content = file_get_contents($icon_url);
                                            if ($svg_content) {
                                                echo '<div class="w-10 h-10 lg:w-12 lg:h-12 text-dm-white">';
                                                // Clean and output SVG with currentColor
                                                $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                                                echo $svg_content;
                                                echo '</div>';
                                            }
                                        } else {
                                            // For other image formats
                                            echo '<img src="' . esc_url($icon_url) . '" alt="" class="w-10 h-10 lg:w-12 lg:h-12 object-contain filter invert">';
                                        }
                                    }
                                }
                                ?>
                            </div>
                            
                            <?php 
                            // Display up to 2 more circles based on highlight theme colors
                            $count = 0;
                            foreach ($highlights as $highlight) : 
                                if ($count >= 2) break;
                                $theme_color = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_theme_color');
                                $color_class = isset($theme_colors[$theme_color]) ? $theme_colors[$theme_color] : 'dm-cyan';
                                $count++;
                            ?>
                            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-<?php echo esc_attr($color_class); ?> rounded-full flex items-center justify-center">
                                <?php 
                                // Get highlight icon if available
                                $icon_id = carbon_get_term_meta($highlight->term_id, 'rgrjnr_highlight_icon');
                                if ($icon_id) {
                                    $icon_url = wp_get_attachment_url($icon_id);
                                    if ($icon_url && pathinfo($icon_url, PATHINFO_EXTENSION) === 'svg') {
                                        // For SVG, embed directly
                                        $svg_content = file_get_contents($icon_url);
                                        if ($svg_content) {
                                            $text_color = ($color_class === 'dm-white' || $color_class === 'dm-yellow') ? 'text-dm-black' : 'text-dm-white';
                                            echo '<div class="w-10 h-10 lg:w-12 lg:h-12 ' . $text_color . '">';
                                            // Clean and output SVG with currentColor
                                            $svg_content = preg_replace('/<svg/', '<svg class="w-full h-full" fill="currentColor"', $svg_content, 1);
                                            echo $svg_content;
                                            echo '</div>';
                                        }
                                    } else {
                                        // For other image formats
                                        $filter = ($color_class === 'dm-white' || $color_class === 'dm-yellow') ? '' : 'filter invert';
                                        echo '<img src="' . esc_url($icon_url) . '" alt="' . esc_attr($highlight->name) . '" class="w-10 h-10 lg:w-12 lg:h-12 object-contain ' . $filter . '">';
                                    }
                                }
                                ?>
                            </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <!-- Default circles if no highlights -->
                            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-dm-black rounded-full"></div>
                            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-dm-cyan rounded-full"></div>
                            <div class="w-16 h-16 lg:w-20 lg:h-20 bg-dm-purple rounded-full"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : 
                ?>
                <div class="py-12 text-center">
                    <p class="font-haas-display font-medium text-heading-md text-dm-black">No case studies found.</p>
                    <p class="font-haas-text text-body-lg text-dm-black mt-2">Add case studies in the WordPress admin to display them here.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Skills Section -->
        <section class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Skills Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between min-h-[240px]">
                    <div class="w-8 h-8 bg-dm-white rounded"></div>
                    <div>
                        <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Skills</h3>
                        <p class="font-haas-display font-medium text-heading-xs text-dm-white leading-tight">
                            Waterfall / Budgeting / Planning / Client & Stakeholder Management / Creative Studio
                            Management
                        </p>
                    </div>
                </div>

                <!-- Certifications Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between min-h-[240px]">
                    <div class="w-8 h-8 bg-dm-white rounded"></div>
                    <div>
                        <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Certifications</h3>
                        <p class="font-haas-display font-medium text-heading-xs text-dm-white leading-tight">
                            PMP / Google Project Management / Agile Project Management / Project Planning / Project
                            Execution
                        </p>
                    </div>
                </div>

                <!-- Expertise Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between min-h-[240px]">
                    <div class="w-8 h-8 bg-dm-white rounded"></div>
                    <div>
                        <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Expertise</h3>
                        <p class="font-haas-display font-medium text-heading-xs text-dm-white leading-tight">
                            Sales Enablement / Webinars & Live Events / Podcasts / Product Launches / Community Events /
                            Demand Generation Campaigns / Rich Media Content
                        </p>
                    </div>
                </div>

                <!-- Tools Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between min-h-[240px]">
                    <div class="w-8 h-8 bg-dm-white rounded"></div>
                    <div>
                        <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Tools</h3>
                        <p class="font-haas-display font-medium text-heading-xs text-dm-white leading-tight">
                            Google Workspace / Office 365 / Sharepoint / Adobe CC / Riverside FM / Trello
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section id="contact" class="w-full max-w-page mx-auto px-6 mt-section">
            <div class="border-t-[3px] border-dm-black pt-12">
                <div class="flex flex-col gap-5">
                    <h2 class="font-haas-text font-bold text-display-md text-dm-black leading-none max-w-4xl">
                        Work with me, and see how smooth, focused projects really feel.
                    </h2>

                    <div class="flex items-center gap-4">
                        <div class="w-7 h-7 rounded-full border-2 border-dm-black"></div>
                        <div class="w-7 h-7 bg-dm-black transform rotate-45"></div>
                        <div class="w-7 h-7 bg-dm-black"></div>
                    </div>

                    <div class="flex justify-end">
                        <a href="mailto:contact@damienmulhall.com"
                            class="bg-dm-yellow rounded-full px-9 py-3 flex items-center gap-4 hover:bg-opacity-90 transition-all group">
                            <span class="font-haas-display font-medium text-display-sm text-dm-black">Let's work</span>
                            <svg class="w-16 h-16 text-dm-black group-hover:translate-x-2 transition-transform"
                                viewBox="0 0 64 64" fill="none">
                                <circle cx="32" cy="32" r="31" stroke="currentColor" stroke-width="2" />
                                <path d="M22 32H42M42 32L34 24M42 32L34 40" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="w-full max-w-page mx-auto px-6 mt-section">
            <p class="font-haas-display font-medium text-body-md text-dm-black">
                2025 © Damien Mulhall
            </p>
        </footer>
    </div>
</main>

<?php get_footer(); ?>