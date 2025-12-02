<section class="mlt-features" id="features">
    <div class="mlt-container">

        <?php
            // Section title with fallback + translation support
            $section_title = function_exists('mlt_get_option')
                ? mlt_get_option('mlt_features_section_title', __('Why Choose Us', 'modern-dental-clinic'))
                : __('Why Choose Us', 'modern-dental-clinic');

            // Retrieve features array
            $features = function_exists('mlt_get_features')
                ? mlt_get_features()
                : array();
        ?>

        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>

        <div class="mlt-grid">

            <?php if (!empty($features) && is_array($features)) : ?>

                <?php foreach ($features as $item) :

                    $title   = isset($item['title']) ? trim($item['title']) : '';
                    $content = isset($item['content']) ? trim($item['content']) : '';

                    // Skip empty entries
                    if ($title === '' && $content === '') {
                        continue;
                    }
                ?>
                    <div class="mlt-feature">
                        <?php if ($title) : ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>

                        <?php if ($content) : ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

            <?php elseif (function_exists('have_rows') && have_rows('mlt_features')) : ?>

                <?php
                while (have_rows('mlt_features')) :
                    the_row();
                    $title = get_sub_field('title') ?: '';
                    $text  = get_sub_field('text') ?: '';
                ?>
                    <?php if ($title || $text) : ?>
                        <div class="mlt-feature">
                            <?php if ($title) : ?>
                                <h3><?php echo esc_html($title); ?></h3>
                            <?php endif; ?>

                            <?php if ($text) : ?>
                                <p><?php echo esc_html($text); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>

            <?php else : ?>

                <?php
                // Fallback preset features (translation ready)
                $default_features = array(
                    array(
                        'title' => __('Expert Dentists', 'modern-dental-clinic'),
                        'desc'  => __('Our experienced team of qualified dentists provides best-in-class dental care.', 'modern-dental-clinic'),
                    ),
                    array(
                        'title' => __('Modern Technology', 'modern-dental-clinic'),
                        'desc'  => __('State-of-the-art equipment ensures accurate diagnostics and painless treatments.', 'modern-dental-clinic'),
                    ),
                    array(
                        'title' => __('Patient Comfort', 'modern-dental-clinic'),
                        'desc'  => __('We create a relaxing environment to ease dental anxiety and ensure comfort.', 'modern-dental-clinic'),
                    ),
                );

                foreach ($default_features as $feature) :
                ?>
                    <div class="mlt-feature">
                        <h3><?php echo esc_html($feature['title']); ?></h3>
                        <p><?php echo esc_html($feature['desc']); ?></p>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>
</section>
