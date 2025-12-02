<?php
get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		?>
		<main id="primary" class="mlt-main mlt-single-post">
			<div class="mlt-container">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta">
							<?php
							printf(
								esc_html__('By %s on %s', 'dental-care'),
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
						
						// Page pagination
						wp_link_pages(array(
							'before'      => '<div class="page-links">' . esc_html__('Pages:', 'dental-care'),
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
							echo esc_html__('Tags: ', 'dental-care');
							the_tags('', ', ', '');
							echo '</div>';
						}

						// Categories
						if (has_category()) {
							echo '<div class="categories-list">';
							echo esc_html__('Categories: ', 'dental-care');
							the_category(', ');
							echo '</div>';
						}
						?>
					</footer>
				</article>

				<?php
				// Post navigation
				the_post_navigation(array(
					'prev_text' => esc_html__('Previous: %title', 'dental-care'),
					'next_text' => esc_html__('Next: %title', 'dental-care'),
				));

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
				<h1><?php esc_html_e('Post Not Found', 'dental-care'); ?></h1>
				<p><?php esc_html_e('Sorry, we couldn\'t find the post you were looking for.', 'dental-care'); ?></p>
			</article>
		</div>
	</main>
	<?php
}

get_footer();
?>
