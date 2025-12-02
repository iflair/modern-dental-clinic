<?php
/**
 * Dental Theme - Helper Functions
 * Convenient functions to access theme settings and options
 */

if (!defined('ABSPATH')) exit;

/**
 * Get a theme option value
 */
function mlt_get_option($option_name, $default = '') {
    return get_theme_mod($option_name, $default);
}

/**
 * Get clinic information
 */
function mlt_get_clinic_info() {
    return array(
        'name'       => mlt_get_option('mlt_clinic_name', get_bloginfo('name')),
        'phone'      => mlt_get_option('mlt_clinic_phone', ''),
        'email'      => mlt_get_option('mlt_clinic_email', get_option('admin_email')),
        'address'    => mlt_get_option('mlt_clinic_address', ''),
        'description' => mlt_get_option('mlt_clinic_description', ''),
    );
}

/**
 * Get clinic contact info for frontend display
 */
function mlt_get_clinic_contact() {
    $info = mlt_get_clinic_info();
    return array(
        'name' => $info['name'],
        'phone' => $info['phone'],
        'email' => $info['email'],
        'address' => $info['address'],
    );
}

/**
 * Get color settings
 */
function mlt_get_colors() {
    return array(
        'accent'       => mlt_get_option('mlt_accent_color', '#0b76d1'),
        'secondary'    => mlt_get_option('mlt_secondary_color', '#e6f2ff'),
        'text'         => mlt_get_option('mlt_text_color', '#222222'),
        'background'   => mlt_get_option('mlt_background_color', '#ffffff'),
    );
}

/**
 * Get social media links
 */
function mlt_get_social_links() {
    $socials = array('facebook', 'twitter', 'instagram', 'youtube', 'linkedin');
    $links = array();
    
    foreach ($socials as $social) {
        $url = mlt_get_option('mlt_social_' . $social, '');
        if (!empty($url)) {
            $links[$social] = $url;
        }
    }
    
    return $links;
}

/**
 * Get contact form settings
 */
function mlt_get_contact_form_settings() {
    return array(
        'email' => mlt_get_option('mlt_contact_email', get_option('admin_email')),
        'success_message' => mlt_get_option('mlt_success_message', 'Thanks — your appointment request was sent. We\'ll contact you shortly!'),
        'error_message' => mlt_get_option('mlt_error_message', 'Please fill in all required fields.'),
    );
}

/**
 * Get homepage visibility settings
 */
function mlt_show_section($section) {
    $setting = 'mlt_show_' . $section;
    return mlt_get_option($setting, 1);
}

/**
 * Display custom CSS from theme options
 */
function mlt_get_custom_css() {
    $colors = mlt_get_colors();
    
    $css = ":root {
        --accent: {$colors['accent']};
        --accent-light: {$colors['secondary']};
        --text-color: {$colors['text']};
        --bg: {$colors['background']};
    }";
    
    return $css;
}

/**
 * Get all submissions from database
 */
function mlt_get_all_submissions($limit = null) {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    $query = "SELECT * FROM $table ORDER BY submitted_at DESC";
    
    if ($limit) {
        $query .= " LIMIT " . intval($limit);
    }
    
    return $wpdb->get_results($query);
}

/**
 * Get submission by ID
 */
function mlt_get_submission($id) {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    return $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table WHERE id = %d",
        $id
    ));
}

/**
 * Mark submission as read
 */
function mlt_mark_submission_read($id) {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    return $wpdb->update(
        $table,
        array('read_status' => 1),
        array('id' => $id),
        array('%d'),
        array('%d')
    );
}

/**
 * Delete submission
 */
function mlt_delete_submission($id) {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    return $wpdb->delete(
        $table,
        array('id' => $id),
        array('%d')
    );
}

/**
 * Get unread submissions count
 */
function mlt_get_unread_count() {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    return (int) $wpdb->get_var(
        "SELECT COUNT(*) FROM $table WHERE read_status = 0"
    );
}

/**
 * Get submissions statistics
 */
function mlt_get_submissions_stats() {
    global $wpdb;
    $table = $wpdb->prefix . 'mlt_contact_submissions';
    
    $total = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table");
    $unread = mlt_get_unread_count();
    $today = (int) $wpdb->get_var("SELECT COUNT(*) FROM $table WHERE DATE(submitted_at) = CURDATE()");
    
    return array(
        'total' => $total,
        'unread' => $unread,
        'today' => $today,
    );
}

/**
 * Export submissions to CSV
 */
function mlt_export_submissions_csv() {
    $submissions = mlt_get_all_submissions();
    
    $csv = "Name,Email,Phone,Service,Appointment Date,Time Slot,Status,Message,Submitted At\n";
    
    foreach ($submissions as $submission) {
        $csv .= sprintf(
            '"%s","%s","%s","%s","%s","%s","%s"' . "\n",
            $submission->name,
            $submission->email,
            $submission->phone,
            $submission->service,
            $submission->appointment_date,
            $submission->time_slot,
            ($submission->status ?? 'pending'),
            str_replace('"', '""', $submission->message),
            $submission->submitted_at
        );
    }
    
    return $csv;
}

/**
 * Get ACF clinic settings
 */
function mlt_get_acf_clinic_settings() {
    if (function_exists('get_field')) {
        return array(
            'logo' => get_field('mlt_clinic_logo', 'option'),
            'tagline' => get_field('mlt_clinic_tagline', 'option'),
            'about' => get_field('mlt_about_text', 'option'),
            'email_alt' => get_field('mlt_clinic_email_alt', 'option'),
            'phone_alt' => get_field('mlt_clinic_phone_alt', 'option'),
        );
    }
    return array();
}
