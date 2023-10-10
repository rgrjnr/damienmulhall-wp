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

    <div id="loader">
        <div id="loader-progress"></div>
    </div>

    <?php get_template_part("parts/nav"); ?>

    <div id="smooth-wrapper">
        <div id="smooth-content">