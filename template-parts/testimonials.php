<section class="mlt-testimonials" id="testimonials">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option') ? mlt_get_option('mlt_testimonials_section_title', 'What Our Patients Say') : 'What Our Patients Say';
            $testimonials = function_exists('mlt_get_testimonials') ? mlt_get_testimonials() : array();
        ?>
        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>
        <div class="mlt-testimonial-list">
            <?php if (!empty($testimonials)) : ?>
                <?php foreach ($testimonials as $t) : ?>
                    <blockquote class="mlt-testimonial">
                        <?php echo esc_html($t['content']); ?>
                        <?php if (!empty($t['author'])) : ?><cite>— <?php echo esc_html($t['author']); ?></cite><?php endif; ?>
                    </blockquote>
                <?php endforeach; ?>
            <?php else : ?>
                <blockquote class="mlt-testimonial">"Excellent dental care! Dr. Smith was very professional and friendly. I recommend this clinic to everyone."<cite>— Sarah M.</cite></blockquote>
                <blockquote class="mlt-testimonial">"Amazing experience from start to finish. The staff is welcoming and the facilities are very clean."<cite>— John P.</cite></blockquote>
                <blockquote class="mlt-testimonial">"My teeth have never looked better! The teeth whitening treatment was fantastic and painless."<cite>— Maria R.</cite></blockquote>
                <blockquote class="mlt-testimonial">"I was nervous about my root canal, but the team made me feel comfortable. Highly recommended!"<cite>— David L.</cite></blockquote>
            <?php endif; ?>
        </div>
    </div>
</section>
