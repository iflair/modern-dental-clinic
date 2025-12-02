<section class="mlt-pricing" id="pricing">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option') ? mlt_get_option('mlt_pricing_section_title', 'Our Pricing Plans') : 'Our Pricing Plans';
            $section_subtitle = function_exists('mlt_get_option') ? mlt_get_option('mlt_pricing_section_subtitle', 'Affordable dental care for the whole family') : 'Affordable dental care for the whole family';
            $pricing_plans = function_exists('mlt_get_pricing') ? mlt_get_pricing() : array();
        ?>
        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>
        <?php if (!empty($section_subtitle)) : ?>
            <p class="mlt-section-subtitle"><?php echo esc_html($section_subtitle); ?></p>
        <?php endif; ?>
        <div class="mlt-pricing-grid">
            <?php if (!empty($pricing_plans)) : ?>
                <?php foreach ($pricing_plans as $plan) : ?>
                    <div class="mlt-plan <?php echo $plan['popular'] ? 'popular' : ''; ?>">
                        <?php if ($plan['popular']) : ?>
                            <div class="mlt-plan-badge">Most Popular</div>
                        <?php endif; ?>
                        <h3><?php echo esc_html($plan['name']); ?></h3>
                        <?php if (!empty($plan['description'])) : ?>
                            <p class="mlt-plan-description"><?php echo esc_html($plan['description']); ?></p>
                        <?php endif; ?>
                        <div class="mlt-price-container">
                            <div class="mlt-price"><?php echo esc_html($plan['price']); ?></div>
                            <?php if (!empty($plan['period'])) : ?>
                                <div class="mlt-price-period"><?php echo esc_html($plan['period']); ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($plan['features'])) : ?>
                            <ul class="mlt-plan-features">
                                <?php $features = array_map('trim', explode(',', $plan['features'])); ?>
                                <?php foreach ($features as $feature) : ?>
                                    <?php if (!empty($feature)) : ?>
                                        <li><i class="fas fa-check"></i> <?php echo esc_html($feature); ?></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <a class="mlt-btn <?php echo $plan['popular'] ? 'mlt-btn-primary' : ''; ?>" href="#contact"><?php echo esc_html($plan['cta_text']); ?></a>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Fallback pricing plans -->
                <div class="mlt-plan">
                    <h3>Basic</h3>
                    <p class="mlt-plan-description">Essential dental care</p>
                    <div class="mlt-price-container">
                        <div class="mlt-price">Free</div>
                        <div class="mlt-price-period">Always</div>
                    </div>
                    <ul class="mlt-plan-features">
                        <li><i class="fas fa-check"></i> Initial consultation</li>
                        <li><i class="fas fa-check"></i> Basic examination</li>
                        <li><i class="fas fa-check"></i> Oral health tips</li>
                    </ul>
                    <a class="mlt-btn" href="#contact">Get Started</a>
                </div>
                <div class="mlt-plan popular">
                    <div class="mlt-plan-badge">Most Popular</div>
                    <h3>Pro</h3>
                    <p class="mlt-plan-description">Comprehensive care</p>
                    <div class="mlt-price-container">
                        <div class="mlt-price">$499</div>
                        <div class="mlt-price-period">Per Visit</div>
                    </div>
                    <ul class="mlt-plan-features">
                        <li><i class="fas fa-check"></i> Everything in Basic</li>
                        <li><i class="fas fa-check"></i> Professional cleaning</li>
                        <li><i class="fas fa-check"></i> Advanced procedures</li>
                        <li><i class="fas fa-check"></i> Priority scheduling</li>
                    </ul>
                    <a class="mlt-btn mlt-btn-primary" href="#contact">Choose Plan</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>