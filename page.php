<?php
get_header();

if (have_posts()) {
	while (have_posts()) {
		the_post();
		?>
		<main id="primary" class="mlt-main mlt-page">
			<div class="mlt-container">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
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
							'before'      => '<div class="page-links">' . esc_html__('Pages:', 'modern-dental-clinic'),
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						));
						?>
					</div>
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
				<h1><?php esc_html_e('Page Not Found', 'modern-dental-clinic'); ?></h1>
				<p><?php esc_html_e('Sorry, we couldn\'t find the page you were looking for.', 'modern-dental-clinic'); ?></p>
			</article>
		</div>
	</main>
	<?php
}

get_footer();
?>
