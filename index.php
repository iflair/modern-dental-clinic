<?php
get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		?>
		<main id="primary" class="mlt-main">
			<div class="mlt-container">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<?php
							printf(
								esc_html__('By %s on %s', 'modern-dental-clinic'),
								'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>',
								'<span class="posted-on"><time class="entry-date published" datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time></span>'
							);
							?>
						</div>
					</header>

					<?php
					if (has_post_thumbnail()) {
						?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail('large'); ?>
						</div>
						<?php
					}
					?>

					<div class="entry-content">
						<?php
						the_content();
						
						// Page/Post pagination
						wp_link_pages(array(
							'before'      => '<div class="page-links">' . esc_html__('Pages:', 'modern-dental-clinic'),
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						));
						?>
					</div>

					<footer class="entry-footer">
						<?php
						// Tags
						if (has_tag()) {
							echo '<div class="tags-list">';
							echo esc_html__('Tags: ', 'modern-dental-clinic');
							the_tags('', ', ', '');
							echo '</div>';
						}

						// Categories
						if (has_category()) {
							echo '<div class="categories-list">';
							echo esc_html__('Categories: ', 'modern-dental-clinic');
							the_category(', ');
							echo '</div>';
						}
						?>
					</footer>
				</article>

				<?php
				// Comments
				if (comments_open() || get_comments_number()) {
					comments_template();
				}
				?>
			</div>
		</main>
		<?php
	}
} else {
	?>
	<main id="primary" class="mlt-main">
		<div class="mlt-container">
			<article class="no-posts">
				<h1><?php esc_html_e('Nothing Found', 'modern-dental-clinic'); ?></h1>
				<p><?php esc_html_e('Sorry, but nothing matched your search. Please try again with some different keywords.', 'modern-dental-clinic'); ?></p>
				<?php get_search_form(); ?>
			</article>
		</div>
	</main>
	<?php
}

// Post pagination
if (function_exists('the_posts_pagination')) {
	the_posts_pagination(array(
		'prev_text' => esc_html__('Previous', 'modern-dental-clinic'),
		'next_text' => esc_html__('Next', 'modern-dental-clinic'),
		'before_markup' => '<nav class="navigation posts-navigation"><div class="nav-links">',
		'after_markup'  => '</div></nav>',
	));
}

get_footer();
?>