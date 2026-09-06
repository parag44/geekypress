<?php
/**
 * The template for displaying the footer
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$copyright   = get_theme_mod( 'geekypress_footer_copyright', '© ' . gmdate( 'Y' ) . ' <strong>Alex Morgan</strong>. All rights reserved.' );
$credit      = get_theme_mod( 'geekypress_footer_credit', 'Built with <strong>WordPress</strong>.' );
$back_to_top = get_theme_mod( 'geekypress_back_to_top', true );
?>

<footer class="wp-block-group alignfull terminal-site-footer">
	<div class="wp-block-group alignwide" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
		<p class="terminal-copyright"><?php echo wp_kses_post( $copyright ); ?></p>
		<p class="terminal-credit"><?php echo wp_kses_post( $credit ); ?></p>
	</div>
</footer>

</div><!-- .wp-site-blocks -->

<?php if ( $back_to_top ) : ?>
	<button type="button" class="terminal-back-top" id="terminal-back-top" aria-label="<?php esc_attr_e( 'Back to top', 'geekypress' ); ?>" title="<?php esc_attr_e( 'Back to top', 'geekypress' ); ?>">↑</button>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>
