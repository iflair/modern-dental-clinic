<section class="mlt-hours" id="hours">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option') ? mlt_get_option('mlt_hours_section_title', 'Clinic Hours & Location') : 'Clinic Hours & Location';
        ?>
        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>
        <div class="mlt-hours-wrapper">
            <div class="mlt-hours-list">
                <h3>Office Hours</h3>
                <?php
                $office_hours_json = function_exists('mlt_get_option') ? mlt_get_option('mlt_office_hours', '') : '';
                
                if (!empty($office_hours_json)) :
                    $hours_array = json_decode($office_hours_json, true);
                    if (is_array($hours_array) && !empty($hours_array)) :
                        echo '<table class="mlt-hours-table">';
                        foreach ($hours_array as $row) :
                            $day = isset($row['day']) ? sanitize_text_field($row['day']) : '';
                            $hours = isset($row['hours']) ? sanitize_text_field($row['hours']) : '';
                            if (!empty($day) && !empty($hours)) :
                                echo '<tr><td><strong>' . esc_html($day) . '</strong></td><td>' . esc_html($hours) . '</td></tr>';
                            endif;
                        endforeach;
                        echo '</table>';
                    endif;
                elseif (function_exists('have_rows') && have_rows('mlt_clinic_hours')) :
                    echo '<table class="mlt-hours-table">';
                    while (have_rows('mlt_clinic_hours')) : the_row();
                        $day = get_sub_field('day');
                        $hours = get_sub_field('hours');
                        echo '<tr><td>' . esc_html($day) . '</td><td>' . esc_html($hours) . '</td></tr>';
                    endwhile;
                    echo '</table>';
                else :
                    echo '<div class="mlt-hours-fallback">';
                    echo '<p><strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM</p>';
                    echo '<p><strong>Saturday:</strong> 10:00 AM - 4:00 PM</p>';
                    echo '<p><strong>Sunday:</strong> Closed</p>';
                    echo '</div>';
                endif;
                ?>
            </div>
            <div class="mlt-location-info">
                <h3>Get in Touch</h3>
                <?php 
                // Use sensible fallbacks so "Get in Touch" shows useful info
                $clinic_address = mlt_get_option('mlt_clinic_address', '123 Main Street, Your City, State 12345');
                $clinic_phone = mlt_get_option('mlt_clinic_phone', '555-123-4567');
                $clinic_email = mlt_get_option('mlt_clinic_email', get_option('admin_email'));
                ?>
                <?php if (!empty($clinic_address)) : ?>
                    <p><strong>Address:</strong> <br><?php echo esc_html($clinic_address); ?></p>
                <?php endif; ?>
                <?php if (!empty($clinic_phone)) : ?>
                    <p><strong>Phone:</strong> <br><a href="tel:<?php echo esc_attr(preg_replace('/\D/', '', $clinic_phone)); ?>"><?php echo esc_html($clinic_phone); ?></a></p>
                <?php endif; ?>
                <?php if (!empty($clinic_email)) : ?>
                    <p><strong>Email:</strong> <br><a href="mailto:<?php echo esc_attr($clinic_email); ?>"><?php echo esc_html($clinic_email); ?></a></p>
                <?php endif; ?>
                <a href="#contact" class="mlt-btn">Schedule Appointment</a>
            </div>
        </div>
    </div>
</section>
