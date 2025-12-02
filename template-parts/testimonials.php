<section class="mlt-testimonials" id="testimonials">
    <div class="mlt-container">

        <?php
            // Section title (with fallback)
            $section_title = function_exists('mlt_get_option')
                ? mlt_get_option('mlt_testimonials_section_title', __('What Our Patients Say', 'modern-dental-clinic'))
                : __('What Our Patients Say', 'modern-dental-clinic');

            // Get testimonials
            $testimonials = function_exists('mlt_get_testimonials')
                ? mlt_get_testimonials()
                : array();
        ?>

        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>

        <div class="mlt-testimonial-list">

            <?php if (!empty($testimonials) && is_array($testimonials)) : ?>

                <?php foreach ($testimonials as $t) :

                    $content = isset($t['content']) ? wp_kses_post($t['content']) : '';
                    $author  = isset($t['author']) ? esc_html($t['author']) : '';

                    if ($content === '') {
                        continue;
                    }
                ?>
                    <blockquote class="mlt-testimonial">
                        <?php echo $content; ?>
                        <?php if ($author) : ?>
                            <cite>— <?php echo $author; ?></cite>
                        <?php endif; ?>
                    </blockquote>
                <?php endforeach; ?>

            <?php else : ?>

                <?php
                // Fallback testimonials (translation ready)
                $fallbacks = array(
                    array(
                        'content' => __('"Excellent dental care! Dr. Smith was very professional and friendly. I recommend this clinic to everyone."', 'modern-dental-clinic'),
                        'author'  => __('Sarah M.', 'modern-dental-clinic'),
                    ),
                    array(
                        'content' => __('"Amazing experience from start to finish. The staff is welcoming and the facilities are very clean."', 'modern-dental-clinic'),
                        'author'  => __('John P.', 'modern-dental-clinic'),
                    ),
                    array(
                        'content' => __('"My teeth have never looked better! The teeth whitening treatment was fantastic and painless."', 'modern-dental-clinic'),
                        'author'  => __('Maria R.', 'modern-dental-clinic'),
                    ),
                    array(
                        'content' => __('"I was nervous about my root canal, but the team made me feel comfortable. Highly recommended!"', 'modern-dental-clinic'),
                        'author'  => __('David L.', 'modern-dental-clinic'),
                    ),
                );

                foreach ($fallbacks as $fb) : ?>
                    <blockquote class="mlt-testimonial">
                        <?php echo wp_kses_post($fb['content']); ?>
                        <cite>— <?php echo esc_html($fb['author']); ?></cite>
                    </blockquote>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    </div>
</section>
