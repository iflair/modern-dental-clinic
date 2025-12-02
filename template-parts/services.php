<section class="mlt-services" id="services">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option')
                ? mlt_get_option('mlt_services_section_title', __('Our Dental Services', 'modern-dental-clinic'))
                : __('Our Dental Services', 'modern-dental-clinic');

            $services = function_exists('mlt_get_services') ? mlt_get_services() : array();
        ?>
        
        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>

        <div class="mlt-services-grid">
            <?php if (!empty($services)) : ?>

                <?php foreach ($services as $item) : ?>
                    <div class="mlt-service-card">
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['content']); ?></p>
                        <a href="#contact" class="mlt-btn mlt-btn-sm">
                            <?php esc_html_e('Book Now', 'modern-dental-clinic'); ?>
                        </a>
                    </div>
                <?php endforeach; ?>

            <?php elseif (function_exists('have_rows') && have_rows('mlt_services')) : ?>

                <?php while (have_rows('mlt_services')) : the_row(); 
                    $title = get_sub_field('title');
                    $icon  = get_sub_field('icon');
                    $text  = get_sub_field('text');
                    $price = get_sub_field('price');
                ?>
                    <div class="mlt-service-card">

                        <?php if (!empty($icon)) : ?>
                            <div class="mlt-service-icon">
                                <img src="<?php echo esc_url($icon['url']); ?>"
                                     alt="<?php echo esc_attr($title); ?>">
                            </div>
                        <?php endif; ?>

                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo wp_kses_post($text); ?></p>

                        <?php if (!empty($price)) : ?>
                            <div class="mlt-service-price">
                                <?php esc_html_e('Starting from:', 'modern-dental-clinic'); ?>
                                <strong><?php echo esc_html($price); ?></strong>
                            </div>
                        <?php endif; ?>

                        <a href="#contact" class="mlt-btn mlt-btn-sm">
                            <?php esc_html_e('Book Now', 'modern-dental-clinic'); ?>
                        </a>
                    </div>

                <?php endwhile; ?>

            <?php else : ?>

                <?php
                // Fallback default services
                $default_services = array(
                    array(
                        'title' => __('General Checkup', 'modern-dental-clinic'),
                        'desc'  => __('Comprehensive dental examination and preventive care for your oral health.', 'modern-dental-clinic')
                    ),
                    array(
                        'title' => __('Teeth Cleaning', 'modern-dental-clinic'),
                        'desc'  => __('Professional cleaning to remove plaque and tartar buildup.', 'modern-dental-clinic')
                    ),
                    array(
                        'title' => __('Teeth Whitening', 'modern-dental-clinic'),
                        'desc'  => __('Professional whitening treatments for a brighter, more confident smile.', 'modern-dental-clinic')
                    ),
                    array(
                        'title' => __('Dental Implants', 'modern-dental-clinic'),
                        'desc'  => __('Permanent tooth replacement solution for missing teeth.', 'modern-dental-clinic')
                    ),
                    array(
                        'title' => __('Root Canal', 'modern-dental-clinic'),
                        'desc'  => __('Advanced treatment to save infected or damaged teeth.', 'modern-dental-clinic')
                    ),
                    array(
                        'title' => __('Orthodontics', 'modern-dental-clinic'),
                        'desc'  => __('Braces and aligners to straighten teeth and improve bite.', 'modern-dental-clinic')
                    ),
                );
                ?>

                <?php foreach ($default_services as $service) : ?>
                    <div class="mlt-service-card">
                        <h3><?php echo esc_html($service['title']); ?></h3>
                        <p><?php echo esc_html($service['desc']); ?></p>
                        <a href="#contact" class="mlt-btn mlt-btn-sm">
                            <?php esc_html_e('Book Now', 'modern-dental-clinic'); ?>
                        </a>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
</section>
