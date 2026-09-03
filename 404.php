<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="primary" class="site-main terminal-main" role="main">
	<div class="wp-block-group alignwide terminal-section" style="max-width: 720px; margin-inline: auto; padding: 80px 24px; text-align: center;">
		<div class="terminal-panel" style="padding: 48px 32px; border: 1px solid var(--pt-border);">
			<p class="terminal-label" style="color: var(--pt-green); margin-bottom: 12px;">// ERROR_CODE: 404</p>
			<h1 class="terminal-display" style="font-size: var(--heading-md); margin-bottom: 16px;">
				<?php esc_html_e( 'Route Not Found', 'geekypress' ); ?><span>_</span>
			</h1>
			<p class="content-text" style="color: var(--pt-muted); margin-bottom: 28px;">
				<?php esc_html_e( 'The requested URL or resource does not exist in the current namespace.', 'geekypress' ); ?>
			</p>
			<div class="terminal-buttons" style="justify-content: center; display: flex; gap: 16px;">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="wp-block-button__link" style="display: inline-block; padding: 12px 24px; background: var(--pt-surface); border: 1px solid var(--pt-green); color: var(--pt-green); font-family: var(--font-mono); text-decoration: none; border-radius: 2px;">
					&gt;_ <?php esc_html_e( 'Return Home', 'geekypress' ); ?>
				</a>
			</div>
		</div>
	</div>
</main>

<?php
get_footer();
