<?php
/**
 * The template for displaying search results pages
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main terminal-main" role="main">
	<div class="wp-block-group alignwide terminal-section" style="max-width: 860px; margin-inline: auto; padding-top: 40px; padding-bottom: 60px;">

		<!-- Breadcrumb / Command Line Navigation -->
		<nav class="terminal-post-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'geekypress' ); ?>" style="margin-bottom: 24px;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="terminal-breadcrumb-link">
				<?php echo geekypress_get_icon( 'arrow-left', '', 14 ); ?>
				<span>$ cd .. / <?php esc_html_e( 'home', 'geekypress' ); ?></span>
			</a>
			<span class="terminal-breadcrumb-sep">/</span>
			<span class="terminal-breadcrumb-current"><?php esc_html_e( 'search', 'geekypress' ); ?></span>
		</nav>

		<header class="page-header terminal-panel" style="padding: clamp(24px, 4vw, 36px); margin-bottom: 32px; border-left: 3px solid var(--pt-cyan);">
			<p class="terminal-label" style="color: var(--pt-cyan); margin-bottom: 8px;">// SEARCH_RESULTS</p>
			<h1 class="terminal-display" style="font-size: var(--heading-md); margin: 0 0 16px 0;">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'query: "%s"', 'geekypress' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
				?><span>_</span>
			</h1>
			<div class="terminal-search-header-form" style="max-width: 480px; margin-top: 16px;">
				<?php get_search_form(); ?>
			</div>
		</header>

		<?php if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'terminal-panel' ); ?> style="padding: clamp(20px, 3vw, 28px); margin-bottom: 20px;">
					<header class="entry-header">
						<p class="terminal-label" style="margin-bottom: 6px;">// <?php echo esc_html( get_the_date( 'Y-m-d' ) ); ?></p>
						<?php the_title( '<h2 class="section-title" style="margin: 0 0 10px 0;"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" style="color:var(--pt-text); text-decoration:none;">', '</a></h2>' ); ?>
					</header>
					<div class="entry-summary content-text" style="margin-top: 12px; color: var(--pt-muted); line-height: 1.65;">
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
			<div class="terminal-empty-state terminal-panel" style="padding: 48px 32px; text-align: center;">
				<p class="terminal-label">// 0_RESULTS_FOUND</p>
				<h2 class="terminal-display" style="font-size: var(--heading-sm); margin-bottom: 16px;">
					<?php esc_html_e( 'No matching entries found', 'geekypress' ); ?><span>_</span>
				</h2>
				<p class="content-text" style="color: var(--pt-muted); margin-bottom: 24px;">
					<?php esc_html_e( 'Try refining your search keyword or return to the main dashboard.', 'geekypress' ); ?>
				</p>
				<div class="terminal-buttons" style="justify-content: center; display: flex; gap: 16px;">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wp-block-button__link" style="display: inline-block; padding: 10px 22px; background: var(--pt-surface); border: 1px solid var(--pt-green); color: var(--pt-green); font-family: var(--font-mono); text-decoration: none; border-radius: 2px;">
						&gt;_ <?php esc_html_e( 'Return Home', 'geekypress' ); ?>
					</a>
				</div>
			</div>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
