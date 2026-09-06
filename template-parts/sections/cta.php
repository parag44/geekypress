<?php
/**
 * GeekyPress: Call to Action / Let's talk Terminal Form Section
 *
 * Replaces static description with an interactive terminal dispatch form.
 * All labels, placeholders, titles, and recipient emails are editable via Customizer.
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
$title_prefix    = get_theme_mod( 'geekypress_cta_title_prefix', "Let's talk" );
$title_highlight = get_theme_mod( 'geekypress_cta_title_highlight', 'WordPress' );
$title_suffix    = get_theme_mod( 'geekypress_cta_title_suffix', '' );
$desc            = get_theme_mod( 'geekypress_cta_description', 'Whether you have an upcoming project, need technical consultation, or just want to connect, send a terminal dispatch below.' );
$recipient_email = get_theme_mod( 'geekypress_cta_recipient_email', 'hello@example.com' );
$name_ph         = get_theme_mod( 'geekypress_cta_name_placeholder', 'Your Name or Developer Handle' );
$email_ph        = get_theme_mod( 'geekypress_cta_email_placeholder', 'your.email@example.com' );
$msg_ph          = get_theme_mod( 'geekypress_cta_msg_placeholder', 'Brief description of your project or idea...' );
$btn_text        = get_theme_mod( 'geekypress_cta_btn_text', '>_ Send Message' );
$success_msg     = get_theme_mod( 'geekypress_cta_success_msg', '[OK] Opening your email client to dispatch...' );
?>

<div id="cta" class="wp-block-group terminal-panel terminal-bottom-panel terminal-cta-section terminal-cta">
	<div class="terminal-section-header">
		<?php if ( ! empty( $label ) ) : ?>
			<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
		<?php endif; ?>

		<h2 class="wp-block-heading section-title">
			<?php echo esc_html( $title_prefix ); ?> <mark><?php echo esc_html( $title_highlight ); ?></mark><?php if ( ! empty( $title_suffix ) ) : ?><br><?php echo esc_html( $title_suffix ); ?><?php endif; ?><span class="terminal-title-cursor" aria-hidden="true">_</span>
		</h2>
	</div>

	<div class="terminal-cta-content">
		<?php if ( ! empty( $desc ) ) : ?>
			<p class="content-text terminal-cta-desc"><?php echo esc_html( $desc ); ?></p>
		<?php endif; ?>

		<form id="gp-terminal-contact-form" class="gp-terminal-form" data-recipient="<?php echo esc_attr( $recipient_email ); ?>" data-success="<?php echo esc_attr( $success_msg ); ?>">
			<div class="gp-form-row">
				<div class="gp-form-field">
					<label for="gp_sender_name" class="gp-field-label">
						<span class="gp-field-prompt">&gt;</span> <?php esc_html_e( 'NAME:', 'geekypress' ); ?>
					</label>
					<input type="text" id="gp_sender_name" name="gp_sender_name" class="gp-terminal-input" placeholder="<?php echo esc_attr( $name_ph ); ?>" required autocomplete="name">
				</div>

				<div class="gp-form-field">
					<label for="gp_sender_email" class="gp-field-label">
						<span class="gp-field-prompt">&gt;</span> <?php esc_html_e( 'EMAIL:', 'geekypress' ); ?>
					</label>
					<input type="email" id="gp_sender_email" name="gp_sender_email" class="gp-terminal-input" placeholder="<?php echo esc_attr( $email_ph ); ?>" required autocomplete="email">
				</div>
			</div>

			<div class="gp-form-field gp-form-field-msg">
				<label for="gp_sender_message" class="gp-field-label">
					<span class="gp-field-prompt">&gt;</span> <?php esc_html_e( 'MESSAGE / INQUIRY:', 'geekypress' ); ?>
				</label>
				<textarea id="gp_sender_message" name="gp_sender_message" class="gp-terminal-textarea" rows="3" placeholder="<?php echo esc_attr( $msg_ph ); ?>" required></textarea>
			</div>

			<div class="gp-form-actions">
				<button type="submit" class="wp-block-button__link wp-element-button gp-terminal-submit-btn">
					<span class="gp-btn-text"><?php echo esc_html( $btn_text ); ?></span>
					<span class="gp-btn-icon" aria-hidden="true"><?php echo geekypress_get_icon( 'send', '', 16 ); ?></span>
				</button>
				<div class="gp-form-status" aria-live="polite"></div>
			</div>
		</form>
	</div>
</div>
