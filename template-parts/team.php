<section class="mlt-team" id="team">
    <div class="mlt-container">

        <?php
        $section_title = function_exists('mlt_get_option')
            ? mlt_get_option('mlt_team_section_title', __('Meet Our Dental Team', 'modern-dental-clinic'))
            : __('Meet Our Dental Team', 'modern-dental-clinic');

        $team = function_exists('mlt_get_team') ? mlt_get_team() : array();
        ?>

        <h2 class="mlt-section-title"><?php echo esc_html($section_title); ?></h2>

        <div class="mlt-team-grid">

            <?php if (!empty($team)) : ?>

                <?php foreach ($team as $member) : ?>
                    <div class="mlt-team-member">

                        <?php if (!empty($member['image'])) :
                            // Normalize potential escaped slashes and ensure a usable URL
                            $raw_img = is_string($member['image']) ? $member['image'] : '';
                            $raw_img = str_replace('\\/', '/', $raw_img);
                            $raw_img = trim($raw_img);

                            // Convert relative path to absolute URI
                            if ($raw_img !== '' && strpos($raw_img, 'http') !== 0 && strpos($raw_img, '//') !== 0) {
                                $raw_img = get_stylesheet_directory_uri() . '/' . ltrim($raw_img, '/');
                            }
                        ?>
                            <div class="mlt-team-image">
                                <img src="<?php echo esc_url($raw_img); ?>"
                                     alt="<?php echo esc_attr($member['name']); ?>">
                            </div>
                        <?php endif; ?>

                        <h3><?php echo esc_html($member['name']); ?></h3>

                        <?php if (!empty($member['role'])) : ?>
                            <p class="mlt-member-title"><?php echo esc_html($member['role']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($member['bio'])) : ?>
                            <p><?php echo esc_html($member['bio']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($member['socials']) && is_array($member['socials'])) : ?>
                            <div class="mlt-team-socials">
                                <?php foreach ($member['socials'] as $key => $url) :

                                    $url = is_string($url) ? $url : '';
                                    $url = str_replace('\\/', '/', $url);
                                    $url = esc_url($url);

                                    if (empty($url)) {
                                        continue;
                                    }

                                    // Determine provider
                                    $provider = '';
                                    $key_s = sanitize_key((string)$key);

                                    if ($key_s !== '' && !is_numeric($key_s)) {
                                        $provider = $key_s;
                                    } else {
                                        $host = strtolower(parse_url($url, PHP_URL_HOST) ?: '');

                                        if (strpos($host, 'facebook.com') !== false || strpos($host, 'fb.me') !== false) { $provider = 'facebook'; }
                                        elseif (strpos($host, 'twitter.com') !== false || strpos($host, 't.co') !== false) { $provider = 'twitter'; }
                                        elseif (strpos($host, 'instagram.com') !== false) { $provider = 'instagram'; }
                                        elseif (strpos($host, 'linkedin.com') !== false) { $provider = 'linkedin'; }
                                        elseif (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) { $provider = 'youtube'; }
                                        else { $provider = 'website'; }
                                    }

                                    // Icon class
                                    switch ($provider) {
                                        case 'facebook':  $icon = 'fab fa-facebook-f'; break;
                                        case 'twitter':   $icon = 'fab fa-twitter'; break;
                                        case 'instagram': $icon = 'fab fa-instagram'; break;
                                        case 'linkedin':  $icon = 'fab fa-linkedin-in'; break;
                                        case 'youtube':   $icon = 'fab fa-youtube'; break;
                                        default:          $icon = 'fas fa-link';
                                    }
                                ?>

                                    <a class="mlt-team-social"
                                       href="<?php echo esc_url($url); ?>"
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        <i class="<?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
                                    </a>

                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                <?php endforeach; ?>

            <?php elseif (function_exists('have_rows') && have_rows('mlt_doctors')) : ?>

                <?php while (have_rows('mlt_doctors')) : the_row();
                    $name  = get_sub_field('name');
                    $title = get_sub_field('title');
                    $image = get_sub_field('image');
                    $bio   = get_sub_field('bio');
                ?>
                    <div class="mlt-team-member">

                        <?php if (!empty($image)) : ?>
                            <div class="mlt-team-image">
                                <img src="<?php echo esc_url($image['url']); ?>"
                                     alt="<?php echo esc_attr($name); ?>">
                            </div>
                        <?php endif; ?>

                        <h3><?php echo esc_html($name); ?></h3>

                        <p class="mlt-member-title"><?php echo esc_html($title); ?></p>

                        <?php if (!empty($bio)) : ?>
                            <p><?php echo wp_kses_post($bio); ?></p>
                        <?php endif; ?>

                    </div>
                <?php endwhile; ?>

            <?php else : ?>

                <?php
                // Fallback team members
                $default_team = array(
                    array(
                        'name'  => __('Dr. Smith', 'modern-dental-clinic'),
                        'title' => __('BDS, General Dentist', 'modern-dental-clinic'),
                        'bio'   => __('15+ years of experience in general dentistry.', 'modern-dental-clinic')
                    ),
                    array(
                        'name'  => __('Dr. Johnson', 'modern-dental-clinic'),
                        'title' => __('MDS, Orthodontist', 'modern-dental-clinic'),
                        'bio'   => __('Specializing in cosmetic and corrective orthodontics.', 'modern-dental-clinic')
                    ),
                    array(
                        'name'  => __('Dr. Williams', 'modern-dental-clinic'),
                        'title' => __('BDS, Dental Hygienist', 'modern-dental-clinic'),
                        'bio'   => __('Dedicated to preventive care and patient education.', 'modern-dental-clinic')
                    ),
                );
                ?>

                <?php foreach ($default_team as $member) : ?>
                    <div class="mlt-team-member">
                        <h3><?php echo esc_html($member['name']); ?></h3>
                        <p class="mlt-member-title"><?php echo esc_html($member['title']); ?></p>
                        <p><?php echo esc_html($member['bio']); ?></p>
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>
    </div>
</section>
