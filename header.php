<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <!-- Developed by Roger Junior -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>

    <meta name="theme-color" content="<?php echo carbon_get_theme_option('theme_color'); ?>" />

    <?php wp_head(); ?>
</head>

<body <?php echo body_class() ?>>
    <a class="skip-to-content-link" href="#content">
        <?php _e('Pular para o conteúdo', 'rgrjnr'); ?>
    </a>

    <?php if (current_user_can('edit_posts')) { ?>
    <div id="wp-admin-toolbar">
        <label href="" id="wp-admin-toolbar-toggle">
            <input type="checkbox" name="toolbar-visible" id="toolbar-visible">
        </label>
        <a href="<?php echo get_edit_post_link(); ?>" target="_blank" class="wp-admin-toolbar-item">
            <div class="wp-admin-toolbar-image">✏️</div>
            <div class="wp-admin-toolbar-popover"><?php _e('Editar página', 'rgrjnr'); ?></div>
        </a> <a href="<?php echo get_admin_url(); ?>" target="_blank" class="wp-admin-toolbar-item">
            <div class="wp-admin-toolbar-image">⚙️</div>
            <div class="wp-admin-toolbar-popover"><?php _e('Painel', 'rgrjnr'); ?></div>
        </a> <a href="<?php echo get_admin_url(); ?>admin.php?page=googlesitekit-splash" target="_blank"
            class="wp-admin-toolbar-item">
            <div class="wp-admin-toolbar-image">📈</div>
            <div class="wp-admin-toolbar-popover"><?php _e('Analytics', 'rgrjnr'); ?></div>
        </a> <a href="<?php echo get_permalink(get_the_ID()); ?>?w3tc_note=flush_all" class="wp-admin-toolbar-item">
            <div class="wp-admin-toolbar-image">🔄</div>
            <div class="wp-admin-toolbar-popover"><?php _e('Limpar cache', 'rgrjnr'); ?></div>
        </a>
    </div>
    <?php
    } ?>

    <a href="https://api.whatsapp.com/send?phone=<?php echo preg_replace('/[^0-9]/', '', carbon_get_theme_option("whatsapp")); ?>&text=<?php echo carbon_get_theme_option("whatsapp-message"); ?>"
        id="whatsapp-btn"><svg width="32" height="32" viewBox="0 0 32 32" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_262_616)">
                <path
                    d="M23.6785 18.3877C23.6161 18.3577 21.2833 17.209 20.8687 17.0598C20.6995 16.999 20.5182 16.9397 20.3253 16.9397C20.0103 16.9397 19.7457 17.0967 19.5396 17.405C19.3065 17.7514 18.6011 18.576 18.3831 18.8224C18.3546 18.8549 18.3158 18.8937 18.2925 18.8937C18.2716 18.8937 17.9106 18.7451 17.8013 18.6976C15.2987 17.6105 13.3992 14.9964 13.1387 14.5556C13.1015 14.4922 13.1 14.4634 13.0997 14.4634C13.1088 14.4298 13.193 14.3455 13.2364 14.302C13.3635 14.1762 13.5011 14.0105 13.6343 13.8502C13.6974 13.7743 13.7606 13.6982 13.8226 13.6265C14.0158 13.4017 14.1019 13.2271 14.2016 13.025L14.2539 12.9199C14.4974 12.4361 14.2894 12.0278 14.2222 11.8959C14.167 11.7856 13.182 9.40824 13.0772 9.15847C12.8254 8.55577 12.4926 8.27515 12.0302 8.27515C11.9873 8.27515 12.0302 8.27515 11.8502 8.28273C11.6311 8.29198 10.4379 8.44907 9.91027 8.78164C9.35079 9.13437 8.4043 10.2587 8.4043 12.2361C8.4043 14.0157 9.53365 15.696 10.0185 16.3351C10.0306 16.3512 10.0527 16.3839 10.0848 16.4309C11.9418 19.1428 14.2567 21.1525 16.6034 22.09C18.8626 22.9924 19.9324 23.0968 20.5406 23.0968H20.5407C20.7963 23.0968 21.0009 23.0767 21.1813 23.0589L21.2958 23.048C22.0763 22.9788 23.7914 22.0901 24.1815 21.006C24.4889 20.152 24.5699 19.219 24.3654 18.8804C24.2254 18.6502 23.984 18.5344 23.6785 18.3877Z"
                    fill="#E3E1DC" />
                <path
                    d="M16.284 0C7.61743 0 0.566625 6.99782 0.566625 15.5993C0.566625 18.3813 1.31114 21.1045 2.72153 23.4879L0.0220018 31.451C-0.0282839 31.5995 0.00911872 31.7636 0.118937 31.8754C0.19821 31.9564 0.305742 32 0.41556 32C0.457638 32 0.500028 31.9937 0.541378 31.9805L8.84475 29.3419C11.117 30.5559 13.6851 31.1968 16.2841 31.1968C24.9499 31.1969 32 24.1998 32 15.5993C32 6.99782 24.9499 0 16.284 0ZM16.284 27.9474C13.8384 27.9474 11.4697 27.2412 9.43353 25.9051C9.36507 25.8602 9.28559 25.8371 9.20559 25.8371C9.1633 25.8371 9.12091 25.8435 9.07966 25.8566L4.92018 27.1788L6.26294 23.2174C6.30637 23.0891 6.28465 22.9477 6.20465 22.8384C4.65411 20.7198 3.83447 18.2166 3.83447 15.5993C3.83447 8.78961 9.4193 3.24945 16.2839 3.24945C23.1477 3.24945 28.7319 8.78961 28.7319 15.5993C28.732 22.4081 23.1479 27.9474 16.284 27.9474Z"
                    fill="#E3E1DC" />
            </g>
            <defs>
                <clipPath id="clip0_262_616">
                    <rect width="32" height="32" fill="white" />
                </clipPath>
            </defs>
        </svg>

        <div class="tooltip-right">
            Enviar mensagem
        </div>
    </a>

    <div id="loader">
        <div id="loader-progress"></div>
    </div>

    <?php get_template_part("parts/nav"); ?>

    <div id="smooth-wrapper">
        <div id="smooth-content">