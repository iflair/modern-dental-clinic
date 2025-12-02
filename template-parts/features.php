<section class="mlt-features" id="features">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option') ? mlt_get_option('mlt_features_section_title', 'Why Choose Us') : 'Why Choose Us';
            $features = function_exists('mlt_get_features') ? mlt_get_features() : array();
        ?>
        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>
        <div class="mlt-grid">
            <?php if (!empty($features)) : ?>
                <?php foreach ($features as $item) : ?>
                    <div class="mlt-feature">
                        <h3><?php echo esc_html($item['title']); ?></h3>
                        <p><?php echo esc_html($item['content']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php elseif (function_exists('have_rows') && have_rows('mlt_features')) :
                while (have_rows('mlt_features')) : the_row();
                    $title = get_sub_field('title');
                    $text = get_sub_field('text');
                    ?>
                    <div class="mlt-feature">
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($text); ?></p>
                    </div>
                    <?php
                endwhile;
            else :
                // fallback dental-specific features
                $default_features = array(
                    array('title' => 'Expert Dentists', 'desc' => 'Our experienced team of qualified dentists provides best-in-class dental care.'),
                    array('title' => 'Modern Technology', 'desc' => 'State-of-the-art equipment ensures accurate diagnostics and painless treatments.'),
                    array('title' => 'Patient Comfort', 'desc' => 'We create a relaxing environment to ease dental anxiety and ensure comfort.'),
                );
                foreach ($default_features as $feature) :
                ?>
                <div class="mlt-feature">
                    <h3><?php echo esc_html($feature['title']); ?></h3>
                    <p><?php echo esc_html($feature['desc']); ?></p>
                </div>
                <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>

