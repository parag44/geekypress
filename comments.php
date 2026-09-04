<?php
/**
 * The template for displaying comments
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area terminal-post-comments terminal-panel">

	<!-- Comments Titlebar -->
	<div class="terminal-window-bar terminal-comments-window-bar" aria-hidden="true">
		<div class="terminal-window-dots">
			<i></i><i></i><i></i>
		</div>
		<div class="terminal-window-file">
			<span>~/logs/comments.log</span>
		</div>
	</div>

	<div class="terminal-comments-body">
		<?php if ( have_comments() ) : ?>
			<h2 class="comments-title section-title">
				// <?php
				$geekypress_comment_count = get_comments_number();
				if ( '1' === $geekypress_comment_count ) {
					printf(
						/* translators: 1: title. */
						esc_html__( '01_comment on &ldquo;%1$s&rdquo;', 'geekypress' ),
						'<span>' . wp_kses_post( get_the_title() ) . '</span>'
					);
				} else {
					printf(
						/* translators: 1: comment count number, 2: title. */
						esc_html( _nx( '%1$s_comment on &ldquo;%2$s&rdquo;', '%1$s_comments on &ldquo;%2$s&rdquo;', $geekypress_comment_count, 'comments title', 'geekypress' ) ),
						esc_html( sprintf( '%02d', $geekypress_comment_count ) ),
						'<span>' . wp_kses_post( get_the_title() ) . '</span>'
					);
				}
				?>
			</h2>

			<?php the_comments_navigation(); ?>

			<ol class="comment-list">
				<?php
				wp_list_comments(
					array(
						'style'       => 'ol',
						'short_ping'  => true,
						'avatar_size' => 44,
					)
				);
				?>
			</ol>

			<?php
			the_comments_navigation();

			if ( ! comments_open() ) :
				?>
				<p class="no-comments">
					<?php esc_html_e( '// Comments are closed for this entry.', 'geekypress' ); ?>
				</p>
				<?php
			endif;

		endif;

		comment_form(
			array(
				'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title section-title">// ',
				'title_reply_after'    => '</h3>',
				'class_submit'         => 'terminal-comment-submit-btn wp-element-button',
				'label_submit'         => __( '$ submit_comment()', 'geekypress' ),
				'comment_notes_before' => '<p class="comment-notes">// ' . esc_html__( 'Your email address will not be published. Required fields are marked *', 'geekypress' ) . '</p>',
			)
		);
		?>
	</div>

</div><!-- #comments -->
