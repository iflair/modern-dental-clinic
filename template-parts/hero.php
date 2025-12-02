<section class="mlt-hero" role="banner">
    <div class="mlt-hero-slider">

        <?php
        // Retrieve hero slides (JSON)
        $hero_slides_raw = function_exists('mlt_get_option')
            ? mlt_get_option('mlt_hero_slides', '')
            : '';

        // If empty, create a default slide
        if (empty($hero_slides_raw)) {
            $hero_slides_raw = wp_json_encode(array(
                array(
                    'title'    => get_the_title(),
                    'subtitle' => get_the_excerpt() ?: __('Your trusted partner for exceptional dental care', 'modern-dental-clinic'),
                    'image'    => '',
                    'cta_text' => __('Book Your Appointment', 'modern-dental-clinic'),
                ),
            ));
        }

        // Decode JSON safely
        $slides = json_decode($hero_slides_raw, true);
        if (!is_array($slides) || empty($slides)) {
            $slides = array(
                array(
                    'title'    => get_the_title(),
                    'subtitle' => __('Your trusted partner for exceptional dental care', 'modern-dental-clinic'),
                    'image'    => '',
                    'cta_text' => __('Book Your Appointment', 'modern-dental-clinic'),
                ),
            );
        }
        ?>

        <div class="mlt-hero-slides-container">

            <?php foreach ($slides as $index => $slide) :

                // Normalize values safely
                $bg_image_raw = isset($slide['image']) ? (string) $slide['image'] : '';
                $bg_image_raw = str_replace('\\/', '/', $bg_image_raw);
                $bg_image = esc_url($bg_image_raw);

                $slide_title    = !empty($slide['title']) ? esc_html($slide['title']) : __('Welcome', 'modern-dental-clinic');
                $slide_subtitle = !empty($slide['subtitle']) ? esc_html($slide['subtitle']) : __('Your trusted partner for exceptional dental care', 'modern-dental-clinic');
                $slide_cta      = !empty($slide['cta_text']) ? esc_html($slide['cta_text']) : __('Book Your Appointment', 'modern-dental-clinic');

                $bg_style = $bg_image ? 'background-image: url(' . $bg_image . ');' : '';
            ?>

                <div class="mlt-hero-slide" style="<?php echo esc_attr($bg_style); ?>">
                    <div class="mlt-hero-slide-overlay"></div>

                    <div class="mlt-container">
                        <div class="mlt-hero-inner">

                            <h1 class="mlt-hero-title">
                                <?php echo $slide_title; ?>
                            </h1>

                            <?php if ($slide_subtitle) : ?>
                                <p class="mlt-hero-subtitle"><?php echo $slide_subtitle; ?></p>
                            <?php endif; ?>

                            <?php if ($slide_cta) : ?>
                                <p>
                                    <a class="mlt-btn" href="#contact">
                                        <?php echo $slide_cta; ?>
                                    </a>
                                </p>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <?php if (count($slides) > 1) : ?>
            <!-- Navigation buttons -->
            <button class="mlt-hero-prev" aria-label="<?php esc_attr_e('Previous Slide', 'modern-dental-clinic'); ?>">
                <i class="fas fa-chevron-left" aria-hidden="true"></i>
            </button>

            <button class="mlt-hero-next" aria-label="<?php esc_attr_e('Next Slide', 'modern-dental-clinic'); ?>">
                <i class="fas fa-chevron-right" aria-hidden="true"></i>
            </button>

            <!-- Pagination dots -->
            <div class="mlt-hero-dots" role="tablist">
                <?php foreach ($slides as $index => $slide) : ?>
                    <button
                        class="mlt-hero-dot <?php echo $index === 0 ? 'active' : ''; ?>"
                        data-slide="<?php echo esc_attr($index); ?>"
                        aria-label="<?php echo esc_attr(sprintf(__('Go to slide %d', 'modern-dental-clinic'), $index + 1)); ?>"
                        role="tab"
                        aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>"
                    ></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
