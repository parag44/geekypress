<?php
/**
 * GeekyPress: Work Experience Section
 *
 * @package GeekyPress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$exp_enabled = get_theme_mod( 'geekypress_experience_enabled', true );
if ( ! $exp_enabled ) {
	return;
}

$label = get_theme_mod( 'geekypress_experience_label', '// EXPERIENCE' );
$title = get_theme_mod( 'geekypress_experience_title', 'Work Experience' );

$experience = geekypress_get_repeater_data(
	'geekypress_experience_items',
	array(
		array(
			'date'        => '2023 — Present',
			'icon'        => 'dashicons-networking',
			'title'       => 'Lead Full-Stack Engineer',
			'company'     => 'Apex Cloud Systems',
			'description' => 'Architecting scalable web applications, automating deployment pipelines, and leading engineering sprints.',
		),
		array(
			'date'        => '2020 — 2023',
			'icon'        => 'dashicons-wordpress',
			'title'       => 'Senior WordPress Engineer',
			'company'     => 'CodeCraft Digital',
			'description' => 'Engineered custom plugins and performance optimizations, achieving sub-second load times for enterprise clients.',
		),
		array(
			'date'        => '2017 — 2020',
			'icon'        => 'dashicons-editor-code',
			'title'       => 'Full-Stack Web Developer',
			'company'     => 'Pixel & Binary Labs',
			'description' => 'Developed responsive web applications, integrated payment gateways, and built internal REST APIs.',
		),
	)
);
?>

<div id="experience" class="wp-block-group alignwide terminal-section">
	<?php if ( ! empty( $label ) ) : ?>
		<p class="terminal-label"><?php echo esc_html( $label ); ?></p>
	<?php endif; ?>

	<h2 class="wp-block-heading section-title"><span aria-hidden="true">&gt;</span> <?php echo esc_html( $title ); ?><i aria-hidden="true">_</i></h2>

	<?php if ( ! empty( $experience ) && is_array( $experience ) ) : ?>
		<div class="wp-block-group terminal-timeline">
			<?php foreach ( $experience as $item ) : ?>
				<?php
				$icon = ! empty( $item['icon'] ) ? $item['icon'] : '';
				if ( empty( $icon ) && ! empty( $item['badge'] ) ) {
					$icon = 'dashicons-portfolio';
				}
				if ( empty( $icon ) ) {
					$icon = 'dashicons-networking';
				}
				?>
				<div class="wp-block-group terminal-experience">
					<p class="terminal-date"><?php echo esc_html( isset( $item['date'] ) ? $item['date'] : '' ); ?></p>

					<div class="wp-block-group terminal-card">
						<span class="terminal-card-badge" aria-hidden="true">
							<span class="dashicons <?php echo esc_attr( $icon ); ?>"></span>
						</span>
						<h3 class="wp-block-heading card-title"><?php echo esc_html( isset( $item['title'] ) ? $item['title'] : '' ); ?></h3>
						<?php if ( ! empty( $item['company'] ) ) : ?>
							<p class="terminal-company"><?php echo esc_html( $item['company'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p class="content-text"><?php echo esc_html( $item['description'] ); ?></p>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
