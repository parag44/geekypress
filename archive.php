<?php
/**
 * The template for displaying archive pages
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main terminal-main" role="main">
	<div class="wp-block-group alignwide terminal-section" style="max-width: 860px; margin-inline: auto; padding-top: 40px;">
		<header class="page-header terminal-panel" style="padding: 32px; margin-bottom: 32px; border-left: 3px solid var(--pt-green);">
			<p class="terminal-label" style="margin-bottom: 8px;">// ARCHIVE DIRECTORY</p>
			<?php
			the_archive_title( '<h1 class="terminal-display" style="font-size: var(--heading-md); margin: 0 0 12px 0;">', '<span>_</span></h1>' );
			the_archive_description( '<div class="archive-description content-text" style="color: var(--pt-muted); font-size: var(--text-sm);">', '</div>' );
			?>
		</header>

		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'terminal-panel' ); ?> style="padding: 28px; margin-bottom: 24px;">
					<header class="entry-header">
						<p class="terminal-label" style="margin-bottom: 6px;">// <?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?></p>
						<?php the_title( '<h2 class="section-title" style="margin: 0 0 10px 0;"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" style="color:var(--pt-text); text-decoration:none;">', '</a></h2>' ); ?>
					</header>
					<div class="entry-summary content-text" style="margin-top: 12px; color: var(--pt-muted);">
						<?php the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>

			<?php
			the_posts_pagination(
				array(
					'prev_text' => '&larr; ' . esc_html__( 'Previous', 'geekypress' ),
					'next_text' => esc_html__( 'Next', 'geekypress' ) . ' &rarr;',
				)
			);
			?>
		<?php else : ?>
			<div class="terminal-empty-state terminal-panel" style="padding: 48px; text-align: center;">
				<p class="terminal-label">// 404_EMPTY</p>
				<h2 class="terminal-display" style="font-size: var(--heading-sm);"><?php esc_html_e( 'No entries found in this archive.', 'geekypress' ); ?></h2>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
