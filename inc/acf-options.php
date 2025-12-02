<?php
/**
 * Dental Theme - ACF Options Pages Registration
 * This file registers ACF options pages for managing clinic information
 */

if (!defined('ABSPATH')) exit;

// Register ACF Option Pages for Clinic Settings
if (function_exists('acf_add_options_page')) {
    
    // Main Clinic Settings Page
    acf_add_options_page(array(
        'page_title'    => __('Clinic Settings', 'modern-dental-clinic'),
        'menu_title'    => __('Clinic Settings', 'modern-dental-clinic'),
        'menu_slug'     => 'mlt-clinic-settings',
        'capability'    => 'manage_options',
        'redirect'      => false,
        'parent_slug'   => 'mlt-appointments',
        'icon_url'      => 'dashicons-hospital',
    ));
    
    // Register Clinic Settings Field Group
    acf_add_local_field_group(array(
        'key'           => 'group_mlt_clinic_settings',
        'title'         => __('Clinic Settings', 'modern-dental-clinic'),
        'fields'        => array(
            array(
                'key'           => 'field_mlt_clinic_logo',
                'label'         => __('Clinic Logo', 'modern-dental-clinic'),
                'name'          => 'mlt_clinic_logo',
                'type'          => 'image',
                'return_format' => 'url',
            ),
            array(
                'key'           => 'field_mlt_clinic_tagline',
                'label'         => __('Clinic Tagline', 'modern-dental-clinic'),
                'name'          => 'mlt_clinic_tagline',
                'type'          => 'text',
                'placeholder'   => 'Your smile is our priority',
            ),
            array(
                'key'           => 'field_mlt_about_text',
                'label'         => __('About the Clinic', 'modern-dental-clinic'),
                'name'          => 'mlt_about_text',
                'type'          => 'wysiwyg',
                'tabs'          => 'all',
                'toolbar'       => 'full',
            ),
            array(
                'key'           => 'field_mlt_clinic_email_alt',
                'label'         => __('Alternative Email', 'modern-dental-clinic'),
                'name'          => 'mlt_clinic_email_alt',
                'type'          => 'email',
            ),
            array(
                'key'           => 'field_mlt_clinic_phone_alt',
                'label'         => __('Alternative Phone', 'modern-dental-clinic'),
                'name'          => 'mlt_clinic_phone_alt',
                'type'          => 'text',
            ),
        ),
        'location'      => array(
            array(
                array(
                    'param'     => 'options_page',
                    'operator'  => '==',
                    'value'     => 'mlt-clinic-settings',
                ),
            ),
        ),
    ));
}
