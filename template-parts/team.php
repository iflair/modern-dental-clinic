<section class="mlt-team" id="team">
    <div class="mlt-container">
        <?php
            $section_title = function_exists('mlt_get_option') ? mlt_get_option('mlt_team_section_title', 'Meet Our Dental Team') : 'Meet Our Dental Team';
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
                            // If image is a relative path, convert to absolute using theme directory
                            if ($raw_img !== '' && strpos($raw_img, 'http') !== 0 && strpos($raw_img, '//') !== 0) {
                                $raw_img = get_stylesheet_directory_uri() . '/' . ltrim($raw_img, '/');
                            }
                        ?>
                            <div class="mlt-team-image">
                                <img src="<?php echo esc_url($raw_img); ?>" alt="<?php echo esc_attr($member['name']); ?>">
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
                                    if (empty($url)) continue;

                                    // determine key/provider from key or url
                                    $provider = '';
                                    $key_s = sanitize_key((string) $key);
                                    if ($key_s !== '' && !is_numeric($key_s)) {
                                        $provider = $key_s;
                                    } else {
                                        $host = parse_url($url, PHP_URL_HOST) ?: '';
                                        $host = strtolower($host);
                                        if (strpos($host, 'facebook.com') !== false || strpos($host, 'fb.me') !== false) $provider = 'facebook';
                                        elseif (strpos($host, 'twitter.com') !== false || strpos($host, 't.co') !== false) $provider = 'twitter';
                                        elseif (strpos($host, 'instagram.com') !== false) $provider = 'instagram';
                                        elseif (strpos($host, 'linkedin.com') !== false) $provider = 'linkedin';
                                        elseif (strpos($host, 'youtube.com') !== false || strpos($host, 'youtu.be') !== false) $provider = 'youtube';
                                        else $provider = 'website';
                                    }

                                    $icon_class = 'fas fa-link';
                                    switch ($provider) {
                                        case 'facebook': $icon_class = 'fab fa-facebook-f'; break;
                                        case 'twitter': $icon_class = 'fab fa-twitter'; break;
                                        case 'instagram': $icon_class = 'fab fa-instagram'; break;
                                        case 'linkedin': $icon_class = 'fab fa-linkedin-in'; break;
                                        case 'youtube': $icon_class = 'fab fa-youtube'; break;
                                        default: $icon_class = 'fas fa-link'; break;
                                    }
                                ?>
                                    <a class="mlt-team-social" href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer"><i class="<?php echo esc_attr($icon_class); ?>" aria-hidden="true"></i></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php elseif (function_exists('have_rows') && have_rows('mlt_doctors')) :
                while (have_rows('mlt_doctors')) : the_row();
                    $name = get_sub_field('name');
                    $title = get_sub_field('title');
                    $image = get_sub_field('image');
                    $bio = get_sub_field('bio');
                    ?>
                    <div class="mlt-team-member">
                        <?php if ($image) : ?>
                            <div class="mlt-team-image">
                                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($name); ?>">
                            </div>
                        <?php endif; ?>
                        <h3><?php echo esc_html($name); ?></h3>
                        <p class="mlt-member-title"><?php echo esc_html($title); ?></p>
                        <?php if ($bio) : ?>
                            <p><?php echo wp_kses_post($bio); ?></p>
                        <?php endif; ?>
                    </div>
                    <?php
                endwhile;
            else :
                // Fallback team members
                $default_team = array(
                    array('name' => 'Dr. Smith', 'title' => 'BDS, General Dentist', 'bio' => '15+ years of experience in general dentistry.'),
                    array('name' => 'Dr. Johnson', 'title' => 'MDS, Orthodontist', 'bio' => 'Specializing in cosmetic and corrective orthodontics.'),
                    array('name' => 'Dr. Williams', 'title' => 'BDS, Dental Hygienist', 'bio' => 'Dedicated to preventive care and patient education.'),
                );
                foreach ($default_team as $member) :
                    ?>
                    <div class="mlt-team-member">
                        <h3><?php echo esc_html($member['name']); ?></h3>
                        <p class="mlt-member-title"><?php echo esc_html($member['title']); ?></p>
                        <p><?php echo esc_html($member['bio']); ?></p>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>
</section>
