<?php
/**
 * The template for displaying all pages
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
					<?php the_title( '<h1 class="terminal-display" style="font-size: var(--heading-md); margin: 0;">', '<span>_</span></h1>' ); ?>
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
			</article>

			<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile;
		?>
	</div>
</main>

<?php
get_footer();
