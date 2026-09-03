<?php
/**
 * GeekyPress: About Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about_enabled = get_theme_mod( 'geekypress_about_enabled', true );
if ( ! $about_enabled ) {
	return;
}

$label     = get_theme_mod( 'geekypress_about_label', '// ABOUT_ME' );
$heading   = get_theme_mod( 'geekypress_about_heading', "Engineering clean code\nand scalable systems." );
$p1        = get_theme_mod( 'geekypress_about_p1', "Hi, I'm Alex Morgan — a full-stack engineer and open source contributor passionate about crafting resilient web applications and developer tools." );
$p2        = get_theme_mod( 'geekypress_about_p2', "I specialize in TypeScript, modern PHP, WordPress architecture, and cloud infrastructure, building systems that scale smoothly under pressure." );
$p3        = get_theme_mod( 'geekypress_about_p3', "I believe in writing maintainable code, automating repetitive workflows, and designing intuitive developer experiences." );
$signature = get_theme_mod( 'geekypress_about_signature', '— Alex Morgan' );

$stats = geekypress_get_repeater_data(
	'geekypress_about_stats',
	array(
		array( 'icon' => 'dashicons-clock',       'title' => '10+ Years',   'description' => 'Engineering experience' ),
		array( 'icon' => 'dashicons-portfolio',   'title' => '50+ Projects', 'description' => 'Delivered worldwide' ),
		array( 'icon' => 'dashicons-shield',      'title' => '99.9% Uptime', 'description' => 'Reliability track record' ),
		array( 'icon' => 'dashicons-networking',  'title' => '100% Remote',  'description' => 'Async collaboration' ),
	)
);
?>

<div id="about" class="wp-block-group alignwide terminal-panel terminal-about terminal-section">
	<div class="wp-block-columns are-vertically-aligned-center">

		<div class="wp-block-column is-vertically-aligned-center">
			<?php if ( ! empty( $label ) ) : ?>
				<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
			<?php endif; ?>

			<h2 class="wp-block-heading section-title"><?php echo nl2br( esc_html( $heading ) ); ?></h2>

			<?php if ( ! empty( $p1 ) ) : ?>
				<p class="content-text terminal-about-p1"><?php echo esc_html( $p1 ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $p2 ) ) : ?>
				<p class="content-text terminal-about-p2"><?php echo esc_html( $p2 ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $p3 ) ) : ?>
				<p class="content-text terminal-about-p3"><?php echo esc_html( $p3 ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $signature ) ) : ?>
				<p class="terminal-signature"><?php echo esc_html( $signature ); ?></p>
			<?php endif; ?>
		</div>

		<div class="wp-block-column is-vertically-aligned-center">
			<?php if ( ! empty( $stats ) && is_array( $stats ) ) : ?>
				<div class="wp-block-group terminal-stat-grid">
					<?php foreach ( $stats as $stat ) : ?>
						<p>
							<b>
								<span class="dashicons <?php echo esc_attr( ! empty( $stat['icon'] ) ? $stat['icon'] : 'dashicons-star-filled' ); ?>" aria-hidden="true"></span>
								<?php echo esc_html( isset( $stat['title'] ) ? $stat['title'] : '' ); ?>
							</b>
							<br><?php echo esc_html( isset( $stat['description'] ) ? $stat['description'] : '' ); ?>
						</p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

	</div>
</div>
