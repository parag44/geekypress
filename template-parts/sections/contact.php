<?php
/**
 * GeekyPress: Contact & Socials Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_enabled = get_theme_mod( 'geekypress_contact_enabled', true );
if ( ! $contact_enabled ) {
	return;
}

$label    = get_theme_mod( 'geekypress_contact_label', "// LET'S CONNECT" );
$title    = get_theme_mod( 'geekypress_contact_title', 'Contact & Socials' );
$email    = get_theme_mod( 'geekypress_contact_email', 'hello@example.com' );
$phone    = get_theme_mod( 'geekypress_contact_phone', '+1 (555) 019-2834' );
$location = get_theme_mod( 'geekypress_contact_location', 'San Francisco, CA / Remote' );

$links = geekypress_get_repeater_data(
	'geekypress_contact_links',
	array(
		array( 'label' => 'LinkedIn ↗',  'url' => 'https://linkedin.com/' ),
		array( 'label' => 'GitHub ↗',    'url' => 'https://github.com/' ),
		array( 'label' => 'X ↗',         'url' => 'https://x.com/' ),
		array( 'label' => 'WordPress ↗', 'url' => 'https://profiles.wordpress.org/' ),
	)
);
?>

<div id="contact" class="wp-block-group terminal-panel terminal-bottom-panel terminal-contact-section">
	<div class="terminal-section-header">
		<?php if ( ! empty( $label ) ) : ?>
			<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
		<?php endif; ?>

		<h2 class="wp-block-heading section-title"><?php echo esc_html( $title ); ?><span class="terminal-title-cursor" aria-hidden="true">_</span></h2>
	</div>

	<div class="terminal-contact">
		<?php if ( ! empty( $email ) ) : ?>
			<?php $clean_email = sanitize_email( $email ); ?>
			<a class="terminal-contact-email" href="mailto:<?php echo esc_attr( $clean_email ); ?>">@　<?php echo esc_html( antispambot( $clean_email ) ); ?></a>
		<?php endif; ?>

		<?php if ( ! empty( $phone ) ) : ?>
			<a class="terminal-contact-phone" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">⌕　<?php echo esc_html( $phone ); ?></a>
		<?php endif; ?>

		<?php if ( ! empty( $location ) ) : ?>
			<span class="terminal-contact-location">⌖　<?php echo esc_html( $location ); ?></span>
		<?php endif; ?>

		<?php if ( ! empty( $links ) && is_array( $links ) ) : ?>
			<nav aria-label="<?php esc_attr_e( 'Social profiles', 'geekypress' ); ?>">
				<?php foreach ( $links as $link ) : ?>
					<?php if ( ! empty( $link['url'] ) ) : ?>
						<a href="<?php echo esc_url( $link['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( isset( $link['label'] ) ? $link['label'] : '' ); ?></a>
					<?php endif; ?>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>
	</div>
</div>
