<?php
/**
 * Homepage Header
 *
 * @package WPThemeStarter
 */
?>
<header class="w-full max-w-page mx-auto px-6 lg:px-0">
    <div class="flex flex-col gap-9">
        <!-- Navigation Bar -->
        <div class="flex flex-col gap-6">
            <nav class="flex flex-row items-center justify-between py-6">
                <!-- Logo -->
                <a href="<?php echo home_url(); ?>" class="block">
                    <div class="text-dm-black font-haas-display text-2xl font-bold">
                        Damien Mulhall
                    </div>
                </a>
                
                <!-- Menu -->
                <div class="hidden md:flex flex-row gap-8 items-center">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'header-menu',
                        'container' => false,
                        'menu_class' => 'flex flex-row gap-8 items-center',
                        'fallback_cb' => function() {
                            echo '<ul class="flex flex-row gap-8 items-center">';
                            echo '<li><a href="#" class="font-haas-text font-bold text-body-sm text-dm-black hover:text-dm-cyan transition-colors">Download CV</a></li>';
                            echo '<li><a href="#work" class="font-haas-text font-bold text-body-sm text-dm-black hover:text-dm-cyan transition-colors">Work</a></li>';
                            echo '<li><a href="#contact" class="font-haas-text font-bold text-body-sm text-dm-black hover:text-dm-cyan transition-colors">Contact me</a></li>';
                            echo '</ul>';
                        },
                        'walker' => new class extends Walker_Nav_Menu {
                            function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
                                $classes = 'font-haas-text font-bold text-body-sm text-dm-black hover:text-dm-cyan transition-colors';
                                $output .= '<li>';
                                $output .= '<a href="' . esc_attr($item->url) . '" class="' . $classes . '">';
                                $output .= esc_html($item->title);
                                $output .= '</a>';
                                $output .= '</li>';
                            }
                        }
                    ));
                    ?>
                </div>

                <!-- Mobile Menu Button -->
                <button class="md:hidden text-dm-black" id="mobile-menu-toggle">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </nav>
            
            <!-- Divider -->
            <div class="w-full h-[3px] bg-dm-black"></div>
        </div>
        
        <!-- Hero Text -->
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-28 items-start justify-between">
            <h1 class="font-haas-display font-medium text-display-md lg:text-display-xl leading-none text-dm-black max-w-3xl">
                I lead creative projects from concept to delivery.
            </h1>
            <p class="font-haas-text font-medium text-body-md text-dm-black max-w-sm lg:pt-4">
                I've spent over 10 years leading creative projects—mostly in agency settings where content, deadlines, and expectations all move fast.
            </p>
        </div>
        
        <!-- Divider -->
        <div class="w-full h-[3px] bg-dm-black"></div>
        
        <!-- CTA Buttons -->
        <div class="flex flex-row gap-3.5 items-center justify-end">
            <div class="bg-dm-purple rounded-full w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-center">
                <span class="font-haas-display font-medium text-heading-sm text-dm-white">C</span>
            </div>
            <div class="bg-dm-red rounded-full w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-center">
                <span class="font-haas-display font-medium text-heading-sm text-dm-white">W</span>
            </div>
            <a href="#work" class="bg-dm-green rounded-full px-6 py-3 flex items-center gap-3 hover:bg-opacity-90 transition-all">
                <span class="font-haas-display font-medium text-heading-sm text-dm-white">Projects</span>
                <svg class="w-8 h-8 text-dm-white" viewBox="0 0 32 32" fill="none">
                    <path d="M8 12L16 20L24 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        
        <!-- Divider -->
        <div class="w-full h-[3px] bg-dm-black"></div>
    </div>
</header>