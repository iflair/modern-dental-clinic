<section class="mlt-hero" role="banner">
    <div class="mlt-hero-slider">
        <?php
            // Get hero slides from Customizer or use default
            $hero_slides = function_exists('mlt_get_option') ? mlt_get_option('mlt_hero_slides', '') : '';
            if (empty($hero_slides)) {
                $hero_slides = json_encode(array(
                    array('title' => get_the_title(), 'subtitle' => get_the_excerpt() ?: 'Your trusted partner for exceptional dental care', 'image' => '', 'cta_text' => 'Book Your Appointment'),
                ));
            }
            $slides = json_decode($hero_slides, true);
            if (!is_array($slides) || empty($slides)) {
                $slides = array(
                    array('title' => get_the_title(), 'subtitle' => 'Your trusted partner for exceptional dental care', 'image' => '', 'cta_text' => 'Book Your Appointment')
                );
            }
        ?>
        <div class="mlt-hero-slides-container">
            <?php foreach ($slides as $index => $slide) : 
                $bg_image = !empty($slide['image']) ? $slide['image'] : '';
                $bg_image = str_replace('\\/', '/', $bg_image);
                $slide_title = esc_html($slide['title'] ?? 'Welcome');
                $slide_subtitle = esc_html($slide['subtitle'] ?? 'Your trusted partner for exceptional dental care');
                $slide_cta = esc_html($slide['cta_text'] ?? 'Book Your Appointment');
            ?>
                <div class="mlt-hero-slide" style="<?php echo !empty($bg_image) ? 'background-image: url(' . esc_url($bg_image) . ');' : ''; ?>">
                    <div class="mlt-hero-slide-overlay"></div>
                    <div class="mlt-container">
                        <div class="mlt-hero-inner">
                            <h1 class="mlt-hero-title"><?php echo $slide_title; ?></h1>
                            <p class="mlt-hero-subtitle"><?php echo $slide_subtitle; ?></p>
                            <p><a class="mlt-btn" href="#contact"><?php echo $slide_cta; ?></a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Slider Controls (show only if multiple slides) -->
        <?php if (count($slides) > 1) : ?>
            <button class="mlt-hero-prev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
            <button class="mlt-hero-next" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
            
            <div class="mlt-hero-dots">
                <?php foreach ($slides as $index => $slide) : ?>
                    <button class="mlt-hero-dot <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>" aria-label="Go to slide <?php echo $index + 1; ?>"></button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

