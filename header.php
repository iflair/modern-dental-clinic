<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="mlt-header">
    <div class="mlt-container">
        <div class="mlt-branding">
            <div class="mlt-logo-box">
                <?php 
                // Display custom logo if set, otherwise clinic name
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    $clinic_name = mlt_get_option('mlt_clinic_name', get_bloginfo('name'));
                    echo '<a class="mlt-logo" href="' . esc_url(home_url('/')) . '">' . esc_html($clinic_name) . '</a>';
                }
                ?>
            </div>
            
            <div class="mlt-site-info">
                <h1 class="mlt-site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php echo esc_html(get_bloginfo('name')); ?></a></h1>
                <?php 
                $tagline = get_bloginfo('description');
                if (!empty($tagline)) {
                    echo '<p class="mlt-site-tagline">' . esc_html($tagline) . '</p>';
                }
                ?>
            </div>
        </div>
        
        <div class="mlt-nav-wrapper">
            <button class="mlt-menu-toggle" aria-label="Toggle menu" id="mlt-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <?php if (has_nav_menu('primary')) : ?>
                <nav class="mlt-nav" id="mlt-nav-menu">
                    <?php wp_nav_menu(array('theme_location'=>'primary','container'=>false,'fallback_cb' => 'wp_page_menu')); ?>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</header>
