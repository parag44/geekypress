<?php
/**
 * GeekyPress: Interests & Curiosities Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$int_enabled = get_theme_mod( 'geekypress_interests_enabled', true );
if ( ! $int_enabled ) {
	return;
}

$label = get_theme_mod( 'geekypress_interests_label', '// BEYOND THE TICKET QUEUE' );
$title = get_theme_mod( 'geekypress_interests_title', 'Interests & Curiosities' );

$interests = geekypress_get_repeater_data(
	'geekypress_interests_items',
	array(
		array(
			'icon'        => 'dashicons-wordpress',
			'title'       => 'WordPress & Open Source',
			'description' => 'Learning, contributing, and sharing practical knowledge with the community.',
		),
		array(
			'icon'        => 'dashicons-editor-code',
			'title'       => 'Support Systems',
			'description' => 'Improving tools, documentation, recovery paths, and reliable workflows.',
		),
		array(
			'icon'        => 'dashicons-lightbulb',
			'title'       => 'Thoughtful AI Products',
			'description' => 'Exploring useful AI products with privacy and human control in focus.',
		),
		array(
			'icon'        => 'dashicons-location',
			'title'       => 'Travel & Technology',
			'description' => 'Exploring new places and capturing stories through technology.',
		),
	)
);
?>

<div id="interests" class="wp-block-group terminal-panel terminal-bottom-panel">
	<?php if ( ! empty( $label ) ) : ?>
		<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
	<?php endif; ?>

	<h2 class="wp-block-heading section-title"><?php echo esc_html( $title ); ?></h2>

	<?php if ( ! empty( $interests ) && is_array( $interests ) ) : ?>
		<div class="wp-block-group terminal-list">
			<?php foreach ( $interests as $item ) : ?>
				<?php
				$icon = ! empty( $item['icon'] ) ? $item['icon'] : '';
				if ( empty( $icon ) && ! empty( $item['badge'] ) ) {
					// Fallback for previous text badges
					$icon = 'dashicons-star-filled';
				}
				if ( empty( $icon ) ) {
					$icon = 'dashicons-wordpress';
				}
				?>
				<p class="content-text">
					<span class="terminal-list-badge" aria-hidden="true">
						<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
					</span>
					<b><?php echo esc_html( isset( $item['title'] ) ? $item['title'] : '' ); ?></b><br>
					<?php echo esc_html( isset( $item['description'] ) ? $item['description'] : '' ); ?>
				</p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
