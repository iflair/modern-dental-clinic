<section class="mlt-hours" id="hours">
    <div class="mlt-container">
        <?php
        // Section title with fallback + translation
        $section_title = function_exists( 'mlt_get_option' ) 
            ? mlt_get_option( 'mlt_hours_section_title', __( 'Clinic Hours & Location', 'modern-dental-clinic' ) ) 
            : __( 'Clinic Hours & Location', 'modern-dental-clinic' );
        ?>

        <h2 class="mlt-section-title"><?php echo esc_html( $section_title ); ?></h2>

        <div class="mlt-hours-wrapper">
            <div class="mlt-hours-list">

                <h3><?php echo esc_html__( 'Office Hours', 'modern-dental-clinic' ); ?></h3>

                <?php
                $office_hours_json = function_exists('mlt_get_option') ? mlt_get_option( 'mlt_office_hours', '' ) : '';

                // OPTION 1 — Custom JSON Saved Through Theme Panel
                if ( ! empty( $office_hours_json ) ) :

                    $hours_array = json_decode( $office_hours_json, true );

                    if ( is_array( $hours_array ) && ! empty( $hours_array ) ) :
                        ?>
                        <table class="mlt-hours-table">
                            <?php foreach ( $hours_array as $row ) : 
                                $day   = isset($row['day'])   ? sanitize_text_field( $row['day'] )   : '';
                                $hours = isset($row['hours']) ? sanitize_text_field( $row['hours'] ) : '';

                                if ( $day && $hours ) : ?>
                                    <tr>
                                        <td><strong><?php echo esc_html( $day ); ?></strong></td>
                                        <td><?php echo esc_html( $hours ); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </table>
                        <?php
                    endif;

                // OPTION 2 — ACF Repeater (fallback)
                elseif ( function_exists('have_rows') && have_rows('mlt_clinic_hours') ) :
                    ?>
                    <table class="mlt-hours-table">
                        <?php while ( have_rows('mlt_clinic_hours') ) : the_row();
                            $day   = get_sub_field('day');
                            $hours = get_sub_field('hours');
                            ?>
                            <tr>
                                <td><strong><?php echo esc_html( $day ); ?></strong></td>
                                <td><?php echo esc_html( $hours ); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </table>

                <?php 
                // OPTION 3 — Hardcoded fallback
                else : ?>
                    <div class="mlt-hours-fallback">
                        <p><strong><?php echo esc_html__( 'Monday - Friday:', 'modern-dental-clinic' ); ?></strong> 9:00 AM - 6:00 PM</p>
                        <p><strong><?php echo esc_html__( 'Saturday:', 'modern-dental-clinic' ); ?></strong> 10:00 AM - 4:00 PM</p>
                        <p><strong><?php echo esc_html__( 'Sunday:', 'modern-dental-clinic' ); ?></strong> <?php echo esc_html__( 'Closed', 'modern-dental-clinic' ); ?></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mlt-location-info">
                <h3><?php echo esc_html__( 'Get in Touch', 'modern-dental-clinic' ); ?></h3>

                <?php
                // Option values with translation-ready fallbacks
                $clinic_address = mlt_get_option( 'mlt_clinic_address', __( '123 Main Street, Your City, State 12345', 'modern-dental-clinic' ) );
                $clinic_phone   = mlt_get_option( 'mlt_clinic_phone', '555-123-4567' );
                $clinic_email   = mlt_get_option( 'mlt_clinic_email', get_option('admin_email') );
                ?>

                <?php if ( ! empty( $clinic_address ) ) : ?>
                    <p>
                        <strong><?php echo esc_html__( 'Address:', 'modern-dental-clinic' ); ?></strong><br>
                        <?php echo esc_html( $clinic_address ); ?>
                    </p>
                <?php endif; ?>

                <?php if ( ! empty( $clinic_phone ) ) : ?>
                    <p>
                        <strong><?php echo esc_html__( 'Phone:', 'modern-dental-clinic' ); ?></strong><br>
                        <a href="tel:<?php echo esc_attr( preg_replace('/\D/', '', $clinic_phone) ); ?>">
                            <?php echo esc_html( $clinic_phone ); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <?php if ( ! empty( $clinic_email ) ) : ?>
                    <p>
                        <strong><?php echo esc_html__( 'Email:', 'modern-dental-clinic' ); ?></strong><br>
                        <a href="mailto:<?php echo esc_attr( $clinic_email ); ?>">
                            <?php echo esc_html( $clinic_email ); ?>
                        </a>
                    </p>
                <?php endif; ?>

                <a href="#contact" class="mlt-btn">
                    <?php echo esc_html__( 'Schedule Appointment', 'modern-dental-clinic' ); ?>
                </a>

            </div>
        </div>
    </div>
</section>
