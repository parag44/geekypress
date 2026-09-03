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

<div id="comments" class="comments-area terminal-panel" style="padding: clamp(24px, 5vw, 40px); margin-top: 32px;">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title section-title" style="font-size: var(--heading-sm); margin-bottom: 24px; border-bottom: 1px solid var(--pt-border-soft); padding-bottom: 12px;">
			// <?php
			$geekypress_comment_count = get_comments_number();
			if ( '1' === $geekypress_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'geekypress' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $geekypress_comment_count, 'comments title', 'geekypress' ) ),
					number_format_i18n( $geekypress_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list" style="list-style: none; padding: 0; margin: 0 0 24px 0;">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size'=> 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments" style="font-family: var(--font-mono); color: var(--pt-muted); font-size: var(--text-sm);">
				<?php esc_html_e( '// Comments are closed.', 'geekypress' ); ?>
			</p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form(
		array(
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title section-title" style="font-size:var(--heading-sm); margin-bottom:16px;">// ',
			'title_reply_after'  => '</h3>',
		)
	);
	?>

</div><!-- #comments -->
