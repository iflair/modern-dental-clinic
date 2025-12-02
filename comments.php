<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
	exit;
}

// Comments list
if (have_comments()) {
	?>
	<section id="comments" class="comments-area">
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if (1 === $comment_count) {
				esc_html_e('One Comment', 'dental-care');
			} else {
				printf(
					esc_html(_n('%s Comment', '%s Comments', $comment_count, 'dental-care')),
					$comment_count
				);
			}
			?>
		</h2>

		<?php
		// Comments list with get_avatar support
		wp_list_comments(array(
			'style'       => 'div',
			'short_ping'  => true,
			'avatar_size' => 60,
			'callback'    => function($comment, $args, $depth) {
				?>
				<div id="div-comment-<?php comment_ID(); ?>" <?php comment_class('comment-item', $comment, null, $depth); ?>>
					<article id="comment-<?php comment_ID(); ?>" class="comment-body">
						<footer class="comment-meta">
							<div class="comment-author vcard">
								<?php
								// Display avatar
								echo get_avatar($comment, $args['avatar_size'], '', '', array('class' => 'avatar'));
								?>
								<b class="fn"><?php comment_author_link($comment); ?></b>
								<span class="says"><?php esc_html_e('says:', 'dental-care'); ?></span>
							</div>
							<div class="comment-metadata">
								<a href="<?php echo esc_url(get_comment_link($comment, array('type' => 'all'))); ?>">
									<time datetime="<?php comment_time('c'); ?>">
										<?php comment_date(get_option('date_format')); ?>
									</time>
								</a>
								<?php
								edit_comment_link(__('Edit', 'dental-care'), '<span class="edit-link">', '</span>');
								?>
							</div>
						</footer>

						<div class="comment-content">
							<?php comment_text(); ?>
						</div>

						<div class="reply">
							<?php
							comment_reply_link(array_merge($args, array(
								'add_below' => 'div-comment',
								'depth'     => $depth,
								'max_depth' => $args['max_depth'],
							)));
							?>
						</div>
					</article>
				</div>
				<?php
			},
		));

		// Comment pagination
		if (get_comment_pages_count() > 1 && get_option('page_comments')) {
			?>
			<nav id="comment-nav-above" class="comment-navigation" role="navigation">
				<h1 class="screen-reader-text"><?php esc_html_e('Comment navigation', 'dental-care'); ?></h1>
				<div class="nav-previous"><?php previous_comments_link(__('← Older Comments', 'dental-care')); ?></div>
				<div class="nav-next"><?php next_comments_link(__('Newer Comments →', 'dental-care')); ?></div>
			</nav>
			<?php
		}
		?>
	</section>
	<?php
}

// Comment form
if (comments_open()) {
	comment_form(array(
		'title_reply'         => __('Leave a Comment', 'dental-care'),
		'title_reply_before'  => '<h2 id="reply-title" class="comment-reply-title">',
		'title_reply_after'   => '</h2>',
		'comment_field'       => '<p class="comment-form-comment"><label for="comment">' . esc_html__('Comment', 'dental-care') . '</label><textarea id="comment" name="comment" cols="45" rows="8" maxlength="65525" required></textarea></p>',
		'fields'              => array(
			'author' => '<p class="comment-form-author"><label for="author">' . esc_html__('Name', 'dental-care') . ' <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author'] ?? '') . '" size="30" maxlength="245" ' . ($req ? 'required' : '') . ' /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'dental-care') . ' <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email'] ?? '') . '" size="30" maxlength="100" aria-describedby="email-notes" ' . ($req ? 'required' : '') . ' /></p>',
			'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__('Website', 'dental-care') . '</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url'] ?? '') . '" size="30" maxlength="200" /></p>',
		),
		'class_submit' => 'submit',
		'submit_button' => '<button name="%1$s" type="submit" id="%2$s" class="%3$s wp-element-button">%4$s</button>',
	));
} else {
	?>
	<p class="no-comments-allowed"><?php esc_html_e('Comments are closed.', 'dental-care'); ?></p>
	<?php
}
?>
