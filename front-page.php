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
                    <div class="hidden lg:block absolute right-0 bottom-0">

                        <svg width="102" height="77" viewBox="0 0 102 77" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M58.6125 77C57.7751 74.8854 55.4027 73.7594 53.1698 73.7045C52.3046 73.7045 49.6251 74.4734 49.7089 73.0454C49.7089 72.6334 50.8811 71.068 51.2161 70.6286C53.3652 67.6352 57.7193 63.1038 59.2265 60.0555C59.5056 59.5062 59.7847 58.6549 59.7847 58.0781C59.7847 57.5289 59.2265 56.4853 59.8964 56.2656L68.9395 55.6339C80.6341 55.9635 89.4261 67.3606 101.484 66.1247C101.763 66.0973 102.07 66.2895 101.986 65.8501C95.5386 61.8131 89.8168 56.8148 83.6206 52.4757C76.2521 47.3127 70.0001 47.3402 61.7943 44.6488C58.8637 43.6876 56.0167 42.4793 53.2815 41.1061C53.2536 40.7491 53.6722 40.9414 53.8676 40.9963C56.7982 41.9575 59.5335 42.644 62.5479 43.3306C66.0368 44.127 69.8326 44.9509 73.3494 45.5002C75.4985 45.8297 77.7314 46.2142 79.9085 46.0494C74.6333 41.7927 69.6093 37.2888 64.5296 32.8398C57.2448 26.4959 51.4114 22.1568 43.4848 16.6642C38.8236 13.4511 38.8515 10.7597 36.0046 6.53047C31.6784 0.104182 25.2031 -1.81821 18.03 1.83434C17.3043 2.21882 15.518 3.61942 15.0715 3.75673C11.7501 4.85524 7.67508 5.23972 4.18621 6.42062C3.15351 6.77764 0.474061 7.73884 0.0274872 8.75496C-0.139978 9.11198 0.501978 9.1669 0.753176 9.22183C5.02354 10.1281 14.2341 9.77108 17.1648 13.0666C19.7884 15.9777 18.03 19.7126 17.7788 22.9532C16.9973 33.2518 21.8538 41.7378 29.4177 48.3838C31.1202 49.8668 34.8324 51.9814 36.0046 53.3545C36.814 54.2883 38.2375 58.3802 38.6283 59.6984C38.9074 60.6871 39.2702 61.5384 38.5724 62.4447C35.0278 65.548 30.9248 72.6334 26.3475 73.8967C24.4216 74.4185 21.9934 74.2812 20.2908 74.9128C19.5372 75.2149 18.1696 76.1212 18.1696 77H58.6125ZM35.6418 39.4309C32.2087 36.2178 30.562 32.4828 29.1106 28.0888C29.0548 27.8965 28.8874 27.4297 29.1106 27.3198C31.2598 31.2195 33.381 34.8721 36.7024 37.893C40.4425 41.2984 44.8524 43.9623 49.4577 46.1044L59.9801 50.1963C55.9888 50.0865 52.2488 48.8506 48.5924 47.3127C44.043 45.3903 39.2423 42.7539 35.6139 39.4034L35.6418 39.4309ZM47.3644 57.0071C47.3644 57.0071 48.9832 57.8584 49.2065 58.0232C50.2671 58.7372 52.7512 60.4399 52.6953 61.7581C52.6674 62.939 50.295 67.3606 49.5693 68.5964C48.8995 69.7498 46.862 72.6334 45.8014 73.2376C43.7918 74.3636 40.4146 73.7319 37.8188 74.5009C36.842 74.7755 35.6139 75.7367 35.0278 75.8466C33.2135 76.1487 30.2271 75.3797 31.9855 73.2376C35.4743 68.9259 40.275 65.9325 44.5175 62.4722C46.4991 60.8244 47.6156 59.9181 47.3923 57.0345L47.3644 57.0071Z"
                                fill="#E1DFD0" />
                        </svg>

                    </div>
                </div>

                <!-- Services Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- What I Do -->
                    <div class="bg-dm-cyan p-card flex flex-col gap-3">
                        <h3 class="font-haas-display font-bold text-heading-xs text-dm-white">What I Do</h3>
                        <div class="flex flex-col gap-2">
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Lead Creative Projects End-to-End
                            </p>
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Translate Strategy into Execution
                            </p>
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Align Stakeholders & Deliver Results
                            </p>
                        </div>
                    </div>

                    <!-- What I Deliver -->
                    <div class="bg-dm-cyan p-card flex flex-col gap-3">
                        <h3 class="font-haas-display font-bold text-heading-xs text-dm-white">What I Deliver</h3>
                        <div class="flex flex-col gap-2">
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Content That Performs
                            </p>
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Projects On Time & On Budget
                            </p>
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Clear, Actionable Comms
                            </p>
                        </div>
                    </div>

                    <!-- What To Expect -->
                    <div class="bg-dm-cyan p-card flex flex-col gap-3">
                        <h3 class="font-haas-display font-bold text-heading-xs text-dm-white">What To Expect</h3>
                        <div class="flex flex-col gap-2">
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Sharp Thinking
                            </p>
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                Calm Leadership
                            </p>
                            <p class="font-haas-display font-medium text-body-lg text-dm-white leading-none">
                                No-Fluff Delivery
                            </p>
                        </div>
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
                        $short_title = carbon_get_post_meta(get_the_ID(), 'rgrjnr_short_title');
                        // Use short title if available, otherwise fall back to regular title
                        $display_title = !empty($short_title) ? $short_title : get_the_title();
                        
                ?>
                <div
                    class="work-item border-b-[3px] border-dm-black py-6 flex flex-col md:flex-row items-start md:items-center justify-between group cursor-pointer hover:px-4 transition-all relative overflow-hidden">
                    
                    <!-- Animated Background -->
                    <div class="work-background absolute inset-0 bg-dm-cyan transform scale-y-0 origin-top pointer-events-none"></div>
                    
                    <!-- Title Container -->
                    <div class="work-title-container relative z-10 flex-1">
                        <!-- Original Title -->
                        <a href="<?php the_permalink(); ?>"
                            class="work-title font-haas-display font-medium text-display-lg text-dm-black group-hover:text-dm-black transition-colors block">
                            <?php echo esc_html($display_title); ?>
                        </a>
                        
                        <!-- Duplicate Title for Animation (Hidden by default) -->
                        <a href="<?php the_permalink(); ?>"
                            class="work-title-duplicate font-haas-display font-medium text-display-lg text-dm-black absolute top-0 left-0 opacity-0 pointer-events-none"
                            aria-hidden="true">
                            <?php echo esc_html($display_title); ?>
                        </a>
                    </div>

                    <!-- Highlights Container -->
                    <div class="work-highlights relative z-10">
                        <?php 
                        // Include highlights badges component
                        get_template_part('parts/highlights-badges', null, ['post_id' => get_the_ID()]); 
                        ?>
                    </div>
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
            <div class="grid grid-cols-1 md:grid-cols-2  gap-4">
                <!-- Skills Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between relative min-h-[240px]"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="2rem"
                        class="absolute top-6 right-6">
                        <path
                            d="M22,10c-0.738,0-1.376,0.405-1.723,1H13V9h6V5.723C19.595,5.376,20,4.738,20,4c0-1.105-0.895-2-2-2s-2,0.895-2,2	c0,0.738,0.405,1.376,1,1.723V7h-4V3.333l-0.331-0.298C11.927,2.368,10.979,2,10,2C8.815,2,7.732,2.523,6.992,3.382L6.983,3.374	C6.898,3.472,6.831,3.582,6.756,3.687C6.73,3.724,6.701,3.759,6.676,3.797c-0.092,0.138-0.171,0.282-0.245,0.43	C6.425,4.239,6.417,4.25,6.412,4.262C4.405,4.937,3,6.849,3,9c0,0.48,0.069,0.953,0.207,1.413C2.425,11.452,2,12.704,2,14	c0,2.42,1.468,4.588,3.693,5.516C6.588,21.058,8.203,22,10,22c0.874,0,1.716-0.232,2.503-0.69L13,21.02V17h3v1.277	c-0.595,0.346-1,0.984-1,1.723c0,1.105,0.895,2,2,2s2-0.895,2-2c0-0.738-0.405-1.376-1-1.723V15h-5v-2h7.277	c0.346,0.595,0.984,1,1.723,1c1.105,0,2-0.895,2-2C24,10.895,23.105,10,22,10z"
                            fill="#e1dfd0" />
                    </svg>

                    <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Skills</h3>
                    <p class="font-haas-display font-medium text-body-lg text-dm-white leading-tight">
                        Waterfall / Budgeting / Planning / Client & Stakeholder Management / Creative Studio
                        Management
                    </p>

                </div>

                <!-- Certifications Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between relative min-h-[240px]"><svg
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="2rem"
                        class="absolute top-6 right-6">
                        <path
                            d="M 12 1.5351562 L 9.4414062 3.125 L 6.4375 3.34375 L 5.3007812 6.1328125 L 3 8.0761719 L 3.7207031 11 L 3 13.923828 L 5.3007812 15.867188 L 6.4375 18.65625 L 9.4414062 18.875 L 12 20.464844 L 14.558594 18.875 L 17.5625 18.65625 L 18.699219 15.867188 L 21 13.923828 L 20.279297 11 L 21 8.0761719 L 18.699219 6.1328125 L 17.5625 3.34375 L 14.558594 3.125 L 12 1.5351562 z M 12 6 C 14.757 6 17 8.243 17 11 C 17 13.757 14.757 16 12 16 C 9.243 16 7 13.757 7 11 C 7 8.243 9.243 6 12 6 z M 12 8 A 3 3 0 0 0 12 14 A 3 3 0 0 0 12 8 z M 2.4824219 16.103516 L 0 18.585938 L 0 19.90625 L 3.1894531 20.810547 L 4.09375 24 L 5.4140625 24 L 8.5957031 20.818359 L 6.2929688 20.650391 L 5.0546875 20.560547 L 4.5859375 19.410156 L 3.6347656 17.078125 L 2.4824219 16.103516 z M 21.517578 16.103516 L 20.365234 17.078125 L 19.414062 19.410156 L 18.945312 20.560547 L 17.707031 20.650391 L 15.404297 20.818359 L 18.585938 24 L 19.90625 24 L 20.810547 20.810547 L 24 19.90625 L 24 18.585938 L 21.517578 16.103516 z"
                            fill="#e1dfd0" />
                    </svg>

                    <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Certifications</h3>
                    <p class="font-haas-display font-medium text-body-lg text-dm-white leading-tight">
                        PMP / Google Project Management / Agile Project Management / Project Planning / Project
                        Execution
                    </p>

                </div>

                <!-- Expertise Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between relative min-h-[240px]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="2rem"
                        class="absolute top-6 right-6">
                        <path
                            d="M 11.662109 1 C 5.0231094 1 2 5.665 2 10 C 2 12.627 3.0446406 14.123312 4.0566406 15.570312 C 5.0556406 17.001312 6 18.353 6 21 L 6 22 L 15.876953 22 L 15.990234 21.130859 C 15.991234 21.123859 16.069937 20.582 16.335938 20 L 17.900391 20 C 19.609391 20 21 18.609391 21 16.900391 L 21 14.294922 L 22.244141 12.355469 L 21.755859 11.791016 C 21.738859 11.771016 20 9.7333438 20 7.5273438 C 20 3.8063438 16.415109 1 11.662109 1 z M 10.267578 5.6660156 L 11.730469 5.6660156 L 11.933594 6.6640625 C 12.502594 6.8230625 13.013828 7.1214375 13.423828 7.5234375 L 14.388672 7.1992188 L 15.119141 8.4667969 L 14.355469 9.1425781 C 14.425469 9.4165781 14.466797 9.703 14.466797 10 C 14.466797 10.297 14.426469 10.584375 14.355469 10.859375 L 15.117188 11.533203 L 14.388672 12.800781 L 13.423828 12.476562 C 13.013828 12.878562 12.503547 13.176938 11.935547 13.335938 L 11.732422 14.333984 L 10.269531 14.333984 L 10.066406 13.335938 C 9.4974063 13.176937 8.9861719 12.878563 8.5761719 12.476562 L 7.6113281 12.800781 L 6.8808594 11.533203 L 7.6445312 10.857422 C 7.5745312 10.583422 7.5332031 10.297 7.5332031 10 C 7.5332031 9.703 7.5735313 9.415625 7.6445312 9.140625 L 6.8808594 8.4667969 L 7.6113281 7.1992188 L 8.5761719 7.5234375 C 8.9861719 7.1214375 9.4954531 6.8230625 10.064453 6.6640625 L 10.267578 5.6660156 z M 11 8.3144531 C 10.07 8.3144531 9.3144531 9.069 9.3144531 10 C 9.3144531 10.93 10.069 11.683594 11 11.683594 C 11.931 11.683594 12.685547 10.93 12.685547 10 C 12.685547 9.07 11.93 8.3144531 11 8.3144531 z"
                            fill="#e1dfd0" />
                    </svg>


                    <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Expertise</h3>
                    <p class="font-haas-display font-medium text-body-lg text-dm-white leading-tight">
                        Sales Enablement / Webinars & Live Events / Podcasts / Product Launches / Community Events /
                        Demand Generation Campaigns / Rich Media Content
                    </p>

                </div>

                <!-- Tools Card -->
                <div class="bg-dm-black p-6 flex flex-col justify-between relative min-h-[240px]">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="2rem"
                        class="absolute top-6 right-6">
                        <path
                            d="M22,10c-0.738,0-1.376,0.405-1.723,1H13V9h6V5.723C19.595,5.376,20,4.738,20,4c0-1.105-0.895-2-2-2s-2,0.895-2,2	c0,0.738,0.405,1.376,1,1.723V7h-4V3.333l-0.331-0.298C11.927,2.368,10.979,2,10,2C8.815,2,7.732,2.523,6.992,3.382L6.983,3.374	C6.898,3.472,6.831,3.582,6.756,3.687C6.73,3.724,6.701,3.759,6.676,3.797c-0.092,0.138-0.171,0.282-0.245,0.43	C6.425,4.239,6.417,4.25,6.412,4.262C4.405,4.937,3,6.849,3,9c0,0.48,0.069,0.953,0.207,1.413C2.425,11.452,2,12.704,2,14	c0,2.42,1.468,4.588,3.693,5.516C6.588,21.058,8.203,22,10,22c0.874,0,1.716-0.232,2.503-0.69L13,21.02V17h3v1.277	c-0.595,0.346-1,0.984-1,1.723c0,1.105,0.895,2,2,2s2-0.895,2-2c0-0.738-0.405-1.376-1-1.723V15h-5v-2h7.277	c0.346,0.595,0.984,1,1.723,1c1.105,0,2-0.895,2-2C24,10.895,23.105,10,22,10z"
                            fill="#e1dfd0" />
                    </svg>

                    <h3 class="font-haas-display font-medium text-heading-md text-dm-white mb-2">Tools</h3>
                    <p class="font-haas-display font-medium text-body-lg text-dm-white leading-tight">
                        Google Workspace / Office 365 / Sharepoint / Adobe CC / Riverside FM / Trello
                    </p>

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