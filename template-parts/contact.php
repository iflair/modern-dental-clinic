<section class="mlt-contact" id="contact">
    <div class="mlt-container">
        <h2 class="mlt-section-title">Book Your Appointment</h2>
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
        <form class="mlt-contact-form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
            <?php wp_nonce_field('mlt_contact','mlt_contact_nonce'); ?>
            <input type="hidden" name="action" value="mlt_contact">
            
            <div class="mlt-form-row">
                <label for="name">Full Name <span class="required">*</span>
                    <input type="text" id="name" name="name" placeholder="Your full name" required>
                </label>
            </div>
            
            <div class="mlt-form-row">
                <label for="email">Email Address <span class="required">*</span>
                    <input type="email" id="email" name="email" placeholder="your@email.com" required>
                </label>
            </div>
            
            <div class="mlt-form-row">
                <label for="phone">Phone Number
                    <input type="tel" id="phone" name="phone" placeholder="(123) 456-7890">
                </label>
            </div>
            
            <div class="mlt-form-row">
                <label for="service">Preferred Service
                    <select id="service" name="service">
                        <option value="">-- Select a Service --</option>
                        <option value="General Checkup">General Checkup</option>
                        <option value="Teeth Cleaning">Teeth Cleaning</option>
                        <option value="Teeth Whitening">Teeth Whitening</option>
                        <option value="Dental Implants">Dental Implants</option>
                        <option value="Root Canal">Root Canal</option>
                        <option value="Orthodontics">Orthodontics</option>
                        <option value="Cosmetic Dentistry">Cosmetic Dentistry</option>
                        <option value="Other">Other</option>
                    </select>
                </label>
            </div>
            
            <div class="mlt-form-row">
                <label for="appointment_date">Preferred Appointment Date
                    <input type="date" id="appointment_date" name="appointment_date">
                </label>
            </div>
            
            <div class="mlt-form-row">
                <label for="time_slot">Preferred Time Slot
                    <input type="text" id="time_slot" name="time_slot" placeholder="e.g., 09:30 AM — optional">
                </label>
            </div>
            
            <div class="mlt-form-row">
                <label for="message">Additional Notes
                    <textarea id="message" name="message" placeholder="Tell us about your dental needs..." rows="4"></textarea>
                </label>
            </div>
            
            <p><button class="mlt-btn" type="submit">Request Appointment</button></p>
        </form>
    </div>
</section>
