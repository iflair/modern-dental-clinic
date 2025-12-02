<?php
// Dental Landing Theme - Main Functions
if (!defined('ABSPATH')) exit;

// Include helper functions
require_once get_template_directory() . '/inc/helpers.php';

// Include ACF Options Pages
require_once get_template_directory() . '/inc/acf-options.php';

// ========== THEME SETUP ==========
function mlt_setup() {

    // Required & recommended
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5', array('search-form','comment-form','comment-list','gallery','caption') );
    add_theme_support( 'custom-logo' );
    add_theme_support( 'custom-header' );
    add_theme_support( 'custom-background' );

    // Navigation menus
    register_nav_menus( array(
        'primary' => __( 'Primary Menu','dental-care' )
    ) );

    // Block pattern category
    register_block_pattern_category(
        'dental-care-patterns',
        array( 'label' => __( 'Dental Care Patterns', 'dental-care' ) )
    );

    // Example block pattern
    if ( function_exists( 'register_block_pattern' ) ) {
        register_block_pattern(
            'dental-care/hero-section',
            array(
                'title'       => __( 'Hero Section', 'dental-care' ),
                'description' => __( 'A simple hero section layout.', 'dental-care' ),
                'content'     => '<!-- wp:cover {"overlayColor":"black","minHeight":300} -->
<div class="wp-block-cover"><span aria-hidden="true" class="wp-block-cover__background has-black-background-color has-background"></span><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">Welcome to Dental Care</h2><!-- /wp:heading --></div></div>
<!-- /wp:cover -->',
            )
        );
    }

    // Editor styles
    add_editor_style( 'assets/css/editor-style.css' );

    // Example block style
    if ( function_exists( 'register_block_style' ) ) {
        register_block_style(
            'core/button',
            array(
                'name'  => 'dental-care-rounded',
                'label' => __( 'Rounded Button', 'dental-care' ),
            )
        );
    }
}
add_action( 'after_setup_theme', 'mlt_setup' );

// ========== ENQUEUE STYLES & SCRIPTS ==========
function mlt_assets() {

    // Enqueue Font Awesome for social icons
    wp_enqueue_style(
        'mlt-all-min-css',
        esc_url( get_stylesheet_directory_uri() . '/assets/css/all.min.css' ),
        array(),
        '6.4.0',
        'all'
    );

    // Enqueue main theme stylesheet
    wp_enqueue_style(
        'mlt-style',
        get_stylesheet_directory_uri() . '/assets/css/main.css',
        array(),
        '2.0'
    );

    // Inline custom styles from theme options
    $custom_css = mlt_get_custom_css();
    if ( ! empty( $custom_css ) ) {
        wp_add_inline_style( 'mlt-style', $custom_css );
    }

    // Enqueue main JS
    wp_enqueue_script(
        'mlt-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array(),
        '2.0',
        true
    );

    // Enqueue comment-reply script if needed
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

}
add_action( 'wp_enqueue_scripts', 'mlt_assets' );

// ========== REGISTER SIDEBARS / WIDGET AREAS ==========
function mlt_register_sidebars() {
    register_sidebar(
        array(
            'name'          => __( 'Primary Sidebar', 'dental-care' ),
            'id'            => 'sidebar-1',
            'description'   => __( 'Main sidebar that appears on posts and pages.', 'dental-care' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        )
    );
}
add_action( 'widgets_init', 'mlt_register_sidebars' );

// ========== CUSTOMIZER SETTINGS ==========
function mlt_customize_register($wp_customize) {
    // Panel for Dental Theme Options
    $wp_customize->add_panel('mlt_dental_panel', array(
        'title' => __('Dental Theme Settings', 'dental-care'),
        'priority' => 10,
    ));

    // ===== CLINIC INFO SECTION =====
    $wp_customize->add_section('mlt_clinic_info', array(
        'title' => __('Clinic Information', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 10,
    ));

    $wp_customize->add_setting('mlt_clinic_name', array(
        'default' => get_bloginfo('name'),
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_clinic_name', array(
        'label' => __('Clinic Name', 'dental-care'),
        'section' => 'mlt_clinic_info',
        'type' => 'text',
    ));

    $wp_customize->add_setting('mlt_clinic_phone', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_clinic_phone', array(
        'label' => __('Clinic Phone Number', 'dental-care'),
        'section' => 'mlt_clinic_info',
        'type' => 'tel',
    ));

    $wp_customize->add_setting('mlt_clinic_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_clinic_email', array(
        'label' => __('Clinic Email', 'dental-care'),
        'section' => 'mlt_clinic_info',
        'type' => 'email',
    ));

    $wp_customize->add_setting('mlt_clinic_address', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_clinic_address', array(
        'label' => __('Clinic Address', 'dental-care'),
        'section' => 'mlt_clinic_info',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('mlt_clinic_description', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_clinic_description', array(
        'label' => __('Clinic Description', 'dental-care'),
        'section' => 'mlt_clinic_info',
        'type' => 'textarea',
    ));

    // ===== COLORS SECTION =====
    $wp_customize->add_section('mlt_colors', array(
        'title' => __('Colors & Branding', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 20,
    ));

    $wp_customize->add_setting('mlt_accent_color', array(
        'default' => '#0b76d1',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mlt_accent_color', array(
        'label' => __('Primary Accent Color', 'dental-care'),
        'section' => 'mlt_colors',
    )));

    $wp_customize->add_setting('mlt_secondary_color', array(
        'default' => '#e6f2ff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mlt_secondary_color', array(
        'label' => __('Secondary Color', 'dental-care'),
        'section' => 'mlt_colors',
    )));

    $wp_customize->add_setting('mlt_text_color', array(
        'default' => '#222222',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mlt_text_color', array(
        'label' => __('Text Color', 'dental-care'),
        'section' => 'mlt_colors',
    )));

    $wp_customize->add_setting('mlt_background_color', array(
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mlt_background_color', array(
        'label' => __('Background Color', 'dental-care'),
        'section' => 'mlt_colors',
    )));

    // ===== CONTACT FORM SECTION =====
    $wp_customize->add_section('mlt_contact_form', array(
        'title' => __('Contact Form Settings', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 30,
    ));

    $wp_customize->add_setting('mlt_contact_email', array(
        'default' => get_option('admin_email'),
        'sanitize_callback' => 'sanitize_email',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_contact_email', array(
        'label' => __('Send Contact Form To', 'dental-care'),
        'section' => 'mlt_contact_form',
        'type' => 'email',
    ));

    $wp_customize->add_setting('mlt_success_message', array(
        'default' => 'Thanks — your appointment request was sent. We\'ll contact you shortly!',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_success_message', array(
        'label' => __('Success Message', 'dental-care'),
        'section' => 'mlt_contact_form',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('mlt_error_message', array(
        'default' => 'Please fill in all required fields.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_error_message', array(
        'label' => __('Error Message', 'dental-care'),
        'section' => 'mlt_contact_form',
        'type' => 'textarea',
    ));

    // ===== SOCIAL MEDIA SECTION =====
    $wp_customize->add_section('mlt_social_media', array(
        'title' => __('Social Media Links', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 40,
    ));

    $socials = array('facebook', 'twitter', 'instagram', 'youtube', 'linkedin');
    foreach ($socials as $social) {
        $wp_customize->add_setting('mlt_social_' . $social, array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage',
        ));
        $wp_customize->add_control('mlt_social_' . $social, array(
            'label' => ucfirst($social) . ' URL',
            'section' => 'mlt_social_media',
            'type' => 'url',
        ));
    }

    // ===== HOMEPAGE SETTINGS SECTION =====
    $wp_customize->add_section('mlt_homepage', array(
        'title' => __('Homepage Settings', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 50,
    ));

    // ===== FEATURES SECTION (Customizer-managed list) =====
    $wp_customize->add_section('mlt_features', array(
        'title' => __('Features Section', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 52,
    ));

    // ===== HERO SECTION (Slider-managed list) =====
    $wp_customize->add_section('mlt_hero', array(
        'title' => __('Hero Section (Slider)', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 51,
    ));

    $hero_defaults = array(
        array(
            'title' => 'Welcome to Our Dental Clinic',
            'subtitle' => 'Your trusted partner for exceptional dental care',
            'image' => '',
            'cta_text' => 'Book Your Appointment'
        ),
        array(
            'title' => 'Advanced Dental Solutions',
            'subtitle' => 'Experience modern dentistry with cutting-edge technology',
            'image' => '',
            'cta_text' => 'Schedule Now'
        ),
        array(
            'title' => 'Your Smile is Our Priority',
            'subtitle' => 'Expert care from compassionate professionals',
            'image' => '',
            'cta_text' => 'Get Started'
        )
    );

    $wp_customize->add_setting('mlt_hero_slides', array(
        'default' => json_encode($hero_defaults),
        'sanitize_callback' => 'mlt_sanitize_hero_slides_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_hero_slides', array(
        'label' => __('Hero Slides (JSON array)', 'dental-care'),
        'description' => __('Provide a JSON array of hero slides. Keys: "title", "subtitle", "image" (background image URL), "cta_text". Example: [{"title":"...","subtitle":"...","image":"...","cta_text":"..."}]', 'dental-care'),
        'section' => 'mlt_hero',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('mlt_hero_autoplay', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_hero_autoplay', array(
        'label' => __('Autoplay Slides', 'dental-care'),
        'section' => 'mlt_hero',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('mlt_features_section_title', array(
        'default' => 'Why Choose Us',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_features_section_title', array(
        'label' => __('Section Title', 'dental-care'),
        'section' => 'mlt_features',
        'type' => 'text',
    ));

    $wp_customize->add_setting('mlt_features_items', array(
        'default' => json_encode(array(
            array('title' => 'Expert Dentists', 'content' => 'Our experienced team provides best-in-class dental care.'),
            array('title' => 'Modern Technology', 'content' => 'State-of-the-art equipment ensures accurate diagnostics.'),
            array('title' => 'Patient Comfort', 'content' => 'We create a relaxing environment to ease dental anxiety.'),
        )),
        'sanitize_callback' => 'mlt_sanitize_features_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_features_items', array(
        'label' => __('Features Items (JSON array)', 'dental-care'),
        'description' => __('Provide a JSON array of items. Each item should have "title" and "content" keys. Example: [{"title":"X","content":"Y"}]', 'dental-care'),
        'section' => 'mlt_features',
        'type' => 'textarea',
    ));

    // ===== SERVICES SECTION (Customizer-managed list) =====
    $wp_customize->add_section('mlt_services', array(
        'title' => __('Services Section', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 53,
    ));

    $wp_customize->add_setting('mlt_services_section_title', array(
        'default' => 'Our Dental Services',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_services_section_title', array(
        'label' => __('Section Title', 'dental-care'),
        'section' => 'mlt_services',
        'type' => 'text',
    ));

    $wp_customize->add_setting('mlt_services_items', array(
        'default' => json_encode(array(
            array('title' => 'General Checkup', 'content' => 'Comprehensive dental examination and preventive care.'),
            array('title' => 'Teeth Cleaning', 'content' => 'Professional cleaning to remove plaque and tartar.'),
            array('title' => 'Teeth Whitening', 'content' => 'Professional whitening treatments.'),
        )),
        'sanitize_callback' => 'mlt_sanitize_features_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_services_items', array(
        'label' => __('Services Items (JSON array)', 'dental-care'),
        'description' => __('Provide a JSON array of items. Each item should have "title" and "content" keys. Example: [{"title":"X","content":"Y"}]', 'dental-care'),
        'section' => 'mlt_services',
        'type' => 'textarea',
    ));

    // ===== TEAM SECTION (Customizer-managed list) =====
    $wp_customize->add_section('mlt_team', array(
        'title' => __('Team Section', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 54,
    ));

    $wp_customize->add_setting('mlt_team_section_title', array(
        'default' => 'Meet Our Dental Team',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_team_section_title', array(
        'label' => __('Section Title', 'dental-care'),
        'section' => 'mlt_team',
        'type' => 'text',
    ));

    $team_defaults = array(
        array(
            'name' => 'Dr. Smith',
            'role' => 'BDS, General Dentist',
            'bio' => '15+ years of experience in general dentistry.',
            'image' => (function_exists('get_stylesheet_directory_uri') ? get_stylesheet_directory_uri() . '/assets/images/team-1.svg' : ''),
            'socials' => array(
                'facebook' => 'https://facebook.com/drsmith',
                'instagram' => 'https://instagram.com/drsmith',
                'linkedin' => 'https://linkedin.com/in/drsmith'
            )
        ),
        array(
            'name' => 'Dr. Johnson',
            'role' => 'MDS, Orthodontist',
            'bio' => 'Specializing in cosmetic and corrective orthodontics.',
            'image' => (function_exists('get_stylesheet_directory_uri') ? get_stylesheet_directory_uri() . '/assets/images/team-2.svg' : ''),
            'socials' => array(
                'facebook' => 'https://facebook.com/drjohnson',
                'twitter' => 'https://twitter.com/drjohnson',
                'linkedin' => 'https://linkedin.com/in/drjohnson'
            )
        ),
        array(
            'name' => 'Dr. Williams',
            'role' => 'BDS, Dental Hygienist',
            'bio' => 'Dedicated to preventive care and patient education.',
            'image' => (function_exists('get_stylesheet_directory_uri') ? get_stylesheet_directory_uri() . '/assets/images/team-3.svg' : ''),
            'socials' => array(
                'facebook' => 'https://facebook.com/drwilliams',
                'instagram' => 'https://instagram.com/drwilliams',
                'twitter' => 'https://twitter.com/drwilliams',
                'youtube' => 'https://youtube.com/@drwilliams'
            )
        )
    );

    $wp_customize->add_setting('mlt_team_items', array(
        'default' => json_encode($team_defaults),
        'sanitize_callback' => 'mlt_sanitize_team_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_team_items', array(
        'label' => __('Team Items (JSON array)', 'dental-care'),
        'description' => __('Provide a JSON array of team members. Keys: "name", "role", "bio", "image" (URL), "socials" (object with facebook, twitter, instagram, linkedin, youtube keys). Example: [{"name":"Dr X","role":"...","bio":"...","image":"...","socials":{"facebook":"..."}}]', 'dental-care'),
        'section' => 'mlt_team',
        'type' => 'textarea',
    ));

    // ===== TESTIMONIALS SECTION (Customizer-managed list) =====
    $wp_customize->add_section('mlt_testimonials', array(
        'title' => __('Testimonials Section', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 55,
    ));

    $wp_customize->add_setting('mlt_testimonials_section_title', array(
        'default' => 'What Our Patients Say',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_testimonials_section_title', array(
        'label' => __('Section Title', 'dental-care'),
        'section' => 'mlt_testimonials',
        'type' => 'text',
    ));

    $wp_customize->add_setting('mlt_testimonials_items', array(
        'default' => json_encode(array(
            array('content' => 'Excellent dental care! Dr. Smith was very professional and friendly.', 'author' => 'Sarah M.'),
            array('content' => 'Amazing experience from start to finish. The staff is welcoming and the facilities are very clean.', 'author' => 'John P.'),
            array('content' => 'My teeth have never looked better! The teeth whitening treatment was fantastic and painless.', 'author' => 'Maria R.'),
        )),
        'sanitize_callback' => 'mlt_sanitize_testimonials_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_testimonials_items', array(
        'label' => __('Testimonials Items (JSON array)', 'dental-care'),
        'description' => __('Provide a JSON array of testimonials. Each item should have "content" and "author" keys. Example: [{"content":"X","author":"Y"}]', 'dental-care'),
        'section' => 'mlt_testimonials',
        'type' => 'textarea',
    ));

    // ===== PRICING SECTION (Customizer-managed packages) =====
    $wp_customize->add_section('mlt_pricing', array(
        'title' => __('Pricing Section', 'dental-care'),
        'panel' => 'mlt_dental_panel',
        'priority' => 56,
    ));

    $wp_customize->add_setting('mlt_pricing_section_title', array(
        'default' => 'Our Pricing Plans',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_pricing_section_title', array(
        'label' => __('Section Title', 'dental-care'),
        'section' => 'mlt_pricing',
        'type' => 'text',
    ));

    $wp_customize->add_setting('mlt_pricing_section_subtitle', array(
        'default' => 'Affordable dental care for the whole family',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_pricing_section_subtitle', array(
        'label' => __('Section Subtitle', 'dental-care'),
        'section' => 'mlt_pricing',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('mlt_pricing_items', array(
        'default' => json_encode(array(
            array('name' => 'Basic', 'price' => 'Free', 'period' => 'Always', 'description' => 'Essential dental care', 'features' => 'Initial consultation,Basic examination,Oral health tips', 'cta_text' => 'Get Started', 'popular' => false),
            array('name' => 'Standard', 'price' => '$199', 'period' => 'Per Visit', 'description' => 'Comprehensive care', 'features' => 'Everything in Basic,Professional cleaning,X-rays and diagnosis', 'cta_text' => 'Choose Plan', 'popular' => false),
            array('name' => 'Premium', 'price' => '$499', 'period' => 'Per Visit', 'description' => 'Advanced treatments', 'features' => 'Everything in Standard,Cosmetic services,Advanced procedures,Priority scheduling', 'cta_text' => 'Choose Plan', 'popular' => true),
        )),
        'sanitize_callback' => 'mlt_sanitize_pricing_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_pricing_items', array(
        'label' => __('Pricing Packages (JSON array)', 'dental-care'),
        'description' => __('Each item: {"name","price","period","description","features"(comma-separated),"cta_text","popular"(true/false)}', 'dental-care'),
        'section' => 'mlt_pricing',
        'type' => 'textarea',
    ));

    $wp_customize->add_setting('mlt_show_services', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_show_services', array(
        'label' => __('Show Services Section', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('mlt_show_team', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_show_team', array(
        'label' => __('Show Team Section', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('mlt_show_testimonials', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_show_testimonials', array(
        'label' => __('Show Testimonials Section', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('mlt_show_hours', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_show_hours', array(
        'label' => __('Show Hours Section', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'checkbox',
    ));

    $wp_customize->add_setting('mlt_show_pricing', array(
        'default' => 1,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_show_pricing', array(
        'label' => __('Show Pricing Section', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'checkbox',
    ));

    // ===== HOURS SECTION =====
    $wp_customize->add_setting('mlt_hours_section_title', array(
        'default' => 'Clinic Hours & Location',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage',
    ));
    $wp_customize->add_control('mlt_hours_section_title', array(
        'label' => __('Hours Section Title', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'text',
    ));

    $office_hours_defaults = array(
        array('day' => 'Monday - Friday', 'hours' => '9:00 AM - 6:00 PM'),
        array('day' => 'Saturday', 'hours' => '10:00 AM - 4:00 PM'),
        array('day' => 'Sunday', 'hours' => 'Closed'),
    );

    $wp_customize->add_setting('mlt_office_hours', array(
        'default' => json_encode($office_hours_defaults),
        'sanitize_callback' => 'mlt_sanitize_office_hours_json',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('mlt_office_hours', array(
        'label' => __('Office Hours (JSON array)', 'dental-care'),
        'description' => __('Provide a JSON array of office hours. Keys: "day", "hours". Example: [{"day":"Monday - Friday","hours":"9:00 AM - 6:00 PM"},{"day":"Saturday","hours":"10:00 AM - 4:00 PM"}]', 'dental-care'),
        'section' => 'mlt_homepage',
        'type' => 'textarea',
    ));
}
add_action('customize_register', 'mlt_customize_register');

function mlt_register_block_styles() {

    // Adds a simple block style for paragraphs
    register_block_style(
        'core/paragraph',
        array(
            'name'  => 'dental-care-highlight',
            'label' => __( 'Highlight Text', 'dental-care' ),
        )
    );

}
add_action( 'init', 'mlt_register_block_styles' );

function mlt_register_block_patterns() {

    // Register a pattern category
    register_block_pattern_category(
        'dental-care',
        array( 'label' => __( 'Dental Care', 'dental-care' ) )
    );

    // Register a simple block pattern
    register_block_pattern(
        'dental-care/simple-cta',
        array(
            'title'       => __( 'Simple CTA Box', 'dental-care' ),
            'description' => __( 'A simple call-to-action block pattern.', 'dental-care' ),
            'content'     =>
                '<div class="wp-block-group" style="padding:20px; background:#f2f8ff; text-align:center;">
                    <h2>Need Dental Help?</h2>
                    <p>Book your appointment now.</p>
                    <a class="wp-block-button__link wp-element-button" href="#">Contact Us</a>
                </div>',
        )
    );

}
add_action( 'init', 'mlt_register_block_patterns' );

/**
 * Populate theme_mods with sensible defaults on theme activation
 * so the Customizer UI is pre-filled for the site admin with all sections.
 */
if (!function_exists('mlt_set_theme_defaults')) {
    function mlt_set_theme_defaults() {
        // Clinic info defaults
        $clinic_name = get_bloginfo('name');
        $admin_email = get_option('admin_email');
        $theme_uri = get_template_directory_uri();

        // Build all defaults matching Customizer register function
        $defaults = array(
            // Clinic Information (do not prefill clinic name on activation)
            'mlt_clinic_name' => 'Dental Care',
            'mlt_clinic_phone' => '555-123-4567',
            'mlt_clinic_email' => $admin_email,
            'mlt_clinic_address' => '123 Main Street, Your City, State 12345',
            'mlt_clinic_description' => 'Welcome to ' . $clinic_name . '. We provide comprehensive dental care for your entire family.',
            
            // Colors & Branding
            'mlt_accent_color' => '#0b76d1',
            'mlt_secondary_color' => '#e6f2ff',
            'mlt_text_color' => '#222222',
            'mlt_background_color' => '#ffffff',
            
            // Contact Form Settings
            'mlt_contact_email' => $admin_email,
            'mlt_success_message' => 'Thanks — your appointment request was sent. We\'ll contact you shortly!',
            'mlt_error_message' => 'Please fill in all required fields.',
            
            // Social Media (empty by default)
            'mlt_social_facebook' => 'http://facebook.com',
            'mlt_social_twitter' => 'http://twitter.com',
            'mlt_social_instagram' => 'http://instagram.com',
            'mlt_social_youtube' => 'http://youtube.com',
            'mlt_social_linkedin' => 'http://linkedin.com',
            
            // Hero Section (Slider)
            'mlt_hero_slides' => json_encode(array(
                array(
                    'title' => 'Welcome to Our Dental Clinic',
                    'subtitle' => 'Your trusted partner for exceptional dental care',
                    'image' => $theme_uri . '/assets/images/hero-1.svg',
                    'cta_text' => 'Book Your Appointment',
                ),
                array(
                    'title' => 'Advanced Dental Solutions',
                    'subtitle' => 'Experience modern dentistry with cutting-edge technology',
                    'image' => $theme_uri . '/assets/images/hero-2.svg',
                    'cta_text' => 'Schedule Now',
                ),
                array(
                    'title' => 'Your Smile is Our Priority',
                    'subtitle' => 'Expert care from compassionate professionals',
                    'image' => $theme_uri . '/assets/images/hero-3.svg',
                    'cta_text' => 'Get Started',
                ),
            )),
            'mlt_hero_autoplay' => 1,
            
            // Features Section
            'mlt_features_section_title' => 'Why Choose Us',
            'mlt_features_items' => json_encode(array(
                array('title' => 'Expert Dentists', 'content' => 'Our experienced team provides best-in-class dental care.'),
                array('title' => 'Modern Technology', 'content' => 'State-of-the-art equipment ensures accurate diagnostics.'),
                array('title' => 'Patient Comfort', 'content' => 'We create a relaxing environment to ease dental anxiety.'),
                array('title' => '24/7 Emergency Care', 'content' => 'Our dedicated emergency team is available around the clock to handle urgent dental issues.'),
                array('title' => 'Affordable Treatments', 'content' => 'We offer transparent pricing and flexible payment options to make quality dental care accessible to everyone.'),
                array('title' => 'Personalized Treatment Plans', 'content' => 'Every patient receives a customized care plan tailored to their oral health needs and goals.'),
            )),
            
            // Services Section
            'mlt_services_section_title' => 'Our Dental Services',
            'mlt_services_items' => json_encode(array(
                array('title' => 'General Checkup', 'content' => 'Comprehensive dental examination and preventive care.'),
                array('title' => 'Teeth Cleaning', 'content' => 'Professional cleaning to remove plaque and tartar.'),
                array('title' => 'Teeth Whitening', 'content' => 'Professional whitening treatments.'),
                array('title' => 'Root Canal Therapy', 'content' => 'Advanced root canal procedures to treat infected teeth and relieve pain while preserving the natural tooth.'),
                array('title' => 'Dental Implants', 'content' => 'Permanent and natural-looking tooth replacement solutions to restore your smile and confidence.'),
                array('title' => 'Orthodontic Care', 'content' => 'Braces and clear aligner treatments designed to straighten teeth and improve bite alignment.'),
            )),
            'mlt_show_services' => 1,
            
            // Team Section
            'mlt_team_section_title' => 'Meet Our Dental Team',
            'mlt_team_items' => json_encode(array(
                array(
                    'name' => 'Dr. Smith',
                    'role' => 'BDS, General Dentist',
                    'bio' => '15+ years of experience in general dentistry.',
                    'image' => $theme_uri . '/assets/images/team-1.svg',
                    'socials' => array(
                        'facebook' => 'https://facebook.com/drsmith',
                        'instagram' => 'https://instagram.com/drsmith',
                        'linkedin' => 'https://linkedin.com/in/drsmith'
                    )
                ),
                array(
                    'name' => 'Dr. Johnson',
                    'role' => 'MDS, Orthodontist',
                    'bio' => 'Specializing in cosmetic and corrective orthodontics.',
                    'image' => $theme_uri . '/assets/images/team-2.svg',
                    'socials' => array(
                        'facebook' => 'https://facebook.com/drjohnson',
                        'twitter' => 'https://twitter.com/drjohnson',
                        'linkedin' => 'https://linkedin.com/in/drjohnson'
                    )
                ),
                array(
                    'name' => 'Dr. Williams',
                    'role' => 'BDS, Dental Hygienist',
                    'bio' => 'Dedicated to preventive care and patient education.',
                    'image' => $theme_uri . '/assets/images/team-3.svg',
                    'socials' => array(
                        'facebook' => 'https://facebook.com/drwilliams',
                        'instagram' => 'https://instagram.com/drwilliams',
                        'twitter' => 'https://twitter.com/drwilliams',
                        'youtube' => 'https://youtube.com/@drwilliams'
                    )
                ),
                array(
                    'name' => 'Dr. Brown',
                    'role' => 'MDS, Endodontist',
                    'bio' => 'Expert in painless root canal treatments and restorative procedures.',
                    'image' => $theme_uri . '/assets/images/team-1.svg',
                    'socials' => array(
                        'facebook' => 'https://facebook.com/drjohnson',
                        'twitter' => 'https://twitter.com/drjohnson',
                        'linkedin' => 'https://linkedin.com/in/drjohnson'
                    )
                ),
                array(
                    'name' => 'Dr. Taylor',
                    'role' => 'BDS, Pediatric Dentist',
                    'bio' => 'Specialized in gentle dental care for children of all ages.',
                    'image' => $theme_uri . '/assets/images/team-2.svg',
                    'socials' => array(
                        'facebook' => 'https://facebook.com/drjohnson',
                        'twitter' => 'https://twitter.com/drjohnson',
                        'linkedin' => 'https://linkedin.com/in/drjohnson'
                    )
                ),
                array(
                    'name' => 'Dr. Anderson',
                    'role' => 'MDS, Oral Surgeon',
                    'bio' => 'Highly skilled in surgical procedures including extractions and implants.',
                    'image' => $theme_uri . '/assets/images/team-3.svg',
                    'socials' => array(
                        'facebook' => 'https://facebook.com/drjohnson',
                        'twitter' => 'https://twitter.com/drjohnson',
                        'linkedin' => 'https://linkedin.com/in/drjohnson'
                    )
                ),
            )),
            'mlt_show_team' => 1,
            
            // Testimonials Section
            'mlt_testimonials_section_title' => 'What Our Patients Say',
            'mlt_testimonials_items' => json_encode(array(
                array('content' => 'Excellent dental care! Dr. Smith was very professional and friendly.', 'author' => 'Sarah M.'),
                array('content' => 'Amazing experience from start to finish. The staff is welcoming and the facilities are very clean.', 'author' => 'John P.'),
                array('content' => 'My teeth have never looked better! The teeth whitening treatment was fantastic and painless.', 'author' => 'Maria R.'),
                array('content' => 'I was nervous about my procedure, but the team made me feel completely at ease. Highly recommended!', 'author' => 'Daniel K.'),
                array('content' => 'Great service and modern equipment. They explained everything clearly and made the process smooth.', 'author' => 'Priya S.'),
                array('content' => 'The best dental clinic I’ve ever visited! Friendly staff, quick service, and excellent results.', 'author' => 'Emily T.'),
            )),
            'mlt_show_testimonials' => 1,
            
            // Pricing Section
            'mlt_pricing_section_title' => 'Our Pricing Plans',
            'mlt_pricing_section_subtitle' => 'Affordable dental care for the whole family',
            'mlt_pricing_items' => json_encode(array(
                array('name' => 'Basic', 'price' => 'Free', 'period' => 'Always', 'description' => 'Essential dental care', 'features' => 'Initial consultation,Basic examination,Oral health tips', 'cta_text' => 'Get Started', 'popular' => false),
                array('name' => 'Standard', 'price' => '$199', 'period' => 'Per Visit', 'description' => 'Comprehensive care', 'features' => 'Everything in Basic,Professional cleaning,X-rays and diagnosis', 'cta_text' => 'Choose Plan', 'popular' => true),
                array('name' => 'Premium', 'price' => '$499', 'period' => 'Per Visit', 'description' => 'Advanced treatments', 'features' => 'Everything in Standard,Cosmetic services,Advanced procedures,Priority scheduling', 'cta_text' => 'Choose Plan', 'popular' => false),
            )),
            'mlt_show_pricing' => 1,
            
            // Hours Section
            'mlt_hours_section_title' => 'Clinic Hours & Location',
            'mlt_office_hours' => json_encode(array(
                array('day' => 'Monday - Friday', 'hours' => '9:00 AM - 6:00 PM'),
                array('day' => 'Saturday', 'hours' => '10:00 AM - 4:00 PM'),
                array('day' => 'Sunday', 'hours' => 'Closed'),
            )),
            'mlt_show_hours' => 1,
            
        );

        foreach ($defaults as $key => $val) {
            // Only set if theme_mod isn't already set
            $current = get_theme_mod($key, null);
            if ($current === null || $current === '') {
                set_theme_mod($key, $val);
            }
        }

        // Create a 'Landing menu' with anchor links and assign to the 'primary' location
        if (function_exists('wp_get_nav_menu_object')) {
            $menu_name = 'Landing menu';
            $menu_obj = wp_get_nav_menu_object($menu_name);
            if (!$menu_obj) {
                $menu_id = wp_create_nav_menu($menu_name);
                if (!is_wp_error($menu_id)) {
                    $links = array(
                        array('title' => 'Features', 'url' => '#features'),
                        array('title' => 'Services', 'url' => '#services'),
                        array('title' => 'Team', 'url' => '#team'),
                        array('title' => 'Testimonials', 'url' => '#testimonials'),
                        array('title' => 'Pricing', 'url' => '#pricing'),
                        array('title' => 'Hours', 'url' => '#hours'),
                        array('title' => 'Contact', 'url' => '#contact'),
                    );

                    foreach ($links as $item) {
                        wp_update_nav_menu_item($menu_id, 0, array(
                            'menu-item-title' => sanitize_text_field($item['title']),
                            'menu-item-url' => home_url($item['url']),
                            'menu-item-status' => 'publish',
                        ));
                    }

                    // Assign to 'primary' location if it's not already assigned
                    if (function_exists('get_nav_menu_locations')) {
                        $locations = get_nav_menu_locations();
                        if (empty($locations['primary'])) {
                            $locations['primary'] = $menu_id;
                            set_theme_mod('nav_menu_locations', $locations);
                        }
                    } else {
                        $locations = get_theme_mod('nav_menu_locations', array());
                        if (empty($locations['primary'])) {
                            $locations['primary'] = $menu_id;
                            set_theme_mod('nav_menu_locations', $locations);
                        }
                    }
                }
            } else {
                // If the menu exists but primary location is empty, assign it
                if (function_exists('get_nav_menu_locations')) {
                    $locations = get_nav_menu_locations();
                    if (empty($locations['primary'])) {
                        $locations['primary'] = $menu_obj->term_id;
                        set_theme_mod('nav_menu_locations', $locations);
                    }
                }
            }
        }
    }
}

add_action('after_switch_theme', 'mlt_set_theme_defaults');

// ========== GET THEME OPTIONS ==========
if (!function_exists('mlt_get_option')) {
    function mlt_get_option($option_name, $default = '') {
        return get_theme_mod($option_name, $default);
    }
}

if (!function_exists('mlt_get_custom_css')) {
    function mlt_get_custom_css() {
        $accent = mlt_get_option('mlt_accent_color', '#0b76d1');
        $secondary = mlt_get_option('mlt_secondary_color', '#e6f2ff');
        $text_color = mlt_get_option('mlt_text_color', '#222222');
        $bg_color = mlt_get_option('mlt_background_color', '#ffffff');
        
        $css = ":root {
            --accent: {$accent};
            --accent-light: {$secondary};
            --text-color: {$text_color};
            --bg: {$bg_color};
        }";
        
        return $css;
    }
}

/**
 * Sanitize hero slides JSON stored in Customizer textarea.
 */
if (!function_exists('mlt_sanitize_hero_slides_json')) {
    function mlt_sanitize_hero_slides_json($input) {
        $items = array();
        if (is_array($input)) {
            $items = $input;
        } else {
            $decoded = json_decode($input, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        }

        $clean = array();
        if (!empty($items) && is_array($items)) {
            foreach ($items as $it) {
                if (!is_array($it)) continue;
                $title = isset($it['title']) ? sanitize_text_field($it['title']) : '';
                $subtitle = isset($it['subtitle']) ? sanitize_textarea_field($it['subtitle']) : '';
                $image = isset($it['image']) ? esc_url_raw($it['image']) : '';
                $cta_text = isset($it['cta_text']) ? sanitize_text_field($it['cta_text']) : 'Learn More';
                if ($title === '') continue;
                $clean[] = array('title' => $title, 'subtitle' => $subtitle, 'image' => $image, 'cta_text' => $cta_text);
            }
        }

        return wp_json_encode($clean);
    }
}

/**
 * Get hero slides array from Customizer setting.
 */
if (!function_exists('mlt_get_hero_slides')) {
    function mlt_get_hero_slides() {
        $raw = mlt_get_option('mlt_hero_slides', '');
        if (empty($raw)) return array();
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) return array();
        $out = array();
        foreach ($decoded as $it) {
            if (!is_array($it)) continue;
            $title = isset($it['title']) ? sanitize_text_field($it['title']) : '';
            $subtitle = isset($it['subtitle']) ? sanitize_textarea_field($it['subtitle']) : '';
            $image = isset($it['image']) ? esc_url_raw($it['image']) : '';
            $cta_text = isset($it['cta_text']) ? sanitize_text_field($it['cta_text']) : 'Learn More';
            if ($title === '') continue;
            $out[] = array('title' => $title, 'subtitle' => $subtitle, 'image' => $image, 'cta_text' => $cta_text);
        }
        return $out;
    }
}

    /**
     * Sanitize features JSON stored in Customizer textarea.
     * Accepts either JSON string or array; returns a JSON string.
     */
    if (!function_exists('mlt_sanitize_features_json')) {
        function mlt_sanitize_features_json($input) {
            // If already an array, sanitize each item
            $items = array();
            if (is_array($input)) {
                $items = $input;
            } else {
                $decoded = json_decode($input, true);
                if (is_array($decoded)) {
                    $items = $decoded;
                }
            }

            $clean = array();
            if (!empty($items) && is_array($items)) {
                foreach ($items as $it) {
                    if (!is_array($it)) continue;
                    $title = isset($it['title']) ? sanitize_text_field($it['title']) : '';
                    $content = isset($it['content']) ? sanitize_textarea_field($it['content']) : '';
                    if ($title === '' && $content === '') continue;
                    $clean[] = array('title' => $title, 'content' => $content);
                }
            }

            return wp_json_encode($clean);
        }
    }

    /**
     * Get features array from Customizer setting. Returns array of items with 'title' and 'content'.
     */
    if (!function_exists('mlt_get_features')) {
        function mlt_get_features() {
            $raw = mlt_get_option('mlt_features_items', '');
            if (empty($raw)) return array();
            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) return array();
            // Ensure sanitized output (should already be sanitized on save)
            $out = array();
            foreach ($decoded as $it) {
                if (!is_array($it)) continue;
                $title = isset($it['title']) ? sanitize_text_field($it['title']) : '';
                $content = isset($it['content']) ? sanitize_textarea_field($it['content']) : '';
                if ($title === '' && $content === '') continue;
                $out[] = array('title' => $title, 'content' => $content);
            }
            return $out;
        }
    }

    if (!function_exists('mlt_get_services')) {
            /**
             * Sanitize office hours JSON stored in Customizer textarea.
             */
            if (!function_exists('mlt_sanitize_office_hours_json')) {
                function mlt_sanitize_office_hours_json($input) {
                    $items = array();
                    if (is_array($input)) {
                        $items = $input;
                    } else {
                        $decoded = json_decode($input, true);
                        if (is_array($decoded)) {
                            $items = $decoded;
                        }
                    }

                    $clean = array();
                    if (!empty($items) && is_array($items)) {
                        foreach ($items as $it) {
                            if (!is_array($it)) continue;
                            $day = isset($it['day']) ? sanitize_text_field($it['day']) : '';
                            $hours = isset($it['hours']) ? sanitize_text_field($it['hours']) : '';
                            if ($day === '' || $hours === '') continue;
                            $clean[] = array('day' => $day, 'hours' => $hours);
                        }
                    }

                    return wp_json_encode($clean);
                }
            }
        function mlt_get_services() {
            $raw = mlt_get_option('mlt_services_items', '');
            if (empty($raw)) return array();
            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) return array();
            $out = array();
            foreach ($decoded as $it) {
                if (!is_array($it)) continue;
                $title = isset($it['title']) ? sanitize_text_field($it['title']) : '';
                $content = isset($it['content']) ? sanitize_textarea_field($it['content']) : '';
                if ($title === '' && $content === '') continue;
                $out[] = array('title' => $title, 'content' => $content);
            }
            return $out;
        }
    }

    if (!function_exists('mlt_sanitize_team_json')) {
        function mlt_sanitize_team_json($input) {
            $items = array();
            if (is_array($input)) {
                $items = $input;
            } else {
                $decoded = json_decode($input, true);
                if (is_array($decoded)) {
                    $items = $decoded;
                }
            }

            $clean = array();
            if (!empty($items) && is_array($items)) {
                foreach ($items as $it) {
                    if (!is_array($it)) continue;
                    $name = isset($it['name']) ? sanitize_text_field($it['name']) : '';
                    $role = isset($it['role']) ? sanitize_text_field($it['role']) : '';
                    $bio = isset($it['bio']) ? sanitize_textarea_field($it['bio']) : '';
                    $image = isset($it['image']) ? esc_url_raw($it['image']) : '';
                    // socials can be an object/array of keys -> url, or a JSON string
                    $socials = array();
                    if (isset($it['socials']) && !empty($it['socials'])) {
                        if (is_array($it['socials'])) {
                            $socials_raw = $it['socials'];
                        } else {
                            $decoded_socials = json_decode($it['socials'], true);
                            $socials_raw = is_array($decoded_socials) ? $decoded_socials : array();
                        }
                        foreach ($socials_raw as $k => $v) {
                            $k = sanitize_key($k);
                            $v = esc_url_raw($v);
                            if (!empty($k) && !empty($v)) {
                                $socials[$k] = $v;
                            }
                        }
                    }

                    if ($name === '' && $role === '' && $bio === '' && empty($image) && empty($socials)) continue;
                    $clean[] = array('name' => $name, 'role' => $role, 'bio' => $bio, 'image' => $image, 'socials' => $socials);
                }
            }

            return wp_json_encode($clean);
        }
    }

    if (!function_exists('mlt_get_team')) {
        function mlt_get_team() {
            $raw = mlt_get_option('mlt_team_items', '');
            if (empty($raw)) return array();
            $decoded = json_decode($raw, true);
            if (!is_array($decoded)) return array();
            $out = array();
            foreach ($decoded as $it) {
                if (!is_array($it)) continue;
                $name = isset($it['name']) ? sanitize_text_field($it['name']) : '';
                $role = isset($it['role']) ? sanitize_text_field($it['role']) : '';
                $bio = isset($it['bio']) ? sanitize_textarea_field($it['bio']) : '';
                $image = isset($it['image']) ? esc_url_raw($it['image']) : '';
                $socials = array();
                if (isset($it['socials']) && is_array($it['socials'])) {
                    foreach ($it['socials'] as $k => $v) {
                        $k = sanitize_key($k);
                        $v = esc_url_raw($v);
                        if (!empty($k) && !empty($v)) $socials[$k] = $v;
                    }
                }
                if ($name === '' && $role === '' && $bio === '' && empty($image) && empty($socials)) continue;
                $out[] = array('name' => $name, 'role' => $role, 'bio' => $bio, 'image' => $image, 'socials' => $socials);
            }
            return $out;
        }
    }

/**
 * Sanitize testimonials JSON stored in Customizer textarea.
 * Accepts either JSON string or array; returns a JSON string.
 */
if (!function_exists('mlt_sanitize_testimonials_json')) {
    function mlt_sanitize_testimonials_json($input) {
        $items = array();
        if (is_array($input)) {
            $items = $input;
        } else {
            $decoded = json_decode($input, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        }

        $clean = array();
        if (!empty($items) && is_array($items)) {
            foreach ($items as $it) {
                if (!is_array($it)) continue;
                $content = isset($it['content']) ? sanitize_textarea_field($it['content']) : '';
                $author = isset($it['author']) ? sanitize_text_field($it['author']) : '';
                if ($content === '' && $author === '') continue;
                $clean[] = array('content' => $content, 'author' => $author);
            }
        }

        return wp_json_encode($clean);
    }
}

if (!function_exists('mlt_get_testimonials')) {
    function mlt_get_testimonials() {
        $raw = mlt_get_option('mlt_testimonials_items', '');
        if (empty($raw)) return array();
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) return array();
        $out = array();
        foreach ($decoded as $it) {
            if (!is_array($it)) continue;
            $content = isset($it['content']) ? sanitize_textarea_field($it['content']) : '';
            $author = isset($it['author']) ? sanitize_text_field($it['author']) : '';
            if ($content === '' && $author === '') continue;
            $out[] = array('content' => $content, 'author' => $author);
        }
        return $out;
    }
}

if (!function_exists('mlt_sanitize_pricing_json')) {
    function mlt_sanitize_pricing_json($input) {
        $items = array();
        if (is_array($input)) {
            $items = $input;
        } else {
            $decoded = json_decode($input, true);
            if (is_array($decoded)) {
                $items = $decoded;
            }
        }

        $clean = array();
        if (!empty($items) && is_array($items)) {
            foreach ($items as $it) {
                if (!is_array($it)) continue;
                $name = isset($it['name']) ? sanitize_text_field($it['name']) : '';
                $price = isset($it['price']) ? sanitize_text_field($it['price']) : '';
                $period = isset($it['period']) ? sanitize_text_field($it['period']) : '';
                $description = isset($it['description']) ? sanitize_text_field($it['description']) : '';
                $features = isset($it['features']) ? sanitize_textarea_field($it['features']) : '';
                $cta_text = isset($it['cta_text']) ? sanitize_text_field($it['cta_text']) : 'Choose Plan';
                $popular = isset($it['popular']) ? (bool) $it['popular'] : false;
                if ($name === '' && $price === '') continue;
                $clean[] = array('name' => $name, 'price' => $price, 'period' => $period, 'description' => $description, 'features' => $features, 'cta_text' => $cta_text, 'popular' => $popular);
            }
        }

        return wp_json_encode($clean);
    }
}

if (!function_exists('mlt_get_pricing')) {
    function mlt_get_pricing() {
        $raw = mlt_get_option('mlt_pricing_items', '');
        if (empty($raw)) return array();
        $decoded = json_decode($raw, true);
        if (!is_array($decoded)) return array();
        $out = array();
        foreach ($decoded as $it) {
            if (!is_array($it)) continue;
            $name = isset($it['name']) ? sanitize_text_field($it['name']) : '';
            $price = isset($it['price']) ? sanitize_text_field($it['price']) : '';
            $period = isset($it['period']) ? sanitize_text_field($it['period']) : '';
            $description = isset($it['description']) ? sanitize_text_field($it['description']) : '';
            $features = isset($it['features']) ? sanitize_textarea_field($it['features']) : '';
            $cta_text = isset($it['cta_text']) ? sanitize_text_field($it['cta_text']) : 'Choose Plan';
            $popular = isset($it['popular']) ? (bool) $it['popular'] : false;
            if ($name === '' && $price === '') continue;
            $out[] = array('name' => $name, 'price' => $price, 'period' => $period, 'description' => $description, 'features' => $features, 'cta_text' => $cta_text, 'popular' => $popular);
        }
        return $out;
    }
}

// Remove emojis and wp-embed for a lightweight theme
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
add_action('wp_footer', function () { wp_dequeue_script('wp-embed'); });

// ========== UPDATED CONTACT FORM HANDLER ==========
function mlt_handle_contact() {
    if (!isset($_POST['mlt_contact_nonce']) || !wp_verify_nonce($_POST['mlt_contact_nonce'], 'mlt_contact')) {
        wp_die('Nonce verification failed', 'Error', array('response' => 403));
    }
    
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $date = sanitize_text_field($_POST['appointment_date'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $time_slot = sanitize_text_field($_POST['time_slot'] ?? '');
    
    // Validate required fields
    if (empty($name) || empty($email)) {
        wp_safe_redirect(add_query_arg('mlt_error','required', $_SERVER['HTTP_REFERER'] ?? home_url('/')));
        exit;
    }
    
    // Get clinic name from theme settings
    $clinic_name = mlt_get_option('mlt_clinic_name', get_bloginfo('name'));
    $subject = 'Dental Appointment Request: ' . $clinic_name;
    
    // Build email body
    $body = "New Appointment Request\n";
    $body .= "======================\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Service: $service\n";
    $body .= "Preferred Date: $date\n\n";
    $body .= "Message:\n$message\n\n";
    $body .= "---\nSent from " . esc_url( home_url() );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . $clinic_name . ' <' . get_option('admin_email') . '>'
    );
    
    // Get contact email from theme settings
    $contact_email = mlt_get_option('mlt_contact_email', get_option('admin_email'));
    wp_mail($contact_email, $subject, $body, $headers);
    
    // Save contact submission to database for admin review (status defaults to 'pending')
    mlt_save_contact_submission($name, $email, $phone, $service, $date, $time_slot, 'pending', $message);
    
    // Redirect with success message
    $redirect = wp_get_referer() ? wp_get_referer() : home_url('/');
    wp_safe_redirect(add_query_arg('mlt_sent', '1', $redirect));
    exit;
}
add_action('admin_post_nopriv_mlt_contact', 'mlt_handle_contact');
add_action('admin_post_mlt_contact', 'mlt_handle_contact');

// ========== SAVE CONTACT SUBMISSIONS TO DATABASE ==========
function mlt_save_contact_submission($name, $email, $phone, $service, $date, $time_slot = '', $status = 'pending', $message = '') {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    // Ensure table exists
    mlt_create_submissions_table();
    
    $result = $wpdb->insert(
        $table,
        array(
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'service' => $service,
            'appointment_date' => $date,
            'time_slot' => $time_slot,
            'status' => $status,
            'message' => $message,
            'submitted_at' => current_time('mysql'),
            'read_status' => 0,
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d')
    );
    
    // Log any errors
    if ($result === false) {
        error_log('MLT: Database insert failed. Error: ' . $wpdb->last_error);
    }
    
    return $result;
}

// ========== CREATE DATABASE TABLE ON THEME ACTIVATION ==========
function mlt_create_submissions_table() {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(20),
        service varchar(255),
        appointment_date date,
        time_slot varchar(32),
        status varchar(20) DEFAULT 'pending',
        message longtext,
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP,
        read_status tinyint(1) DEFAULT 0,
        PRIMARY KEY (id),
        KEY email (email),
        KEY submitted_at (submitted_at)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    // Ensure new columns exist for existing installs: add if missing
    $row = $wpdb->get_results("SHOW COLUMNS FROM $table LIKE 'time_slot'");
    if (empty($row)) {
        $wpdb->query("ALTER TABLE $table ADD COLUMN time_slot varchar(32)");
    }
    $row2 = $wpdb->get_results("SHOW COLUMNS FROM $table LIKE 'status'");
    if (empty($row2)) {
        $wpdb->query("ALTER TABLE $table ADD COLUMN status varchar(20) DEFAULT 'pending'");
    }
}
register_activation_hook(__FILE__, 'mlt_create_submissions_table');

// Run table creation on every admin init to ensure it exists
add_action('admin_init', 'mlt_create_submissions_table');

// ========== ADMIN PAGE FOR MANAGING SUBMISSIONS ==========
function mlt_add_admin_menu() {
    // Ensure table exists before displaying admin page
    mlt_create_submissions_table();
    
    add_menu_page(
        __('Appointments', 'dental-care'),
        __('Appointments', 'dental-care'),
        'manage_options',
        'mlt-appointments',
        'mlt_admin_appointments_page',
        'dashicons-calendar-alt',
        5
    );
    
    add_submenu_page(
        'mlt-appointments',
        __('All Appointments', 'dental-care'),
        __('All Appointments', 'dental-care'),
        'manage_options',
        'mlt-appointments',
        'mlt_admin_appointments_page'
    );
    
    add_submenu_page(
        'mlt-appointments',
        __('Theme Settings', 'dental-care'),
        __('Settings', 'dental-care'),
        'manage_options',
        'mlt-theme-settings',
        'mlt_theme_settings_page'
    );
}
add_action('admin_menu', 'mlt_add_admin_menu');

// ========== APPOINTMENTS ADMIN PAGE ==========
function mlt_admin_appointments_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'dental-care'));
    }
    
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    // Ensure table exists
    mlt_create_submissions_table();
    
    // Check if table exists
    $table_exists = $wpdb->get_var("SHOW TABLES LIKE '$table'");
    if (!$table_exists) {
        echo '<div class="wrap"><div class="notice notice-error"><p>Error: Database table does not exist. Please deactivate and reactivate the theme.</p></div></div>';
        return;
    }
    
    // Handle delete
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
        $id = intval($_GET['id']);
        if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'mlt_delete_nonce')) {
            $wpdb->delete($table, array('id' => $id), array('%d'));
            echo '<div class="notice notice-success"><p>Appointment deleted.</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>Nonce verification failed. Action aborted.</p></div>';
        }
    }

    // Handle status update (e.g., confirm/cancel)
    if (isset($_GET['action']) && $_GET['action'] === 'status' && isset($_GET['id']) && isset($_GET['new_status'])) {
        $id = intval($_GET['id']);
        if (isset($_GET['_wpnonce']) && wp_verify_nonce($_GET['_wpnonce'], 'mlt_status_nonce')) {
            $new_status = sanitize_text_field($_GET['new_status']);
            if (in_array($new_status, array('pending','confirmed','cancelled'), true)) {
                $wpdb->update($table, array('status' => $new_status), array('id' => $id), array('%s'), array('%d'));
                echo '<div class="notice notice-success"><p>Appointment status updated.</p></div>';
            }
        } else {
            echo '<div class="notice notice-error"><p>Nonce verification failed. Action aborted.</p></div>';
        }
    }
    
    // Get all submissions
    $submissions = $wpdb->get_results("SELECT * FROM $table ORDER BY submitted_at DESC");
    
    ?>
    <div class="wrap">
        <h1><?php _e('Appointment Submissions', 'dental-care'); ?></h1>
        
        <?php if (count($submissions) > 0) : ?>
            <div class="notice notice-info"><p><?php printf(__('Total Appointments: %d', 'dental-care'), count($submissions)); ?></p></div>
        <?php endif; ?>
        
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('Name', 'dental-care'); ?></th>
                    <th><?php _e('Email', 'dental-care'); ?></th>
                    <th><?php _e('Phone', 'dental-care'); ?></th>
                    <th><?php _e('Service', 'dental-care'); ?></th>
                    <th><?php _e('Preferred Date', 'dental-care'); ?></th>
                    <th><?php _e('Time Slot', 'dental-care'); ?></th>
                    <th><?php _e('Status', 'dental-care'); ?></th>
                    <th><?php _e('Submitted', 'dental-care'); ?></th>
                    <th><?php _e('Actions', 'dental-care'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($submissions)) : ?>
                    <tr><td colspan="9"><?php _e('No appointments yet.', 'dental-care'); ?></td></tr>
                <?php else : ?>
                    <?php foreach ($submissions as $submission) : ?>
                        <tr>
                            <td><?php echo esc_html($submission->name); ?></td>
                            <td><a href="mailto:<?php echo esc_attr($submission->email); ?>"><?php echo esc_html($submission->email); ?></a></td>
                            <td><?php echo esc_html($submission->phone); ?></td>
                            <td><?php echo esc_html($submission->service); ?></td>
                            <td><?php echo esc_html($submission->appointment_date); ?></td>
                            <td><?php echo esc_html($submission->time_slot); ?></td>
                            <td><?php echo esc_html(ucfirst($submission->status ?? 'pending')); ?></td>
                            <td><?php echo wp_date('M d, Y g:i A', strtotime($submission->submitted_at)); ?></td>
                            <td>
                                <a href="#" class="mlt-view-submission" data-id="<?php echo esc_attr($submission->id); ?>">View</a> |
                                <a href="<?php echo wp_nonce_url(add_query_arg(array('action' => 'delete', 'id' => $submission->id)), 'mlt_delete_nonce'); ?>" onclick="return confirm('Are you sure?')">Delete</a>
                                <?php
                                    // Status action links
                                    $confirm_url = wp_nonce_url(add_query_arg(array('action' => 'status', 'id' => $submission->id, 'new_status' => 'confirmed')), 'mlt_status_nonce');
                                    $cancel_url = wp_nonce_url(add_query_arg(array('action' => 'status', 'id' => $submission->id, 'new_status' => 'cancelled')), 'mlt_status_nonce');
                                ?>
                                | <a href="<?php echo esc_url($confirm_url); ?>"><?php _e('Confirm', 'dental-care'); ?></a>
                                | <a href="<?php echo esc_url($cancel_url); ?>"><?php _e('Cancel', 'dental-care'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <style>
        .wp-list-table { margin-top: 20px; }
        .wp-list-table a { color: #0073aa; }
        .wp-list-table a:hover { color: #005a87; }
    </style>
    <?php
}

// ========== THEME SETTINGS ADMIN PAGE ==========
function mlt_theme_settings_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Insufficient permissions', 'dental-care'));
    }
    
    ?>
    <div class="wrap">
        <h1><?php _e('Dental Theme Settings', 'dental-care'); ?></h1>
        
        <div style="background: #e7f3ff; border-left: 4px solid #0b76d1; padding: 12px; margin: 20px 0;">
            <p><?php _e('To manage all theme settings including colors, clinic information, and social media links, please go to:', 'dental-care'); ?></p>
            <p><strong><a href="<?php echo admin_url('customize.php'); ?>"><?php _e('Appearance → Customize', 'dental-care'); ?></a></strong></p>
        </div>
        
        <h2><?php _e('Quick Links', 'dental-care'); ?></h2>
        
        <ul style="list-style: none; padding: 0;">
            <li style="margin: 10px 0;">
                <strong>→</strong> 
                <a href="<?php echo admin_url('customize.php?autofocus[panel]=mlt_dental_panel'); ?>">
                    <?php _e('Dental Theme Settings', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong> 
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_clinic_info'); ?>">
                    <?php _e('Clinic Information', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong> 
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_colors'); ?>">
                    <?php _e('Colors & Branding', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong> 
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_contact_form'); ?>">
                    <?php _e('Contact Form Settings', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_features'); ?>">
                    <?php _e('Features Section', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_services'); ?>">
                    <?php _e('Services Section', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_team'); ?>">
                    <?php _e('Team Section', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_testimonials'); ?>">
                    <?php _e('Testimonials Section', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong>
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_pricing'); ?>">
                    <?php _e('Pricing Section', 'dental-care'); ?>
                </a>
            </li>
            <li style="margin: 10px 0;">
                <strong>→</strong> 
                <a href="<?php echo admin_url('customize.php?autofocus[section]=mlt_social_media'); ?>">
                    <?php _e('Social Media Links', 'dental-care'); ?>
                </a>
            </li>
        </ul>
        
        <h2><?php _e('Current Settings Preview', 'dental-care'); ?></h2>
        
        <table class="wp-list-table widefat">
            <tbody>
                <tr>
                    <td><strong><?php _e('Clinic Name:', 'dental-care'); ?></strong></td>
                    <td><?php echo esc_html(mlt_get_option('mlt_clinic_name', get_bloginfo('name'))); ?></td>
                </tr>
                <tr>
                    <td><strong><?php _e('Phone:', 'dental-care'); ?></strong></td>
                    <td><?php echo esc_html(mlt_get_option('mlt_clinic_phone', 'Not set')); ?></td>
                </tr>
                <tr>
                    <td><strong><?php _e('Email:', 'dental-care'); ?></strong></td>
                    <td><?php echo esc_html(mlt_get_option('mlt_clinic_email', get_option('admin_email'))); ?></td>
                </tr>
                <tr>
                    <td><strong><?php _e('Primary Color:', 'dental-care'); ?></strong></td>
                    <td><span style="background: <?php echo esc_attr(mlt_get_option('mlt_accent_color', '#0b76d1')); ?>; width: 30px; height: 30px; display: inline-block; border-radius: 4px; border: 1px solid #ccc;"></span> <?php echo esc_html(mlt_get_option('mlt_accent_color', '#0b76d1')); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}

// ========== ACF LOCAL FIELD REGISTRATION ==========
if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_mlt_landing',
        'title' => 'Dental Landing Page Fields',
        'fields' => array(
            array(
                'key' => 'field_mlt_subtitle',
                'label' => 'Subtitle',
                'name' => 'mlt_subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_mlt_hero_bg',
                'label' => 'Hero Background Image',
                'name' => 'mlt_hero_bg',
                'type' => 'image',
            ),
            array(
                'key' => 'field_mlt_cta_text',
                'label' => 'CTA Button Text',
                'name' => 'mlt_cta_text',
                'type' => 'text',
                'default_value' => 'Book Appointment',
            ),
            array(
                'key' => 'field_mlt_services',
                'label' => 'Dental Services',
                'name' => 'mlt_services',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_mlt_service_title',
                        'label' => 'Service Name',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_mlt_service_icon',
                        'label' => 'Service Icon',
                        'name' => 'icon',
                        'type' => 'image',
                    ),
                    array(
                        'key' => 'field_mlt_service_text',
                        'label' => 'Description',
                        'name' => 'text',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_mlt_service_price',
                        'label' => 'Starting Price',
                        'name' => 'price',
                        'type' => 'text',
                    ),
                ),
            ),
            array(
                'key' => 'field_mlt_doctors',
                'label' => 'Dental Doctors/Team Members',
                'name' => 'mlt_doctors',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_mlt_doctor_name',
                        'label' => 'Doctor Name',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_mlt_doctor_title',
                        'label' => 'Specialization',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_mlt_doctor_image',
                        'label' => 'Photo',
                        'name' => 'image',
                        'type' => 'image',
                    ),
                    array(
                        'key' => 'field_mlt_doctor_bio',
                        'label' => 'Bio',
                        'name' => 'bio',
                        'type' => 'textarea',
                    ),
                ),
            ),
            array(
                'key' => 'field_mlt_clinic_hours',
                'label' => 'Clinic Hours',
                'name' => 'mlt_clinic_hours',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_mlt_day',
                        'label' => 'Day',
                        'name' => 'day',
                        'type' => 'select',
                        'choices' => array('Monday' => 'Monday', 'Tuesday' => 'Tuesday', 'Wednesday' => 'Wednesday', 'Thursday' => 'Thursday', 'Friday' => 'Friday', 'Saturday' => 'Saturday', 'Sunday' => 'Sunday'),
                    ),
                    array(
                        'key' => 'field_mlt_hours',
                        'label' => 'Hours',
                        'name' => 'hours',
                        'type' => 'text',
                        'placeholder' => '9:00 AM - 6:00 PM',
                    ),
                ),
            ),
        ),
        'location' => array(array(array('param' => 'page_template','operator'=>'==','value' => 'default'))),
    ));
}
