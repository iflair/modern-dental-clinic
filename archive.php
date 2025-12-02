<?php
get_header();
?>

<main id="primary" class="mlt-main mlt-archive">
	<div class="mlt-container">
		<header class="archive-header">
			<?php
			if (is_category()) {
				echo '<h1 class="archive-title">' . single_cat_title('', false) . '</h1>';
				echo category_description();
			} elseif (is_tag()) {
				echo '<h1 class="archive-title">' . esc_html__('Tag: ', 'modern-dental-clinic') . single_tag_title('', false) . '</h1>';
				echo tag_description();
			} elseif (is_author()) {
				$author_id = get_the_author_meta('ID');
				echo '<h1 class="archive-title">' . esc_html__('Author: ', 'modern-dental-clinic') . get_the_author() . '</h1>';
				echo '<div class="author-bio">' . get_the_author_meta('description') . '</div>';
			} elseif (is_date()) {
				if (is_day()) {
					echo '<h1 class="archive-title">' . esc_html__('Archives: ', 'modern-dental-clinic') . get_the_date() . '</h1>';
				} elseif (is_month()) {
					echo '<h1 class="archive-title">' . esc_html__('Archives: ', 'modern-dental-clinic') . get_the_date('F Y') . '</h1>';
				} elseif (is_year()) {
					echo '<h1 class="archive-title">' . esc_html__('Archives: ', 'modern-dental-clinic') . get_the_date('Y') . '</h1>';
				}
			} elseif (is_search()) {
				echo '<h1 class="archive-title">' . sprintf(esc_html__('Search Results for: %s', 'modern-dental-clinic'), '<span>' . get_search_query() . '</span>') . '</h1>';
			} else {
				the_archive_title('<h1 class="archive-title">', '</h1>');
				the_archive_description('<div class="archive-description">', '</div>');
			}
			?>
		</header>

		<?php
		if (have_posts()) {
			echo '<div class="posts-grid">';
			while (have_posts()) {
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class('archive-item'); ?>>
					<div class="archive-item-content">
						<?php
						if (has_post_thumbnail()) {
							echo '<div class="archive-thumbnail">';
							the_post_thumbnail('medium', array('alt' => get_the_title()));
							echo '</div>';
						}
						?>
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
						// Display tags
						if (has_tag()) {
							echo '<div class="tags-list">';
							the_tags('', ', ', '');
							echo '</div>';
						}
						?>
						<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Read More', 'modern-dental-clinic'); ?></a>
					</div>
				</article>
				<?php
			}
			echo '</div>';

			// Archive post pagination
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
				<p><?php esc_html_e('No posts found in this archive.', 'modern-dental-clinic'); ?></p>
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
