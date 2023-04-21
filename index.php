<?php get_header(); ?>

<main id="content">
    <?php
    if (have_posts()) :
        while (have_posts()) :
            the_post();
    ?>
            <?php the_content(); ?>
            </div>
    <?php endwhile;
    endif; ?>
</main>

<?php get_footer(); ?>