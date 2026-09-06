<?php
/**
 * GeekyPress: Stats & Impact Section
 *
 * Renders key developer and impact metrics in terminal aesthetic cards.
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$stats_enabled = get_theme_mod( 'geekypress_stats_enabled', true );
if ( ! $stats_enabled ) {
	return;
}

$label = get_theme_mod( 'geekypress_stats_label', '// METRICS & IMPACT' );
$title = get_theme_mod( 'geekypress_stats_title', 'Impact by the Numbers' );
$desc  = get_theme_mod( 'geekypress_stats_desc', 'Tangible engineering metrics, reliable project track records, and milestones from years of shipping code.' );

$stats = geekypress_get_repeater_data(
	'geekypress_stats_items',
	array(
		array(
			'value'       => '50+',
			'title'       => 'Projects Completed',
			'description' => 'Web applications, open source plugins, & developer tools delivered worldwide.',
			'icon'        => 'folder-git-2',
		),
		array(
			'value'       => '5+',
			'title'       => 'Years of Experience',
			'description' => 'Specializing in full-stack architecture, performance, & resilient systems.',
			'icon'        => 'clock',
		),
		array(
			'value'       => '100%',
			'title'       => 'Client Satisfaction',
			'description' => 'Commitment to clean communication, rigorous testing, & high-standard delivery.',
			'icon'        => 'check-circle',
		),
		array(
			'value'       => '∞',
			'title'       => 'Lines of Clean Code',
			'description' => 'Built with caffeine, curiosity, maintainable architecture, & clean git commits.',
			'icon'        => 'code',
		),
	)
);
?>

<section id="stats" class="wp-block-group alignwide terminal-section gp-stats-section">
	<div class="terminal-section-header gp-stats-header">
		<?php if ( ! empty( $label ) ) : ?>
			<p class="terminal-label gp-stats-label"><?php echo esc_html( $label ); ?></p>
		<?php endif; ?>

		<h2 class="wp-block-heading section-title gp-stats-title">
			<?php echo esc_html( $title ); ?><span class="gp-stats-cursor" aria-hidden="true">_</span>
		</h2>

		<?php if ( ! empty( $desc ) ) : ?>
			<p class="content-text gp-stats-desc"><?php echo esc_html( $desc ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $stats ) && is_array( $stats ) ) : ?>
		<div class="gp-stats-grid">
			<?php foreach ( $stats as $stat ) : ?>
				<?php
				$s_val   = isset( $stat['value'] ) ? $stat['value'] : '0';
				$s_title = isset( $stat['title'] ) ? $stat['title'] : '';
				$s_desc  = isset( $stat['description'] ) ? $stat['description'] : '';
				$s_icon  = ! empty( $stat['icon'] ) ? $stat['icon'] : 'activity';
				?>
				<div class="gp-stat-card terminal-panel">
					<div class="gp-stat-card-top">
						<div class="gp-stat-badge">
							<?php echo geekypress_get_icon( $s_icon, '', 22 ); ?>
						</div>
						<div class="gp-stat-number"><?php echo esc_html( $s_val ); ?></div>
					</div>

					<div class="gp-stat-card-body">
						<h3 class="gp-stat-heading"><?php echo esc_html( $s_title ); ?></h3>
						<?php if ( ! empty( $s_desc ) ) : ?>
							<p class="gp-stat-text"><?php echo esc_html( $s_desc ); ?></p>
						<?php endif; ?>
					</div>

					<div class="gp-stat-footer" aria-hidden="true">
						<span>$ status --verified</span>
						<i>●</i>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
