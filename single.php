<?php
/**
 * The template for displaying all single posts
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
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'terminal-panel' ); ?> style="padding: clamp(24px, 5vw, 48px); margin-bottom: 32px;">
				<header class="entry-header" style="margin-bottom: 24px; border-bottom: 1px solid var(--pt-border-soft); padding-bottom: 20px;">
					<p class="terminal-label" style="margin-bottom: 8px;">// <?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?> · <?php the_author(); ?></p>
					<?php the_title( '<h1 class="terminal-display" style="font-size: var(--heading-md); margin: 0 0 12px 0;">', '<span>_</span></h1>' ); ?>
					<?php if ( has_category() ) : ?>
						<div class="terminal-post-categories" style="font-family: var(--font-mono); font-size: var(--text-xs); color: var(--pt-cyan);">
							<?php the_category( ' · ' ); ?>
						</div>
					<?php endif; ?>
				</header>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumbnail" style="margin-bottom: 28px; border: 1px solid var(--pt-border-soft); overflow: hidden; border-radius: 2px;">
						<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%; height:auto; display:block;' ) ); ?>
					</div>
				<?php endif; ?>

				<div class="entry-content content-text" style="line-height: 1.8; font-size: var(--text-base);">
					<?php
					the_content();

					wp_link_pages(
						array(
							'before' => '<div class="page-links" style="margin-top: 24px; font-family: var(--font-mono);">' . esc_html__( 'Pages:', 'geekypress' ),
							'after'  => '</div>',
						)
					);
					?>
				</div>

				<?php if ( has_tag() ) : ?>
					<footer class="entry-footer" style="margin-top: 32px; padding-top: 20px; border-top: 1px solid var(--pt-border-soft); font-family: var(--font-mono); font-size: var(--text-xs);">
						<span style="color: var(--pt-green);">&gt;_ tags:</span> <?php the_tags( '', ', ', '' ); ?>
					</footer>
				<?php endif; ?>
			</article>

			<?php
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle" style="font-family:var(--font-mono); font-size:var(--text-xs); color:var(--pt-muted);">&larr; ' . esc_html__( 'Previous', 'geekypress' ) . '</span> <span class="nav-title" style="display:block; font-weight:600;">%title</span>',
					'next_text' => '<span class="nav-subtitle" style="font-family:var(--font-mono); font-size:var(--text-xs); color:var(--pt-muted);">' . esc_html__( 'Next', 'geekypress' ) . ' &rarr;</span> <span class="nav-title" style="display:block; font-weight:600;">%title</span>',
				)
			);

			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
