<section class="mlt-pricing" id="pricing">
    <div class="mlt-container">
        <?php
            $section_title    = function_exists('mlt_get_option') ? mlt_get_option('mlt_pricing_section_title', __('Our Pricing Plans', 'modern-dental-clinic')) : __('Our Pricing Plans', 'modern-dental-clinic');
            $section_subtitle = function_exists('mlt_get_option') ? mlt_get_option('mlt_pricing_section_subtitle', __('Affordable dental care for the whole family', 'modern-dental-clinic')) : __('Affordable dental care for the whole family', 'modern-dental-clinic');
            $pricing_plans    = function_exists('mlt_get_pricing') ? mlt_get_pricing() : array();
        ?>

        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>

        <?php if (!empty($section_subtitle)) : ?>
            <p class="mlt-section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
        <?php endif; ?>

        <div class="mlt-pricing-grid">
            <?php if (!empty($pricing_plans)) : ?>

                <?php foreach ($pricing_plans as $plan) : ?>
                    <?php
                        $is_popular = !empty($plan['popular']);
                        $plan_name  = isset($plan['name']) ? esc_html($plan['name']) : '';
                        $description = isset($plan['description']) ? esc_html($plan['description']) : '';
                        $price      = isset($plan['price']) ? esc_html($plan['price']) : '';
                        $period     = isset($plan['period']) ? esc_html($plan['period']) : '';
                        $cta_text   = isset($plan['cta_text']) ? esc_html($plan['cta_text']) : '';
                    ?>
                    <div class="mlt-plan <?php echo $is_popular ? 'popular' : ''; ?>">

                        <?php if ($is_popular) : ?>
                            <div class="mlt-plan-badge">
                                <?php _e('Most Popular', 'modern-dental-clinic'); ?>
                            </div>
                        <?php endif; ?>

                        <h3><?php echo $plan_name; ?></h3>

                        <?php if (!empty($description)) : ?>
                            <p class="mlt-plan-description"><?php echo $description; ?></p>
                        <?php endif; ?>

                        <div class="mlt-price-container">
                            <div class="mlt-price"><?php echo $price; ?></div>
                            <?php if (!empty($period)) : ?>
                                <div class="mlt-price-period"><?php echo $period; ?></div>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($plan['features'])) : ?>
                            <?php $features = array_map('trim', explode(',', $plan['features'])); ?>
                            <ul class="mlt-plan-features">
                                <?php foreach ($features as $feature) : ?>
                                    <?php if (!empty($feature)) : ?>
                                        <li>
                                            <i class="fas fa-check"></i>
                                            <?php echo esc_html($feature); ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <a class="mlt-btn <?php echo $is_popular ? 'mlt-btn-primary' : ''; ?>" 
                           href="#contact">
                           <?php echo $cta_text; ?>
                        </a>

                    </div>
                <?php endforeach; ?>

            <?php else : ?>
                <!-- Fallback pricing plans -->
                <div class="mlt-plan">
                    <h3><?php _e('Basic', 'modern-dental-clinic'); ?></h3>
                    <p class="mlt-plan-description"><?php _e('Essential dental care', 'modern-dental-clinic'); ?></p>

                    <div class="mlt-price-container">
                        <div class="mlt-price"><?php _e('Free', 'modern-dental-clinic'); ?></div>
                        <div class="mlt-price-period"><?php _e('Always', 'modern-dental-clinic'); ?></div>
                    </div>

                    <ul class="mlt-plan-features">
                        <li><i class="fas fa-check"></i> <?php _e('Initial consultation', 'modern-dental-clinic'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Basic examination', 'modern-dental-clinic'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Oral health tips', 'modern-dental-clinic'); ?></li>
                    </ul>

                    <a class="mlt-btn" href="#contact">
                        <?php _e('Get Started', 'modern-dental-clinic'); ?>
                    </a>
                </div>

                <div class="mlt-plan popular">
                    <div class="mlt-plan-badge"><?php _e('Most Popular', 'modern-dental-clinic'); ?></div>
                    <h3><?php _e('Pro', 'modern-dental-clinic'); ?></h3>
                    <p class="mlt-plan-description"><?php _e('Comprehensive care', 'modern-dental-clinic'); ?></p>

                    <div class="mlt-price-container">
                        <div class="mlt-price">$499</div>
                        <div class="mlt-price-period"><?php _e('Per Visit', 'modern-dental-clinic'); ?></div>
                    </div>

                    <ul class="mlt-plan-features">
                        <li><i class="fas fa-check"></i> <?php _e('Everything in Basic', 'modern-dental-clinic'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Professional cleaning', 'modern-dental-clinic'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Advanced procedures', 'modern-dental-clinic'); ?></li>
                        <li><i class="fas fa-check"></i> <?php _e('Priority scheduling', 'modern-dental-clinic'); ?></li>
                    </ul>

                    <a class="mlt-btn mlt-btn-primary" href="#contact">
                        <?php _e('Choose Plan', 'modern-dental-clinic'); ?>
                    </a>
                </div>

            <?php endif; ?>
        </div>
    </div>
</section>
