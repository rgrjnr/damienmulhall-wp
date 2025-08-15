<?php
/**
 * Homepage Template
 *
 * @package WPThemeStarter
 */

// Include the highlights circles component
require_once get_template_directory() . '/parts/highlights-circles.php';

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
                        <svg width="412" height="118" viewBox="0 0 412 118" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.4"
                                d="M59 9.00024C45.7392 9.00024 33.0215 14.2681 23.6447 23.6449C14.2678 33.0217 9 45.7394 9 59.0002C9 72.2611 14.2678 84.9788 23.6447 94.3556C33.0215 103.732 45.7392 109 59 109C60.6049 108.992 62.1732 108.52 63.5164 107.641C64.8596 106.763 65.9205 105.516 66.5718 104.049C67.2231 102.582 67.4369 100.958 67.1877 99.3727C66.9384 97.7873 66.2366 96.3076 65.1667 95.1114C64.0863 93.9182 63.3773 92.436 63.1263 90.8461C62.8753 89.2562 63.0933 87.6276 63.7536 86.1597C64.4138 84.6918 65.4877 83.4482 66.8438 82.5812C68.1999 81.7141 69.7794 81.2613 71.3889 81.278H81.2222C88.5893 81.278 95.6547 78.3514 100.864 73.1421C106.073 67.9328 109 60.8674 109 53.5002C109 28.8891 86.7778 9.00024 59 9.00024ZM28.4444 59.0002C26.7963 59.0002 25.1851 58.5115 23.8147 57.5958C22.4443 56.6801 21.3762 55.3787 20.7454 53.8559C20.1147 52.3332 19.9497 50.6577 20.2712 49.0412C20.5928 47.4246 21.3864 45.9398 22.5519 44.7744C23.7173 43.6089 25.2022 42.8152 26.8187 42.4937C28.4352 42.1722 30.1108 42.3372 31.6335 42.9679C33.1562 43.5986 34.4577 44.6668 35.3734 46.0372C36.289 47.4076 36.7778 49.0187 36.7778 50.6669C36.7778 52.877 35.8998 54.9967 34.337 56.5595C32.7742 58.1223 30.6546 59.0002 28.4444 59.0002ZM45.1111 36.778C43.4629 36.778 41.8518 36.2893 40.4814 35.3736C39.111 34.4579 38.0428 33.1564 37.4121 31.6337C36.7814 30.111 36.6164 28.4354 36.9379 26.8189C37.2594 25.2024 38.0531 23.7176 39.2186 22.5521C40.384 21.3867 41.8688 20.593 43.4854 20.2715C45.1019 19.9499 46.7774 20.115 48.3001 20.7457C49.8229 21.3764 51.1243 22.4445 52.04 23.8149C52.9557 25.1853 53.4444 26.7965 53.4444 28.4447C53.4444 30.6548 52.5665 32.7744 51.0037 34.3372C49.4409 35.9 47.3212 36.778 45.1111 36.778ZM72.8889 36.778C71.2407 36.778 69.6295 36.2893 68.2591 35.3736C66.8887 34.4579 65.8206 33.1564 65.1899 31.6337C64.5592 30.111 64.3941 28.4354 64.7157 26.8189C65.0372 25.2024 65.8309 23.7176 66.9963 22.5521C68.1618 21.3867 69.6466 20.593 71.2631 20.2715C72.8796 19.9499 74.5552 20.115 76.0779 20.7457C77.6006 21.3764 78.9021 22.4445 79.8178 23.8149C80.7335 25.1853 81.2222 26.7965 81.2222 28.4447C81.2222 30.6548 80.3442 32.7744 78.7814 34.3372C77.2186 35.9 75.099 36.778 72.8889 36.778ZM89.5556 59.0002C87.9074 59.0002 86.2962 58.5115 84.9258 57.5958C83.5554 56.6801 82.4873 55.3787 81.8566 53.8559C81.2258 52.3332 81.0608 50.6577 81.3823 49.0412C81.7039 47.4246 82.4976 45.9398 83.663 44.7744C84.8284 43.6089 86.3133 42.8152 87.9298 42.4937C89.5463 42.1722 91.2219 42.3372 92.7446 42.9679C94.2673 43.5986 95.5688 44.6668 96.4845 46.0372C97.4001 47.4076 97.8889 49.0187 97.8889 50.6669C97.8889 52.877 97.0109 54.9967 95.4481 56.5595C93.8853 58.1223 91.7657 59.0002 89.5556 59.0002Z"
                                fill="#E1DFD0" />
                            <path d="M9 108.5L108.5 9.00024" stroke="#E1DFD0" stroke-width="18" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M158 108.5L257.5 9.00024" stroke="#E1DFD0" stroke-width="18" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path opacity="0.4"
                                d="M241.947 9.00024H174.053C165.183 9.00024 158 16.177 158 25.0392V92.9613C158 101.823 165.183 109 174.053 109H241.947C250.817 109 258 101.823 258 92.9613V25.0392C258 16.1773 250.817 9.00024 241.947 9.00024ZM191.657 42.1833L182.334 51.4982C181.433 52.3987 180.261 52.8407 179.077 52.8407C177.894 52.8407 176.722 52.3932 175.82 51.4982C174.023 49.7026 174.023 46.7965 175.82 45.0008L181.886 38.94L175.97 33.0284C174.172 31.2328 174.172 28.3267 175.97 26.531C177.767 24.7355 180.675 24.7355 182.473 26.531L191.641 35.6913C193.438 37.4869 193.438 40.393 191.641 42.1887L191.657 42.1833ZM216.917 52.8408H202.767C200.223 52.8408 198.166 50.7856 198.166 48.2441C198.166 45.7026 200.223 43.6474 202.767 43.6474H216.917C219.461 43.6474 221.518 45.7026 221.518 48.2441C221.518 50.7856 219.461 52.8408 216.917 52.8408Z"
                                fill="#E1DFD0" />
                            <path
                                d="M396 9.00024C404.837 9.00025 412 16.1637 412 25.0002V93.0002C412 101.837 404.837 109 396 109H328C319.163 109 312 101.837 312 93.0002V25.0002C312 16.1637 319.163 9.00024 328 9.00024H396ZM385.682 29.8186C383.979 28.1164 381.253 28.0629 379.486 29.6584L379.318 29.8186L367.818 41.3186C366.061 43.0759 366.061 45.9246 367.818 47.6819C369.576 49.4391 372.424 49.4391 374.182 47.6819L378 43.8635V52.0002C378 53.9331 376.433 55.5002 374.5 55.5002H343C336.097 55.5002 330.5 61.0968 330.5 68.0002V84.0002C330.5 86.4854 332.515 88.5002 335 88.5002C337.485 88.5002 339.5 86.4854 339.5 84.0002V68.0002C339.5 66.0674 341.067 64.5002 343 64.5002H374.5C381.403 64.5002 387 58.9037 387 52.0002V43.8635L390.818 47.6819C392.576 49.4391 395.424 49.4391 397.182 47.6819C398.939 45.9246 398.939 43.0759 397.182 41.3186L385.682 29.8186ZM368 74.0002C366.896 74.0002 366 74.8958 366 76.0002V82.0002C366 83.1047 366.896 84.0002 368 84.0002H374C375.104 84.0002 376 83.1047 376 82.0002V76.0002C376 74.8958 375.104 74.0002 374 74.0002H368ZM387 74.0002C384.239 74.0002 382 76.2389 382 79.0002C382 81.7616 384.239 84.0002 387 84.0002C389.761 84.0002 392 81.7616 392 79.0002C392 76.2389 389.761 74.0002 387 74.0002ZM336 36.5002C333.239 36.5002 331 38.7389 331 41.5002C331 44.2616 333.239 46.5002 336 46.5002C338.761 46.5002 341 44.2616 341 41.5002C341 38.7389 338.761 36.5002 336 36.5002ZM355.914 37.5862C355.133 36.8053 353.867 36.8053 353.086 37.5862L349 41.6721L347.414 40.0862C346.633 39.3053 345.367 39.3053 344.586 40.0862C343.805 40.8672 343.805 42.1333 344.586 42.9143L347.586 45.9143C348.367 46.6952 349.633 46.6952 350.414 45.9143L355.914 40.4143C356.695 39.6333 356.695 38.3672 355.914 37.5862Z"
                                fill="#E1DFD0" />
                        </svg>

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
                        
                        // Format highlights for the component
                        $highlights_data = rgrjnr_format_highlight_terms($highlights);
                ?>
                <div
                    class="border-b-[3px] border-dm-black py-6 flex flex-col md:flex-row items-start md:items-center justify-between group cursor-pointer hover:px-4 transition-all">
                    <a href="<?php the_permalink(); ?>"
                        class="font-haas-display font-medium text-display-lg text-dm-black group-hover:text-dm-cyan transition-colors">
                        <?php echo esc_html($display_title); ?>
                    </a>
                    <?php 
                    // Display highlight circles
                    rgrjnr_display_highlight_circles($highlights_data, [
                        'container_class' => 'mt-4 md:mt-0'
                    ]);
                    ?>
                </div>
                <?php 
                    endwhile;
                    wp_reset_postdata();
                else : 
                ?>
                <div class="py-12 text-center">
                    <p class="font-haas-display font-medium text-heading-md text-dm-black">No case studies found.</p>
                    <p class="font-haas-text text-body-lg text-dm-black mt-2">Add case studies in the WordPress admin to
                        display them here.</p>
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
                        <svg width="111" height="30" viewBox="0 0 111 30" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="13.6677" cy="14.7312" r="13.6677" fill="#201A1E" />
                            <rect x="41.0036" y="23.4292" width="32.8025" height="8.20062"
                                transform="rotate(-45 41.0036 23.4292)" fill="#201A1E" />
                            <rect x="64.198" y="29.2278" width="32.8025" height="8.20062"
                                transform="rotate(-135 64.198 29.2278)" fill="#201A1E" />
                            <rect x="83.6646" y="1.06348" width="27.3354" height="27.3354" fill="#201A1E" />
                        </svg>

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