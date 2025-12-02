<footer class="mlt-footer">
    <div class="mlt-container">
        <div class="mlt-footer-content">
            <div class="mlt-footer-info">
                <?php 
                $clinic_name = mlt_get_option('mlt_clinic_name', get_bloginfo('name'));
                $clinic_address = mlt_get_option('mlt_clinic_address', '');
                $clinic_phone = mlt_get_option('mlt_clinic_phone', '');
                $clinic_email = mlt_get_option('mlt_clinic_email', get_option('admin_email'));
                ?>
                <h3><?php echo esc_html($clinic_name); ?></h3>
                <?php if (!empty($clinic_address)) : ?>
                    <p><?php echo esc_html($clinic_address); ?></p>
                <?php endif; ?>
                <?php if (!empty($clinic_phone)) : ?>
                    <p><strong>Phone:</strong> <a href="tel:<?php echo esc_attr(preg_replace('/\D/', '', $clinic_phone)); ?>"><?php echo esc_html($clinic_phone); ?></a></p>
                <?php endif; ?>
                <?php if (!empty($clinic_email)) : ?>
                    <p><strong>Email:</strong> <a href="mailto:<?php echo esc_attr($clinic_email); ?>"><?php echo esc_html($clinic_email); ?></a></p>
                <?php endif; ?>
            </div>

            <div class="mlt-footer-socials">
                <?php 
                $socials = array('facebook', 'twitter', 'instagram', 'youtube', 'linkedin');
                $has_socials = false;
                foreach ($socials as $social) {
                    $url = mlt_get_option('mlt_social_' . $social, '');
                    if (!empty($url)) {
                        $has_socials = true;
                        break;
                    }
                }
                if ($has_socials) : ?>
                    <h4><?php _e('Follow Us', 'modern-dental-clinic'); ?></h4>
                    <div class="mlt-social-links">
                        <?php foreach ($socials as $social) : 
                            $url = mlt_get_option('mlt_social_' . $social, '');
                            if (!empty($url)) : ?>
                                <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" title="<?php echo esc_attr(ucfirst($social)); ?>">
                                    <i class="fab fa-<?php echo esc_attr($social); ?>"></i>
                                </a>
                            <?php endif; 
                        endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="mlt-footer-bottom">
            <p>© <?php echo date('Y'); ?> <?php echo esc_html($clinic_name); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
