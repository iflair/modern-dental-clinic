<section class="mlt-services" id="services">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option') ? mlt_get_option('mlt_services_section_title', 'Our Dental Services') : 'Our Dental Services';
            $services = function_exists('mlt_get_services') ? mlt_get_services() : array();
        ?>
        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>
        <div class="mlt-services-grid">
            <?php if (!empty($services)) : ?>
                <?php foreach ($services as $item) : ?>
                    <div class="mlt-service-card">
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['content']); ?></p>
                        <a href="#contact" class="mlt-btn mlt-btn-sm">Book Now</a>
                    </div>
                <?php endforeach; ?>
            <?php elseif (function_exists('have_rows') && have_rows('mlt_services')) :
                while (have_rows('mlt_services')) : the_row();
                    $title = get_sub_field('title');
                    $icon = get_sub_field('icon');
                    $text = get_sub_field('text');
                    $price = get_sub_field('price');
                    ?>
                    <div class="mlt-service-card">
                        <?php if ($icon) : ?>
                            <div class="mlt-service-icon">
                                <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($title); ?>">
                            </div>
                        <?php endif; ?>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo wp_kses_post($text); ?></p>
                        <?php if ($price) : ?>
                            <div class="mlt-service-price">Starting from: <strong><?php echo esc_html($price); ?></strong></div>
                        <?php endif; ?>
                        <a href="#contact" class="mlt-btn mlt-btn-sm">Book Now</a>
                    </div>
                    <?php
                endwhile;
            else :
                // Fallback default services
                $default_services = array(
                    array('title' => 'General Checkup', 'desc' => 'Comprehensive dental examination and preventive care for your oral health.'),
                    array('title' => 'Teeth Cleaning', 'desc' => 'Professional cleaning to remove plaque and tartar buildup.'),
                    array('title' => 'Teeth Whitening', 'desc' => 'Professional whitening treatments for a brighter, more confident smile.'),
                    array('title' => 'Dental Implants', 'desc' => 'Permanent tooth replacement solution for missing teeth.'),
                    array('title' => 'Root Canal', 'desc' => 'Advanced treatment to save infected or damaged teeth.'),
                    array('title' => 'Orthodontics', 'desc' => 'Braces and aligners to straighten teeth and improve bite.'),
                );
                foreach ($default_services as $service) :
                    ?>
                    <div class="mlt-service-card">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['desc']); ?></p>
                        <a href="#contact" class="mlt-btn mlt-btn-sm">Book Now</a>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
