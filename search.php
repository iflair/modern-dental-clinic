<?php
get_header();
?>

<main id="primary" class="mlt-main mlt-search">
	<div class="mlt-container">
		<header class="search-header">
			<h1 class="search-title">
				<?php printf(esc_html__('Search Results for: %s', 'modern-dental-clinic'), '<span>' . get_search_query() . '</span>'); ?>
			</h1>
		</header>

		<?php
		if (have_posts()) {
			echo '<div class="search-results">';
			while (have_posts()) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?>>
					<div class="result-content">
						<?php
						if (has_post_thumbnail()) {
							echo '<div class="result-thumbnail">';
							the_post_thumbnail('thumbnail', array('alt' => get_the_title()));
							echo '</div>';
						}
						?>
						<div class="result-text">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<div class="entry-meta">
								<?php
								printf(
									esc_html__('By %s on %s', 'modern-dental-clinic'),
									'<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>',
									'<span class="posted-on"><time class="entry-date published" datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time></span>'
								);
								?>
							</div>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div>
							<?php
							// Display tags for search results
							if (has_tag()) {
								echo '<div class="tags-list">';
								the_tags('', ', ', '');
								echo '</div>';
							}
							?>
							<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'modern-dental-clinic'); ?></a>
						</div>
					</div>
				</article>
				<?php
			}
			echo '</div>';

			// Search pagination
			the_posts_pagination(array(
				'prev_text' => esc_html__('Previous', 'modern-dental-clinic'),
				'next_text' => esc_html__('Next', 'modern-dental-clinic'),
				'before_markup' => '<nav class="navigation posts-navigation"><div class="nav-links">',
				'after_markup'  => '</div></nav>',
			));
		} else {
			?>
			<article class="no-posts">
				<h1><?php esc_html_e('Nothing Found', 'modern-dental-clinic'); ?></h1>
				<p><?php esc_html_e('Sorry, but nothing matched your search. Please try again with some different keywords.', 'modern-dental-clinic'); ?></p>
				<?php get_search_form(); ?>
			</article>
			<?php
		}
		?>
	</div>
</main>

<?php
get_footer();
?>
