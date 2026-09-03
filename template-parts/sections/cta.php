<?php
/**
 * GeekyPress: Call to Action Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cta_enabled = get_theme_mod( 'geekypress_cta_enabled', true );
if ( ! $cta_enabled ) {
	return;
}

$label           = get_theme_mod( 'geekypress_cta_label', '// START A CONVERSATION' );
$title_prefix    = get_theme_mod( 'geekypress_cta_title_prefix', 'Ready to build something' );
$title_highlight = get_theme_mod( 'geekypress_cta_title_highlight', 'extraordinary' );
$title_suffix    = get_theme_mod( 'geekypress_cta_title_suffix', 'together?' );
$desc            = get_theme_mod( 'geekypress_cta_description', 'Whether you have an upcoming project, need technical consultation, or just want to connect, my inbox is open.' );
$btn_text        = get_theme_mod( 'geekypress_cta_btn_text', '>_ Send an Email' );
$btn_url         = get_theme_mod( 'geekypress_cta_btn_url', 'mailto:hello@example.com' );
?>

<div class="wp-block-group alignwide terminal-panel terminal-cta terminal-section">
	<?php if ( ! empty( $label ) ) : ?>
		<p class="has-text-align-center terminal-label"><?php echo esc_html( $label ); ?></p>
	<?php endif; ?>

	<h2 class="wp-block-heading has-text-align-center section-title">
		<?php echo esc_html( $title_prefix ); ?> <mark><?php echo esc_html( $title_highlight ); ?></mark><br><?php echo esc_html( $title_suffix ); ?>
	</h2>

	<?php if ( ! empty( $desc ) ) : ?>
		<p class="has-text-align-center content-text"><?php echo esc_html( $desc ); ?></p>
	<?php endif; ?>

	<?php if ( ! empty( $btn_text ) ) : ?>
		<div class="wp-block-buttons" style="justify-content:center;">
			<div class="wp-block-button">
				<a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( $btn_url ); ?>"><?php echo esc_html( $btn_text ); ?></a>
			</div>
		</div>
	<?php endif; ?>
</div>
