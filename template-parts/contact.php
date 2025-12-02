<section class="mlt-contact" id="contact">
    <div class="mlt-container">
        <h2 class="mlt-section-title">
            <?php echo esc_html__( 'Book Your Appointment', 'modern-dental-clinic' ); ?>
        </h2>
        <?php 
        $success_msg = mlt_get_option('mlt_success_message', 'Thanks — your appointment request was sent. We\'ll contact you shortly!');
        $error_msg = mlt_get_option('mlt_error_message', 'Please fill in all required fields.');
        ?>
        <?php if (isset($_GET['mlt_sent'])) : ?>
            <div class="mlt-alert mlt-alert-success">✓ <?php echo esc_html($success_msg); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['mlt_error'])) : ?>
            <div class="mlt-alert mlt-alert-error">✗ <?php echo esc_html($error_msg); ?></div>
        <?php endif; ?>
        <form class="mlt-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <?php wp_nonce_field( 'mlt_contact', 'mlt_contact_nonce' ); ?>
        <input type="hidden" name="action" value="mlt_contact">

        <div class="mlt-form-row">
            <label for="name">
                <?php echo esc_html__( 'Full Name', 'modern-dental-clinic' ); ?> 
                <span class="required">*</span>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="<?php echo esc_attr__( 'Your full name', 'modern-dental-clinic' ); ?>" 
                    required
                >
            </label>
        </div>

        <div class="mlt-form-row">
            <label for="email">
                <?php echo esc_html__( 'Email Address', 'modern-dental-clinic' ); ?> 
                <span class="required">*</span>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="<?php echo esc_attr__( 'your@email.com', 'modern-dental-clinic' ); ?>" 
                    required
                >
            </label>
        </div>

        <div class="mlt-form-row">
            <label for="phone">
                <?php echo esc_html__( 'Phone Number', 'modern-dental-clinic' ); ?>
                <input 
                    type="tel" 
                    id="phone" 
                    name="phone" 
                    placeholder="<?php echo esc_attr__( '(123) 456-7890', 'modern-dental-clinic' ); ?>"
                >
            </label>
        </div>

        <div class="mlt-form-row">
            <label for="service">
                <?php echo esc_html__( 'Preferred Service', 'modern-dental-clinic' ); ?>
                <select id="service" name="service">
                    <option value="">
                        <?php echo esc_html__( '-- Select a Service --', 'modern-dental-clinic' ); ?>
                    </option>

                    <option value="General Checkup"><?php echo esc_html__( 'General Checkup', 'modern-dental-clinic' ); ?></option>
                    <option value="Teeth Cleaning"><?php echo esc_html__( 'Teeth Cleaning', 'modern-dental-clinic' ); ?></option>
                    <option value="Teeth Whitening"><?php echo esc_html__( 'Teeth Whitening', 'modern-dental-clinic' ); ?></option>
                    <option value="Dental Implants"><?php echo esc_html__( 'Dental Implants', 'modern-dental-clinic' ); ?></option>
                    <option value="Root Canal"><?php echo esc_html__( 'Root Canal', 'modern-dental-clinic' ); ?></option>
                    <option value="Orthodontics"><?php echo esc_html__( 'Orthodontics', 'modern-dental-clinic' ); ?></option>
                    <option value="Cosmetic Dentistry"><?php echo esc_html__( 'Cosmetic Dentistry', 'modern-dental-clinic' ); ?></option>
                    <option value="Other"><?php echo esc_html__( 'Other', 'modern-dental-clinic' ); ?></option>
                </select>
            </label>
        </div>

        <div class="mlt-form-row">
            <label for="appointment_date">
                <?php echo esc_html__( 'Preferred Appointment Date', 'modern-dental-clinic' ); ?>
                <input type="date" id="appointment_date" name="appointment_date">
            </label>
        </div>

        <div class="mlt-form-row">
            <label for="time_slot">
                <?php echo esc_html__( 'Preferred Time Slot', 'modern-dental-clinic' ); ?>
                <input 
                    type="text" 
                    id="time_slot" 
                    name="time_slot" 
                    placeholder="<?php echo esc_attr__( 'e.g., 09:30 AM — optional', 'modern-dental-clinic' ); ?>"
                >
            </label>
        </div>

        <div class="mlt-form-row">
            <label for="message">
                <?php echo esc_html__( 'Additional Notes', 'modern-dental-clinic' ); ?>
                <textarea 
                    id="message" 
                    name="message" 
                    placeholder="<?php echo esc_attr__( 'Tell us about your dental needs...', 'modern-dental-clinic' ); ?>" 
                    rows="4"
                ></textarea>
            </label>
        </div>

        <p>
            <button class="mlt-btn" type="submit">
                <?php echo esc_html__( 'Request Appointment', 'modern-dental-clinic' ); ?>
            </button>
        </p>
    </form>
    </div>
</section>
