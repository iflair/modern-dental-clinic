<?php
/* Template Name: Landing Page */
get_header();
?>
<?php get_template_part('template-parts/hero'); ?>
<?php get_template_part('template-parts/features'); ?>
<?php get_template_part('template-parts/services'); ?>
<?php if (function_exists('mlt_get_option') && mlt_get_option('mlt_show_team', 1)) : ?>
    <?php get_template_part('template-parts/team'); ?>
<?php endif; ?>
<?php get_template_part('template-parts/testimonials'); ?>
<?php if (function_exists('mlt_get_option') && mlt_get_option('mlt_show_pricing', 1)) : ?>
    <?php get_template_part('template-parts/pricing'); ?>
<?php endif; ?>
<?php get_template_part('template-parts/hours'); ?>
<?php get_template_part('template-parts/contact'); ?>
<?php get_footer(); ?>
